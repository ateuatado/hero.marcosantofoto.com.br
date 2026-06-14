<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= site_url('admin/heroes') ?>" class="btn btn-outline-secondary">&larr; Voltar para Heróis</a>
</div>

<h2 class="text-info fw-bold text-uppercase mb-1">Galeria: <?= esc($hero['name']) ?></h2>
<?php if (!empty($hero['cover_photo_id'])): ?>
    <p class="text-muted small mb-4">
        <span class="badge bg-warning text-dark">&#9733; Capa definida</span>
        <span class="ms-2 opacity-50">ID da foto de capa: <?= $hero['cover_photo_id'] ?></span>
    </p>
<?php else: ?>
    <p class="text-warning small mb-4">Nenhuma foto de capa definida — o card no portfólio ficará sem imagem.</p>
<?php endif; ?>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
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
                        <textarea class="form-control bg-black text-white border-secondary" name="caption" rows="3" placeholder="Ex: Viveu até os 60 anos sem praticar exercícios e hoje..."></textarea>
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
        <div class="row g-3">
            <?php if (!empty($photos)): ?>
                <?php foreach ($photos as $photo): ?>
                <?php $isCover = ($photo['id'] == ($hero['cover_photo_id'] ?? null)); ?>
                <div class="col-md-6">
                    <div class="card h-100 text-white border-secondary <?= $isCover ? 'border-warning' : 'bg-black' ?>" id="photo-card-<?= $photo['id'] ?>">
                        <?php if ($isCover): ?>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">&#9733; Capa</span>
                            </div>
                        <?php endif; ?>
                        <img src="<?= base_url($photo['image_path']) ?>"
                             class="card-img-top"
                             alt="Foto"
                             style="height:200px; object-fit:cover; <?= $isCover ? 'opacity:1' : 'opacity:0.85' ?>">
                        <div class="card-body pb-2">
                            <!-- ── Legenda editável ── -->
                            <div class="mb-2">
                                <label class="form-label text-muted small mb-1" style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;">Legenda</label>
                                <textarea class="form-control form-control-sm bg-black text-white border-secondary photo-caption-input"
                                          id="caption-<?= $photo['id'] ?>"
                                          rows="3"
                                          style="font-size:.8rem;resize:vertical;"><?= esc($photo['caption']) ?></textarea>
                            </div>
                            <!-- ── Ordem editável ── -->
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <label class="text-muted small mb-0" style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;white-space:nowrap;">Ordem</label>
                                <input type="number" class="form-control form-control-sm bg-black text-white border-secondary photo-order-input"
                                       id="order-<?= $photo['id'] ?>"
                                       value="<?= $photo['display_order'] ?>"
                                       style="width:70px;font-size:.8rem;">
                                <button type="button" class="btn btn-sm btn-outline-success ms-auto"
                                        onclick="savePhoto(<?= $photo['id'] ?>)" title="Salvar alterações">
                                    ✓ Salvar
                                </button>
                            </div>
                            <!-- ── Feedback ── -->
                            <div id="feedback-<?= $photo['id'] ?>" class="small" style="display:none;"></div>
                        </div>
                        <div class="card-footer bg-transparent border-secondary d-flex gap-2">
                            <?php if (!$isCover): ?>
                                <!-- Definir como capa -->
                                <form action="<?= site_url("admin/heroes/{$hero['id']}/photos/{$photo['id']}/cover") ?>" method="post" class="flex-fill">
                                    <button type="submit" class="btn btn-sm btn-outline-warning w-100">
                                        &#9733; Definir Capa
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="btn btn-sm btn-warning w-100 disabled">&#9733; Capa Atual</span>
                            <?php endif; ?>
                            <!-- Excluir -->
                            <form action="<?= site_url('admin/heroes/photos/' . $photo['id'] . '/delete') ?>" method="post"
                                  onsubmit="return confirm('Excluir esta foto?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">&#128465;</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>Nenhuma foto enviada ainda.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── Script de edição AJAX ── -->
<script>
function savePhoto(photoId) {
    const caption = document.getElementById('caption-' + photoId).value;
    const order   = document.getElementById('order-' + photoId).value;
    const fb      = document.getElementById('feedback-' + photoId);
    const btn     = event.target;

    btn.disabled = true;
    btn.textContent = '...';

    const formData = new FormData();
    formData.append('caption', caption);
    formData.append('display_order', order);

    fetch('<?= site_url("admin/heroes/photos") ?>/' + photoId + '/update', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        fb.style.display = 'block';
        if (data.success) {
            fb.className = 'small text-success';
            fb.textContent = '✓ Salvo!';
        } else {
            fb.className = 'small text-danger';
            fb.textContent = '✗ ' + (data.message || 'Erro');
        }
        btn.disabled = false;
        btn.textContent = '✓ Salvar';
        setTimeout(() => { fb.style.display = 'none'; }, 2500);
    })
    .catch(() => {
        fb.style.display = 'block';
        fb.className = 'small text-danger';
        fb.textContent = '✗ Erro de conexão';
        btn.disabled = false;
        btn.textContent = '✓ Salvar';
        setTimeout(() => { fb.style.display = 'none'; }, 2500);
    });
}
</script>
<?= $this->endSection() ?>
