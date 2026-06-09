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

        log_message('info', "Nova intenção de compra: {$name} <{$email}> ({$phone}) → Pacote #{$packageId} ({$package->name}) | Hero #{$heroId}");

        // ── Lê o token — usa getenv() igual ao GaleriaController que já funciona ──
        $token = getenv('MERCADOPAGO_ACCESS_TOKEN');
        if (empty($token)) {
            $token = env('MERCADOPAGO_ACCESS_TOKEN'); // fallback CI4
        }

        if (empty($token)) {
            log_message('error', 'MERCADOPAGO_ACCESS_TOKEN nao encontrado no ambiente do servidor');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Configuração de pagamento ausente. Entre em contato.',
            ]);
        }

        // ── Cria Preference no MercadoPago ──────────────────────────────────
        try {
            \MercadoPago\MercadoPagoConfig::setAccessToken($token);

            $client = new \MercadoPago\Client\Preference\PreferenceClient();

            $nameParts = explode(' ', trim($name), 2);
            $firstName = $nameParts[0];
            $lastName  = $nameParts[1] ?? $nameParts[0];

            $preferenceData = [
                'items' => [
                    [
                        'title'       => 'Ensaio Fotografico - ' . $package->name,
                        'quantity'    => 1,
                        'unit_price'  => (float) $package->base_price,
                        'currency_id' => 'BRL',
                    ],
                ],
                'payer' => [
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email'      => $email,
                ],
                'back_urls' => [
                    'success' => site_url("ensaio/obrigado?pacote=" . urlencode($package->name) . "&nome=" . urlencode($name)),
                    'failure' => site_url("ensaio/falha"),
                    'pending' => site_url("ensaio/pendente"),
                ],
                'external_reference' => "PKG{$packageId}_HERO{$heroId}",
            ];

            $preference = $client->create($preferenceData);

            return $this->response->setJSON([
                'success'      => true,
                'checkout_url' => $preference->init_point,
            ]);

        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            $apiResponse = $e->getApiResponse();
            $statusCode  = $apiResponse ? $apiResponse->getStatusCode() : 0;
            $content     = $apiResponse ? $apiResponse->getContent() : [];
            log_message('error', 'Erro MP API ' . $statusCode . ': ' . json_encode($content));
            $cause   = $content['cause'][0] ?? null;
            $details = $cause
                ? ($cause['description'] ?? $cause['code'] ?? json_encode($cause))
                : ($content['message'] ?? json_encode($content));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro MP ' . $statusCode . ': ' . $details,
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Erro MP Geral: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro de conexão: ' . $e->getMessage(),
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

    public function thanks()
    {
        $pacote = urldecode($this->request->getGet('pacote') ?? '');
        $nome   = urldecode($this->request->getGet('nome') ?? '');
        return view('package_thanks', ['pacote' => $pacote, 'nome' => $nome, 'status' => 'success']);
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
