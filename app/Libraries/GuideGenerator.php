<?php

namespace App\Libraries;

use App\Models\GuideSectionModel;
use App\Models\CategoryModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class GuideGenerator
{
    /**
     * Gera o PDF do guia pré-ensaio personalizado.
     *
     * @param string      $clientName  Nome do cliente
     * @param string      $clientEmail Email do cliente
     * @param int|null    $categoryId  ID da categoria/nicho (null = universal only)
     * @param string      $shootDate   Data do ensaio formatada
     * @return string     Conteúdo binário do PDF
     */
    public function generate(string $clientName, string $clientEmail, ?int $categoryId = null, string $shootDate = ''): string
    {
        $model    = new GuideSectionModel();
        $sections = $model->getForCategory($categoryId);

        // Tipo de ensaio
        $shootType = '';
        if ($categoryId) {
            $catModel  = new CategoryModel();
            $cat       = $catModel->find($categoryId);
            $shootType = $cat ? $cat->name : '';
        }

        if (empty($shootDate)) {
            $shootDate = date('d/m/Y');
        }

        // Renderiza o HTML do template
        $html = view('pdf/guide', [
            'clientName' => $clientName,
            'clientEmail'=> $clientEmail,
            'shootType'  => $shootType,
            'shootDate'  => $shootDate,
            'sections'   => $sections,
        ]);

        // Gera PDF via DOMPDF
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
