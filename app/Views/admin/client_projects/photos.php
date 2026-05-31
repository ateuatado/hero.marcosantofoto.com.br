<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Fotos Selecionadas - Projeto #<?= esc($project->id) ?></h2>
    <a href="<?= site_url('admin/client-projects') ?>" class="btn btn-outline-secondary">Voltar aos Projetos</a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-dark text-white border-secondary h-100">
            <div class="card-body">
                <h5 class="text-gold brand-font">Resumo do Pacote</h5>
                <ul class="list-unstyled mb-0">
                    <li>Pacote: <strong><?= esc($package->name) ?></strong></li>
                    <li>Fotos Inclusas: <strong><?= esc($package->included_photos) ?></strong></li>
                    <li>Fotos Selecionadas: <strong><?= esc(count($selectedPhotos)) ?></strong></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card bg-dark text-white border-secondary h-100">
            <div class="card-body">
                <h5 class="text-gold brand-font">Ações de Entrega</h5>
                <p class="text-muted small">Copie a lista de IDs abaixo para filtrar rapidamente no Lightroom ou DaVinci e exportar as fotos finais em alta resolução.</p>
                <?php 
                    // Extrai apenas os nomes dos arquivos ou IDs para facilitar o filtro do fotógrafo
                    $fileNames = array_map(function($p) { return basename($p->s3_key); }, $selectedPhotos);
                    $filterString = implode(', ', $fileNames);
                ?>
                <textarea class="form-control bg-black text-white border-secondary mb-3" rows="2" readonly><?= esc($filterString) ?></textarea>
                
                <button class="btn btn-primary" onclick="alert('Funcionalidade de upload para o S3 em breve.')">
                    <i class="fas fa-cloud-upload-alt me-2"></i> Fazer Upload das Fotos Finais
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card bg-dark text-white border-secondary">
    <div class="card-body">
        <h4 class="mb-4">Galeria de Selecionadas</h4>
        
        <?php if (!empty($selectedPhotos)): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php foreach ($selectedPhotos as $photo): ?>
                    <div class="col">
                        <div class="card bg-black border-secondary h-100">
                            <!-- Placeholder, seria a proxy_url do S3 -->
                            <img src="<?= base_url('uploads/placeholder.jpg') ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Proxy">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted"><?= esc(basename($photo->s3_key)) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted text-center py-4">Nenhuma foto selecionada pelo cliente ainda.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
