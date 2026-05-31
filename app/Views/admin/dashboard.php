<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Visão Geral</h2>
        <div class="card bg-dark text-white border-secondary">
            <div class="card-body">
                <h5 class="card-title text-uppercase fw-bold text-info">Bem-vindo ao Painel Hero</h5>
                <p class="card-text text-light">Aqui você constrói as páginas e gerencia os heróis das suas fotografias esportivas de alta performance.</p>
                <hr class="border-secondary">
                <a href="<?= site_url('admin/heroes') ?>" class="btn btn-outline-light">Gerenciar Heróis / Atletas</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
