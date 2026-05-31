<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-info fw-bold text-uppercase">Heróis</h2>
    <a href="<?= site_url('admin/heroes/new') ?>" class="btn btn-primary">Cadastrar Novo</a>
</div>

<div class="card bg-dark text-white border-secondary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Esporte</th>
                        <th>URL</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($heroes)): ?>
                        <?php foreach($heroes as $hero): ?>
                        <tr>
                            <td class="fw-bold"><?= esc($hero['name']) ?></td>
                            <td><?= esc($hero['sport']) ?></td>
                            <td><a href="<?= site_url($hero['slug']) ?>" class="text-info" target="_blank">/<?= esc($hero['slug']) ?></a></td>
                            <td class="text-end border-0">
                                <a href="<?= site_url('admin/heroes/' . $hero['id'] . '/photos') ?>" class="btn btn-sm btn-outline-info">Galeria</a>
                                <a href="<?= site_url('admin/heroes/' . $hero['id'] . '/cta') ?>" class="btn btn-sm btn-outline-warning">CTA</a>
                                <a href="<?= site_url('admin/heroes/' . $hero['id'] . '/schedule') ?>" class="btn btn-sm btn-outline-success">Agenda</a>
                                <a href="<?= site_url('admin/heroes/' . $hero['id'] . '/edit') ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                <form action="<?= site_url('admin/heroes/' . $hero['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir? Isso excluirá também fotos e CTA deste herói.')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Del</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Nenhum herói cadastrado ainda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
