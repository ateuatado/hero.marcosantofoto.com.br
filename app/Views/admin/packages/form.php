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
                <input type="number" step="0.01" name="base_price" class="form-control bg-dark text-white border-secondary" value="<?= old('base_price', $package->base_price ?? '0.00') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição do Pacote (Visível para o cliente no site)</label>
                <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Descreva os benefícios e o que inclui o pacote..."><?= old('description', $package->description ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Observações Internas (Exclusivo da equipe - O cliente NÃO vê)</label>
                <textarea name="internal_notes" class="form-control bg-dark text-white border-secondary" rows="2" placeholder="Notas sobre custos, produção ou agenda..."><?= old('internal_notes', $package->internal_notes ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Qtd. de Fotos Inclusas</label>
                <input type="number" name="included_photos" class="form-control bg-dark text-white border-secondary" value="<?= old('included_photos', $package->included_photos ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Foto Extra (R$)</label>
                <input type="number" step="0.01" name="extra_photo_price" class="form-control bg-dark text-white border-secondary" value="<?= old('extra_photo_price', $package->extra_photo_price ?? '0.00') ?>" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" <?= old('is_active', $package->is_active ?? 1) == 1 ? 'checked' : '' ?>>
                <label class="form-check-label text-white-50" for="is_active">Status da Publicação (Disponível e ativo no site)</label>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="is_preferred" class="form-check-input" id="is_preferred" value="1" <?= old('is_preferred', $package->is_preferred ?? 0) == 1 ? 'checked' : '' ?>>
                <label class="form-check-label text-white-50" for="is_preferred">Pacote Destaque / Preferido (Ancoragem de preço)</label>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Pacote</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
