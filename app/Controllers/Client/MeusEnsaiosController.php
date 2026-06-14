<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientProjectModel;
use App\Models\OrderModel;
use App\Models\PackageModel;

class MeusEnsaiosController extends BaseController
{
    /**
     * Dashboard unificado do cliente: compras + galerias.
     */
    public function index()
    {
        $user    = auth()->user();
        $userId  = auth()->id();
        $email   = $user->email;

        // ── Compras / Agendamentos (orders aprovadas do e-mail do usuário) ──
        $orderModel = new OrderModel();
        $orders = $orderModel
            ->where('buyer_email', $email)
            ->whereIn('status', ['approved', 'pending'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Carrega nomes dos pacotes
        $packageModel = new PackageModel();
        foreach ($orders as &$order) {
            $order->package = $order->package_id ? $packageModel->find($order->package_id) : null;
        }
        unset($order);

        // ── Galerias de fotos (projetos vinculados ao user_id) ──
        $projectModel = new ClientProjectModel();
        $projects = $projectModel->where('user_id', $userId)->findAll();

        foreach ($projects as &$proj) {
            $proj->package = $proj->package_id ? $packageModel->find($proj->package_id) : null;
        }
        unset($proj);

        return view('client/meus_ensaios', [
            'title'    => 'Meus Ensaios',
            'orders'   => $orders,
            'projects' => $projects,
        ]);
    }
}
