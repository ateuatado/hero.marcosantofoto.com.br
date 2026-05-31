<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= site_url('admin/heroes') ?>" class="btn btn-outline-secondary">&larr; Voltar para Heróis</a>
</div>

        <?php if(isset($hero)): ?>
            <?= view('admin/heroes/_nav', ['hero' => $hero, 'active' => 'details', 'title' => 'Dados do Herói']) ?>
        <?php endif; ?>

        <form action="<?= isset($hero) ? site_url('admin/heroes/' . $hero['id']) : site_url('admin/heroes') ?>" method="post">
            <?php if(isset($hero)): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Nome *</label>
                <input type="text" class="form-control bg-black text-white border-secondary" id="name" name="name" 
                       value="<?= old('name', $hero['name'] ?? '') ?>" required>
                <div class="form-text text-muted">O nome ou título principal (Ex: Karina).</div>
            </div>

            <div class="mb-3">
                <label for="sport" class="form-label">Esporte / Modalidade *</label>
                <input type="text" class="form-control bg-black text-white border-secondary" id="sport" name="sport" 
                       value="<?= old('sport', $hero['sport'] ?? '') ?>" required>
                <div class="form-text text-muted">Ex: Body Building, Ciclismo, etc.</div>
            </div>

            <div class="mb-4">
                <label for="slug" class="form-label">URL Customizada (Slug) *</label>
                <input type="text" class="form-control bg-black text-info border-secondary" id="slug" name="slug" 
                       value="<?= old('slug', $hero['slug'] ?? '') ?>" required>
                <div class="form-text text-muted">A url em que a página ficará disponível. Ex: karina-body-building</div>
            </div>

            <button type="submit" class="btn btn-primary fw-bold px-4">Salvar Herói</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    // Gerador de slug amigável em tempo real (opcional)
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    <?php if(!isset($hero)): ?>
    nameInput.addEventListener('input', function() {
        let title = this.value.toLowerCase().trim();
        let slug = title.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        slugInput.value = slug;
    });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
