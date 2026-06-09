<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageModel;

class PackageCheckout extends BaseController
{
    /**
     * Recebe a escolha do pacote, salva a intenção e redireciona para o MercadoPago.
     * POST /comprar-ensaio
     */
    public function buy()
    {
        $packageId  = (int) $this->request->getPost('package_id');
        $heroId     = (int) $this->request->getPost('hero_id');
        $name       = trim($this->request->getPost('name'));
        $email      = trim($this->request->getPost('email'));
        $phone      = trim($this->request->getPost('phone'));

        // Validação básica
        if (!$packageId || !$name || !$email) {
            return $this->response->setJSON(['success' => false, 'message' => 'Preencha nome e e-mail.']);
        }

        $packageModel = new PackageModel();
        $package = $packageModel->find($packageId);

        if (!$package || !$package->is_active) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pacote não encontrado.']);
        }

        // Salva intenção no log (reaproveita tabela de intentions se existir, senão só loga)
        log_message('info', "Nova intenção de compra: {$name} <{$email}> ({$phone}) → Pacote #{$packageId} ({$package->name}) | Hero #{$heroId}");

        // ── Cria Preference no MercadoPago ──────────────────────────────────
        try {
            \MercadoPago\MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

            $client = new \MercadoPago\Client\Preference\PreferenceClient();

            $preferenceData = [
                'items' => [
                    [
                        'title'       => "Ensaio Fotográfico — {$package->name}",
                        'quantity'    => 1,
                        'unit_price'  => (float) $package->base_price,
                        'currency_id' => 'BRL',
                    ],
                ],
                'payer' => [
                    'name'  => $name,
                    'email' => $email,
                ],
                'back_urls' => [
                    'success' => site_url("ensaio/obrigado?pacote=" . urlencode($package->name) . "&nome=" . urlencode($name)),
                    'failure' => site_url("ensaio/falha"),
                    'pending' => site_url("ensaio/pendente"),
                ],
                'auto_return'          => 'approved',
                'external_reference'   => "ENSAIO_PKG{$packageId}_HERO{$heroId}",
                'statement_descriptor' => 'Marco Santo Foto',
            ];

            $preference = $client->create($preferenceData);

            return $this->response->setJSON([
                'success'      => true,
                'checkout_url' => $preference->init_point,
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Erro MP PackageCheckout: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao conectar com o MercadoPago. Tente novamente.',
            ]);
        }
    }

    /**
     * Recebe intenção de "falar antes de comprar" sem pagamento online.
     * POST /quero-falar
     */
    public function talkFirst()
    {
        $packageId = (int) $this->request->getPost('package_id');
        $heroId    = (int) $this->request->getPost('hero_id');
        $name      = trim($this->request->getPost('name'));
        $email     = trim($this->request->getPost('email'));
        $phone     = trim($this->request->getPost('phone'));

        if (!$name || !$email) {
            return $this->response->setJSON(['success' => false, 'message' => 'Preencha nome e e-mail.']);
        }

        $packageModel = new PackageModel();
        $package = $packageModel->find($packageId);
        $packageName = $package ? $package->name : "Não especificado";

        log_message('info', "Intenção 'Falar Antes': {$name} <{$email}> ({$phone}) → Pacote #{$packageId} ({$packageName}) | Hero #{$heroId}");

        // Salva como intenção se o model existir
        try {
            $intentModel = new \App\Models\IntentionModel();
            $intentModel->insert([
                'hero_id'    => $heroId ?: null,
                'name'       => $name,
                'email'      => $email,
                'phone'      => $phone,
                'shoot_type' => $packageName,
                'address'    => '',
                'age'        => 0,
            ]);
        } catch (\Exception $e) {
            log_message('warning', 'IntentionModel não disponível: ' . $e->getMessage());
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Recebemos seu interesse! Entraremos em contato em breve.',
        ]);
    }

    /**
     * Página de sucesso após pagamento aprovado.
     */
    public function thanks()
    {
        $pacote = urldecode($this->request->getGet('pacote') ?? '');
        $nome   = urldecode($this->request->getGet('nome') ?? '');
        return view('package_thanks', ['pacote' => $pacote, 'nome' => $nome]);
    }

    public function failure()
    {
        return view('package_thanks', ['status' => 'falha', 'pacote' => '', 'nome' => '']);
    }

    public function pending()
    {
        return view('package_thanks', ['status' => 'pendente', 'pacote' => '', 'nome' => '']);
    }
}
