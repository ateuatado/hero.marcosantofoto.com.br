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
                        <div class="card h-100 bg-black border-dark shadow-lg">
                            <div class="card-body p-4 text-center">
                                <h3 class="fw-bolder brand-font text-white"><?= esc($hero['name']) ?></h3>
                                <p class="text-secondary text-uppercase small tracking-wide"><?= esc($hero['sport']) ?></p>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                <a class="btn btn-outline-light w-100 text-uppercase" href="<?= site_url($hero['slug']) ?>">Ver Retratos</a>
                            </div>
                        </div>
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
