<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= site_url('admin/heroes') ?>" class="btn btn-outline-secondary">&larr; Voltar para Heróis</a>
</div>

<?= view('admin/heroes/_nav', ['hero' => $hero, 'active' => 'photos', 'title' => 'Galeria']) ?>

<div class="row">
    <div class="col-md-4">
        <!-- Objeto de Upload -->
        <div class="card bg-dark text-white border-secondary mb-4">
            <div class="card-header border-secondary">Nova Foto</div>
            <div class="card-body">
                <form action="<?= site_url('admin/heroes/' . $hero['id'] . '/photos') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Arquivo de Imagem</label>
                        <input type="file" class="form-control bg-black text-white border-secondary" name="photo" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Legenda Épica</label>
                        <textarea class="form-control bg-black text-white border-secondary" name="caption" rows="4" placeholder="Ex: Viveu até os 60 anos sem praticar exercícios e hoje..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordem de Exibição</label>
                        <input type="number" class="form-control bg-black text-white border-secondary" name="display_order" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Fazer Upload</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Lista de Fotos -->
        <div class="row g-3">
            <?php if(!empty($photos)): ?>
                <?php foreach($photos as $photo): ?>
                <div class="col-md-6">
                    <div class="card bg-black border-secondary h-100 text-white">
                        <img src="<?= base_url($photo['image_path']) ?>" class="card-img-top" alt="Foto" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text small text-muted"><?= esc($photo['caption']) ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge bg-secondary">Ordem: <?= $photo['display_order'] ?></span>
                                <form action="<?= site_url('admin/heroes/photos/' . $photo['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta imagem?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p>Nenhuma foto enviada ainda.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
