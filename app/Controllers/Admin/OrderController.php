<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PackageModel;

class OrderController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();

        $status = $this->request->getGet('status') ?? '';

        $builder = $orderModel->orderBy('created_at', 'DESC');
        if ($status && in_array($status, ['pending', 'approved', 'cancelled', 'refunded'])) {
            $builder->where('status', $status);
        }

        $orders  = $builder->paginate(20);
        $pager   = $orderModel->pager;
        $summary = (new OrderModel())->summary();

        return view('admin/orders/index', [
            'orders'  => $orders,
            'pager'   => $pager,
            'summary' => $summary,
            'filter'  => $status,
            'title'   => 'Pedidos',
        ]);
    }

    public function show($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Pedido não encontrado.');
        }

        $package = null;
        if ($order->package_id) {
            $package = (new PackageModel())->find($order->package_id);
        }

        return view('admin/orders/show', [
            'order'   => $order,
            'package' => $package,
            'title'   => 'Pedido #' . $id,
        ]);
    }
}
