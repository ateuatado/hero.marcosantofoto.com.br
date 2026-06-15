<?php

namespace App\Libraries;

use App\Models\ContractSectionModel;
use App\Models\PackageModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ContractGenerator
{
    /**
     * Generates a personalized contract PDF.
     * $orderData should contain: buyer_name, buyer_email, buyer_phone, cpf, marital_status, address, city, state, zip_code, image_usage_authorized, package_id, amount, created_at
     */
    public function generate(object $orderData): string
    {
        $model = new ContractSectionModel();
        $sections = $model->getActive();

        // Get package info
        $packageName = 'Ensaio Fotografico';
        $includedPhotos = '';
        $extraPhotoPrice = '';
        if (!empty($orderData->package_id)) {
            $pkg = (new PackageModel())->find($orderData->package_id);
            if ($pkg) {
                $packageName = $pkg->name;
                $includedPhotos = $pkg->included_photos ?? '';
                $extraPhotoPrice = $pkg->extra_photo_price ? 'R$ ' . number_format($pkg->extra_photo_price, 0, ',', '.') : 'a combinar';
            }
        }

        // Build address
        $addressParts = array_filter([
            $orderData->address ?? '',
            $orderData->city ?? '',
            ($orderData->state ?? '') ? strtoupper($orderData->state) : '',
            $orderData->zip_code ?? '',
        ]);
        $fullAddress = implode(', ', $addressParts) ?: 'a ser informado';

        // Placeholder replacements
        $replacements = [
            '{nome_cliente}' => $orderData->buyer_name ?? 'A ser informado',
            '{cpf_cliente}' => $orderData->cpf ?? '___.___.___-__',
            '{estado_civil}' => $orderData->marital_status ?? 'a ser informado',
            '{endereco_completo}' => $fullAddress,
            '{email}' => $orderData->buyer_email ?? '',
            '{telefone}' => $orderData->buyer_phone ?? '',
            '{nome_pacote}' => $packageName,
            '{valor}' => 'R$ ' . number_format((float)($orderData->amount ?? 0), 2, ',', '.'),
            '{qtd_fotos}' => $includedPhotos,
            '{valor_foto_extra}' => $extraPhotoPrice,
            '{data_contratacao}' => !empty($orderData->created_at) ? date('d/m/Y', strtotime($orderData->created_at)) : date('d/m/Y'),
            '{forma_pagamento}' => 'pagamento online (PIX ou cartao)',
            '{autorizacao_imagem}' => ($orderData->image_usage_authorized ?? null) ? 'AUTORIZA' : 'NAO AUTORIZA',
            '{numero_contrato}' => str_pad($orderData->id ?? 0, 6, '0', STR_PAD_LEFT),
        ];

        // Process sections - replace placeholders
        $processedSections = [];
        foreach ($sections as $s) {
            $processed = clone $s;
            $processed->content = str_replace(array_keys($replacements), array_values($replacements), $s->content);
            $processedSections[] = $processed;
        }

        $contractDate = !empty($orderData->created_at) ? date('d \d\e F \d\e Y', strtotime($orderData->created_at)) : date('d \d\e F \d\e Y');

        // Format content function - same as guide
        $formatContent = function (string $text): string {
            $text = esc($text);
            // Remove emojis
            $text = preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $text);
            $text = preg_replace('/[\x{2600}-\x{27BF}]/u', '', $text);
            $text = preg_replace('/[\x{FE00}-\x{FE0F}]/u', '', $text);
            // Collapse blank lines
            $text = preg_replace('/\n{3,}/', "\n\n", $text);
            $text = str_replace("\n\n", "\n", $text);
            $text = nl2br($text);
            return $text;
        };

        $html = view('pdf/contract', [
            'sections' => $processedSections,
            'contractDate' => $contractDate,
            'contractNumber' => $replacements['{numero_contrato}'],
            'clientName' => $replacements['{nome_cliente}'],
            'clientCpf' => $replacements['{cpf_cliente}'],
            'formatContent' => $formatContent,
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Inter');
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);

        $dompdf = new Dompdf($options);

        // Register Inter font
        $fontDir = WRITEPATH . 'fonts/';
        if (file_exists($fontDir . 'Inter-Regular.ttf')) {
            $fontMetrics = $dompdf->getFontMetrics();
            $fontMetrics->registerFont(
                ['family' => 'Inter', 'style' => 'normal', 'weight' => 'normal'],
                $fontDir . 'Inter-Regular.ttf'
            );
            $fontMetrics->registerFont(
                ['family' => 'Inter', 'style' => 'normal', 'weight' => 'bold'],
                $fontDir . 'Inter-Bold.ttf'
            );
            if (file_exists($fontDir . 'Inter-Italic.ttf')) {
                $fontMetrics->registerFont(
                    ['family' => 'Inter', 'style' => 'italic', 'weight' => 'normal'],
                    $fontDir . 'Inter-Italic.ttf'
                );
            }
        }

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
