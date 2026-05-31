<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= site_url('admin/heroes') ?>" class="btn btn-outline-secondary">&larr; Voltar para Heróis</a>
</div>

<?= view('admin/heroes/_nav', ['hero' => $hero, 'active' => 'cta', 'title' => 'CTA']) ?>
    <div class="card-body">
        <form action="<?= site_url('admin/heroes/' . $hero['id'] . '/cta') ?>" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Tipo de Chamada</label>
                    <select class="form-select bg-black text-white border-secondary" id="type" name="type">
                        <option value="link" <?= ($cta['type'] ?? '') === 'link' ? 'selected' : '' ?>>Link Externo</option>
                        <option value="form" <?= ($cta['type'] ?? '') === 'form' ? 'selected' : '' ?>>Formulário de Intenção</option>
                        <option value="calendar" <?= ($cta['type'] ?? '') === 'calendar' ? 'selected' : '' ?>>Agendamento / Agenda</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Título da CTA</label>
                    <input type="text" class="form-control bg-black text-white border-secondary" id="title" name="title" 
                           value="<?= esc($cta['title'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição Motivacional</label>
                <textarea class="form-control bg-black text-white border-secondary" id="description" name="description" rows="3"><?= esc($cta['description'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Texto do Botão</label>
                    <input type="text" class="form-control bg-black text-white border-secondary" id="button_text" name="button_text" 
                           value="<?= esc($cta['button_text'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_url" class="form-label">URL de Destino</label>
                    <input type="text" class="form-control bg-black text-white border-secondary" id="button_url" name="button_url" 
                           value="<?= esc($cta['button_url'] ?? '') ?>" placeholder="https://...">
                </div>
            </div>

            <button type="submit" class="btn btn-warning fw-bold px-4 text-dark mt-3">Salvar CTA</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
