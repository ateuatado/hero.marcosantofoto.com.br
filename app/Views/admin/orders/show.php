<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?= site_url('admin/orders') ?>" class="text-muted text-decoration-none small">← Pedidos</a>
        <h2 class="text-warning fw-bold text-uppercase mb-0">Pedido #<?= $order->id ?></h2>
    </div>
    <?php
    $badges = ['approved'=>'success','pending'=>'warning','cancelled'=>'danger','refunded'=>'secondary'];
    $labels = ['approved'=>'Aprovado','pending'=>'Pendente','cancelled'=>'Cancelado','refunded'=>'Reembolsado'];
    $badge  = $badges[$order->status] ?? 'secondary';
    $label  = $labels[$order->status] ?? $order->status;
    ?>
    <span class="badge bg-<?= $badge ?> fs-6"><?= $label ?></span>
</div>

<div class="row g-4">
    <!-- Dados do cliente -->
    <div class="col-md-6">
        <div class="card bg-dark border-secondary h-100">
            <div class="card-header border-secondary text-warning text-uppercase small fw-bold">
                Cliente
            </div>
            <div class="card-body">
                <table class="table table-dark table-sm mb-0">
                    <tr><td class="text-muted" width="35%">Nome</td><td class="fw-bold"><?= esc($order->buyer_name) ?></td></tr>
                    <tr><td class="text-muted">E-mail</td><td><?= esc($order->buyer_email) ?></td></tr>
                    <tr><td class="text-muted">WhatsApp</td><td><?= esc($order->buyer_phone ?: '—') ?></td></tr>
                    <tr><td class="text-muted">Data</td><td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td></tr>
                </table>
                <!-- Botão WhatsApp -->
                <?php if ($order->buyer_phone): ?>
                <?php $wa = 'https://wa.me/55' . preg_replace('/\D/', '', $order->buyer_phone); ?>
                <a href="<?= $wa ?>" target="_blank" class="btn btn-outline-success btn-sm mt-3">
                    📱 Abrir WhatsApp
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Dados do pedido -->
    <div class="col-md-6">
        <div class="card bg-dark border-secondary h-100">
            <div class="card-header border-secondary text-warning text-uppercase small fw-bold">
                Pedido
            </div>
            <div class="card-body">
                <table class="table table-dark table-sm mb-0">
                    <tr>
                        <td class="text-muted" width="40%">Pacote</td>
                        <td><?= $package ? esc($package->name) : '<span class="text-muted">ID ' . $order->package_id . '</span>' ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Valor</td>
                        <td class="fw-bold text-success fs-5">R$ <?= number_format($order->amount, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge bg-<?= $badge ?>"><?= $label ?></span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Preference MP</td>
                        <td class="small font-monospace text-muted"><?= esc($order->mp_preference_id ?: '—') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Payment MP</td>
                        <td class="small font-monospace">
                            <?php if ($order->mp_payment_id): ?>
                            <a href="https://www.mercadopago.com.br/activities/search?search_term=<?= $order->mp_payment_id ?>"
                               target="_blank" class="text-info"><?= $order->mp_payment_id ?></a>
                            <?php else: ?>
                            <span class="text-muted">Aguardando pagamento</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Payload bruto do MP (colapsável) -->
    <?php if ($order->mp_raw): ?>
    <div class="col-12">
        <div class="card bg-dark border-secondary">
            <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                <span class="text-muted small text-uppercase">Dados brutos MercadoPago</span>
                <button class="btn btn-sm btn-outline-secondary" type="button"
                        data-bs-toggle="collapse" data-bs-target="#rawPayload">
                    Expandir
                </button>
            </div>
            <div id="rawPayload" class="collapse">
                <div class="card-body">
                    <pre class="text-muted small mb-0" style="max-height:300px;overflow:auto"><?= esc(json_encode(json_decode($order->mp_raw), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
