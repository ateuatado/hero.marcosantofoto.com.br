<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2><?= esc($title) ?></h2>
    <a href="<?= site_url('admin/packages') ?>" class="btn btn-sm btn-outline-secondary">Voltar</a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card bg-dark text-white border-secondary">
    <div class="card-body">
        <?php $isEdit = isset($package); ?>
        <form action="<?= $isEdit ? site_url('admin/packages/' . $package->id) : site_url('admin/packages') ?>" method="post">
            <?php if ($isEdit): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>
            
            <div class="mb-3">
                <label class="form-label">Nome do Pacote</label>
                <input type="text" name="name" class="form-control bg-dark text-white" value="<?= old('name', $package->name ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Valor Base (R$)</label>
                <input type="number" step="0.01" name="base_price" class="form-control bg-dark text-white" value="<?= old('base_price', $package->base_price ?? '0.00') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Qtd. de Fotos Inclusas</label>
                <input type="number" name="included_photos" class="form-control bg-dark text-white" value="<?= old('included_photos', $package->included_photos ?? '') ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Valor da Foto Extra (R$)</label>
                <input type="number" step="0.01" name="extra_photo_price" class="form-control bg-dark text-white" value="<?= old('extra_photo_price', $package->extra_photo_price ?? '0.00') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Pacote</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
