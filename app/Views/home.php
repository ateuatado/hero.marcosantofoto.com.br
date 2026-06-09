<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<header class="d-flex align-items-center justify-content-center text-center pt-5 pb-4 mt-5" style="background-color: #050505;">
    <div class="container px-4 px-lg-5 text-white mt-5">
        <h1 class="display-3 fw-bold text-uppercase mb-4 brand-font">Alta Performance</h1>
        <p class="lead mb-5 opacity-75">Sua jornada épica eternizada. Fotografia para quem transcende os limites do corpo e da mente.</p>
        <a class="btn btn-outline-light btn-lg px-5 py-3 text-uppercase" href="#portfolio">Conheça os Heróis</a>
    </div>
</header>

<section id="portfolio" class="py-5" style="background-color: #050505;">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center text-uppercase mb-5 brand-font">Portfolio Heroico</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
            <?php if(!empty($heroes)): ?>
                <?php foreach($heroes as $hero): ?>
                    <div class="col mb-5">
                        <a href="<?= site_url($hero['slug']) ?>" class="hero-link">
                            <div class="card h-100 bg-black border-dark shadow-lg overflow-hidden">
                                <!-- Foto de Capa -->
                                <div class="hero-card-img-wrapper" style="height: 250px; overflow: hidden; background-color: #0d0d0d; position: relative;">
                                    <?php if(!empty($hero['cover_image'])): ?>
                                        <img src="<?= base_url($hero['cover_image']) ?>" class="card-img-top hero-card-img w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;" alt="<?= esc($hero['name']) ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted small">
                                            <i class="fas fa-image fa-2x opacity-25"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body p-4 text-center">
                                    <h3 class="fw-bolder brand-font text-white"><?= esc($hero['name']) ?></h3>
                                    <p class="text-secondary text-uppercase small tracking-wide"><?= esc($hero['sport']) ?></p>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                    <span class="btn btn-outline-light w-100 text-uppercase">Ver Retratos</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p>Em breve, novos heróis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
