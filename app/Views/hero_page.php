<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
/* ── Estilos dos Blocos de Conteúdo (reutilizados da Landing Page) ────── */
.lp-section { padding: 72px 0; }
.lp-section + .lp-section { padding-top: 0; }
.lp-headline {
    position: relative; min-height: 80vh;
    display: flex; align-items: center; justify-content: center;
    text-align: center; padding: 100px 24px 80px;
    background-color: #000; overflow: hidden;
}
.lp-headline-bg { position:absolute;inset:0;object-fit:cover;width:100%;height:100%;opacity:.25;filter:grayscale(30%); }
.lp-headline-overlay { position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.3),rgba(0,0,0,.75)); }
.lp-headline-content { position:relative;z-index:2;max-width:820px; }
.lp-headline-content h2 { font-family:'EB Garamond',Georgia,serif;font-size:clamp(2.4rem,7vw,5rem);font-weight:500;color:#C5A059;line-height:1.2;margin-bottom:24px; }
.lp-headline-content p { font-size:clamp(1rem,2.5vw,1.4rem);color:rgba(255,255,255,.75);font-family:'EB Garamond',Georgia,serif;font-style:italic;max-width:640px;margin:0 auto; }
.lp-text-block { background:#000;padding:60px 0; }
.lp-body { font-family:'EB Garamond',Georgia,serif;font-size:clamp(1.05rem,2vw,1.3rem);color:rgba(255,255,255,.82);line-height:1.85;max-width:720px; }
.lp-body.text-center { margin:0 auto; }
.lp-image-block { background:#000;padding:40px 0; }
.lp-image-contained img { max-width:900px;width:100%;height:auto;display:block;margin:0 auto; }
.lp-image-full img { width:100%;height:auto;display:block; }
.lp-image-caption { text-align:center;font-family:'EB Garamond',Georgia,serif;font-style:italic;font-size:.95rem;color:rgba(255,255,255,.4);margin-top:12px; }
.lp-video-block { background:#000;padding:60px 0; }
.lp-video-wrap { position:relative;padding-bottom:56.25%;height:0;max-width:900px;margin:0 auto; }
.lp-video-wrap iframe { position:absolute;inset:0;width:100%;height:100%;border:none; }
.lp-video-title { text-align:center;font-family:'EB Garamond',Georgia,serif;font-style:italic;color:rgba(255,255,255,.4);margin-top:16px;font-size:.95rem; }
.lp-testimony { background:#070707;padding:72px 0;border-top:1px solid rgba(197,160,89,.1);border-bottom:1px solid rgba(197,160,89,.1); }
.lp-testimony-inner { max-width:760px;margin:0 auto;text-align:center; }
.lp-testimony-quote { font-family:'EB Garamond',Georgia,serif;font-size:clamp(1.3rem,3vw,2rem);font-style:italic;color:rgba(255,255,255,.85);line-height:1.6;margin-bottom:28px; }
.lp-testimony-quote::before{content:'\201C';color:#C5A059;}.lp-testimony-quote::after{content:'\201D';color:#C5A059;}
.lp-testimony-author { font-family:'Inter',sans-serif;font-size:.75rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.4); }
.lp-testimony-photo { width:72px;height:72px;border-radius:50%;object-fit:cover;margin:0 auto 20px;border:1px solid rgba(197,160,89,.3);display:block; }
.lp-process { background:#000;padding:72px 0; }
.lp-process-step { text-align:center;padding:0 24px; }
.lp-process-number { font-family:'EB Garamond',Georgia,serif;font-size:3rem;color:#C5A059;opacity:.5;line-height:1;margin-bottom:12px; }
.lp-process-title { font-family:'EB Garamond',Georgia,serif;font-size:1.3rem;color:#fff;margin-bottom:8px; }
.lp-process-desc { font-size:.9rem;color:rgba(255,255,255,.45);line-height:1.6; }
.lp-cta-btn-block { background:#000;padding:72px 24px;text-align:center; }
.lp-divider { width:48px;height:1px;background:rgba(197,160,89,.4);margin:0 auto; }
    /* ── Variáveis da Moldura Dourada ─────────────────────────────────── */
    :root {
        --gold-light:  #F5E27A; /* Ouro claro — topo iluminado */
        --gold-mid:    #C9A84C; /* Ouro médio — laterais */
        --gold-dark:   #8B6914; /* Ouro escuro — base sombreada */
        --gold-glow:   rgba(197, 160, 89, 0.35);
    }

    .swiper {
        width: 100%;
        background: #050505;
        padding-bottom: 44px;
    }
    .swiper-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 88px 5vw 48px 5vw;
        box-sizing: border-box;
        background-color: #050505;
    }

    /* ── Moldura Dourada Metálica ──────────────────────────────────────── */
    .swiper-slide img {
        max-width: 100%;
        max-height: 72vh;
        width: auto;
        height: auto;
        object-fit: contain;

        /* Moldura dourada fina com gradiente metálico nas 4 faces */
        border-style: solid;
        border-width: clamp(8px, 1.2vw, 16px);

        border-top-color:    var(--gold-light);
        border-right-color:  var(--gold-dark);
        border-bottom-color: var(--gold-dark);
        border-left-color:   var(--gold-light);

        border-radius: 1px;

        /* Brilho externo dourado + sombra profunda */
        box-shadow:
            0 0 0 1px var(--gold-mid),               /* linha fina ao redor da moldura */
            0 0 18px 2px var(--gold-glow),            /* halo dourado suave */
            0 25px 55px rgba(0, 0, 0, 0.65);          /* sombra de profundidade */

        transition: box-shadow 0.4s ease;
    }
    .swiper-slide.swiper-slide-active img {
        box-shadow:
            0 0 0 1px var(--gold-mid),
            0 0 28px 6px var(--gold-glow),
            0 30px 70px rgba(0, 0, 0, 0.75);
    }

    /* ── Legenda ───────────────────────────────────────────────────────── */
    .photo-caption {
        position: relative;
        width: 100%;
        padding: 0.9rem 1rem 0 1rem;
        background: transparent;
        color: #fff;
        text-align: center;
        z-index: 10;
    }
    .photo-caption p {
        font-size: clamp(0.85rem, 1.5vw, 1.1rem);
        font-family: 'Cinzel', serif;
        max-width: 780px;
        margin: 0 auto;
        line-height: 1.6;
        font-weight: 300;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.72);
        text-shadow: 1px 1px 8px rgba(0,0,0,0.9);
    }
    .cta-section {
        background-color: #050505;
        padding: 60px 0 120px 0;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 150vw;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }
    .cta-card {
        max-width: 900px;
        padding: 4rem 3rem;
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 4px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.5);
        text-align: center;
        position: relative;
        z-index: 10;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .cta-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }
    .cta-eyebrow {
        display: block;
        text-uppercase: uppercase;
        font-size: 0.85rem;
        letter-spacing: 5px;
        color: #888;
        margin-bottom: 1.5rem;
        font-weight: 300;
    }
    .cta-title {
        font-size: clamp(2rem, 4vw, 3.5rem);
        margin-bottom: 2rem;
        color: #fff;
        line-height: 1.1;
    }
    .cta-copy {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        font-weight: 300;
    }
    .btn-hero-premium {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1.2rem 3.5rem;
        background: #fff;
        color: #000;
        text-decoration: none;
        text-transform: uppercase;
        font-weight: 700;
        font-family: inherit;
        letter-spacing: 3px;
        font-size: 0.9rem;
        border: none;
        border-radius: 0;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
    }
    .btn-hero-premium:hover {
        background: #000;
        color: #fff;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4), 0 0 20px rgba(255,255,255,0.1);
    }
    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: all 0.6s;
    }
    .btn-hero-premium:hover .btn-shine {
        left: 100%;
    }
    .glass-modal {
        background: rgba(10, 10, 10, 0.9) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .modal-content input, .modal-content textarea {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .modal-content input:focus, .modal-content textarea:focus {
        border-color: #fff !important;
        box-shadow: 0 0 15px rgba(255,255,255,0.1);
        background-color: #000 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if(!empty($photos)): ?>
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php foreach($photos as $photo): ?>
        <div class="swiper-slide">
            <img src="<?= base_url($photo['image_path']) ?>" alt="<?= esc($hero['name']) ?>">
            <?php if(!empty($photo['caption'])): ?>
            <div class="photo-caption">
                <p><?= nl2br(esc($photo['caption'])) ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-button-next text-white opacity-50"></div>
    <div class="swiper-button-prev text-white opacity-50"></div>
    <div class="swiper-pagination"></div>
</div>
<?php else: ?>
<div class="vh-100 d-flex align-items-center justify-content-center text-center pt-5">
    <div class="container pt-5">
        <h1 class="display-3 text-uppercase brand-font"><?= esc($hero['name']) ?></h1>
        <p class="lead opacity-75">Série especial: <?= esc($hero['sport']) ?></p>
        <p class="text-muted mt-5">Nenhuma foto épica adicionada ainda.</p>
    </div>
</div>
<?php endif; ?>

<?php if(!empty($blocks)): ?>
<?php foreach ($blocks as $block):
    $c    = $block['content'];
    $type = $block['type'];
?>

<?php if ($type === 'headline'): ?>
    <!-- ── HEADLINE ── -->
    <section class="lp-headline">
        <?php if (!empty($c['image_path'])): ?>
            <img src="<?= base_url($c['image_path']) ?>" class="lp-headline-bg" alt="">
        <?php endif; ?>
        <div class="lp-headline-overlay"></div>
        <div class="lp-headline-content">
            <?php if (!empty($c['title'])): ?>
                <h2><?= esc($c['title']) ?></h2>
            <?php endif; ?>
            <?php if (!empty($c['subtitle'])): ?>
                <p><?= esc($c['subtitle']) ?></p>
            <?php endif; ?>
        </div>
    </section>

<?php elseif ($type === 'text'): ?>
    <!-- ── TEXT ── -->
    <div class="lp-text-block">
        <div class="container px-4">
            <div class="lp-body <?= $c['align'] === 'center' ? 'text-center' : '' ?>">
                <?= $c['content'] ?>
            </div>
        </div>
    </div>

<?php elseif ($type === 'image'): ?>
    <!-- ── IMAGE ── -->
    <?php if (!empty($c['image_path'])): ?>
    <div class="lp-image-block">
        <div class="<?= $c['size'] === 'full' ? 'lp-image-full' : 'lp-image-contained px-4' ?>">
            <img src="<?= base_url($c['image_path']) ?>" alt="<?= esc($c['caption'] ?? '') ?>"
                 style="filter:drop-shadow(0 20px 40px rgba(0,0,0,0.6));">
            <?php if (!empty($c['caption'])): ?>
                <p class="lp-image-caption"><?= esc($c['caption']) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

<?php elseif ($type === 'video_embed'): ?>
    <!-- ── VIDEO ── -->
    <?php if (!empty($c['url'])): ?>
    <div class="lp-video-block">
        <div class="container px-4">
            <div class="lp-video-wrap">
                <?php
                    $url = $c['url'];
                    if (preg_match('/youtube\.com\/watch\?v=([\w-]+)/', $url, $m) ||
                        preg_match('/youtu\.be\/([\w-]+)/', $url, $m)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0';
                    } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $m[1];
                    } else {
                        $embedUrl = $url;
                    }
                ?>
                <iframe src="<?= esc($embedUrl) ?>" allowfullscreen loading="lazy"
                        title="<?= esc($c['title'] ?? '') ?>"></iframe>
            </div>
            <?php if (!empty($c['title'])): ?>
                <p class="lp-video-title"><?= esc($c['title']) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

<?php elseif ($type === 'testimony'): ?>
    <!-- ── TESTIMONY ── -->
    <section class="lp-testimony">
        <div class="lp-testimony-inner px-4">
            <?php if (!empty($c['image_path'])): ?>
                <img src="<?= base_url($c['image_path']) ?>" class="lp-testimony-photo" alt="<?= esc($c['author'] ?? '') ?>">
            <?php endif; ?>
            <?php if (!empty($c['quote'])): ?>
                <p class="lp-testimony-quote"><?= esc($c['quote']) ?></p>
            <?php endif; ?>
            <p class="lp-testimony-author">
                <?= esc($c['author'] ?? '') ?>
                <?php if (!empty($c['sport'])): ?> &nbsp;·&nbsp; <?= esc($c['sport']) ?><?php endif; ?>
            </p>
        </div>
    </section>

<?php elseif ($type === 'process'): ?>
    <!-- ── PROCESS ── -->
    <?php if (!empty($c['steps'])): ?>
    <section class="lp-process">
        <div class="container px-4">
            <div class="row justify-content-center g-4">
                <?php foreach ($c['steps'] as $step): ?>
                <div class="col-md-4">
                    <div class="lp-process-step">
                        <div class="lp-process-number"><?= esc($step['number']) ?></div>
                        <div class="lp-process-title"><?= esc($step['title']) ?></div>
                        <div class="lp-process-desc"><?= esc($step['desc']) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php elseif ($type === 'cta_button'): ?>
    <!-- ── CTA BUTTON ── -->
    <div class="lp-cta-btn-block">
        <div class="lp-divider mb-5"></div>
        <button type="button" class="btn-hero-premium"
                data-bs-toggle="modal" data-bs-target="#unifiedModal"
                onclick="loadSlotsInModal(<?= $hero['id'] ?>)">
            <?= esc($c['text'] ?? 'Quero meu ensaio') ?>
            <span class="btn-shine"></span>
        </button>
        <div class="lp-divider mt-5"></div>
    </div>

<?php elseif ($type === 'spacer'): ?>
    <!-- ── SPACER ── -->
    <?php $h = ['sm'=>'40px','md'=>'80px','lg'=>'160px'][$c['height'] ?? 'md'] ?? '80px'; ?>
    <div style="height:<?= $h ?>; background:#000;"></div>

<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>

<!-- Modal Unificado (Intenção + Agenda) -->
<div class="modal fade" id="unifiedModal" tabindex="-1" aria-labelledby="unifiedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary glass-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title brand-font text-uppercase" id="unifiedModalLabel">Manifestar Intenção</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="unifiedForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="hero_id" value="<?= esc($hero['id']) ?>">
                    
                    <div id="step-personal">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label small text-secondary">SEU NOME</label>
                                <input type="text" name="name" class="form-control bg-black text-white border-secondary rounded-0 p-3" placeholder="Nome Completo" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">EMAIL</label>
                                <input type="email" name="email" class="form-control bg-black text-white border-secondary rounded-0 p-3" placeholder="seu@email.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">WHATSAPP / CELULAR</label>
                                <input type="tel" name="phone" class="form-control bg-black text-white border-secondary rounded-0 p-3" placeholder="(00) 00000-0000" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label small text-secondary">ENDEREÇO</label>
                                <input type="text" name="address" class="form-control bg-black text-white border-secondary rounded-0 p-3" placeholder="Cidade / Estado" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small text-secondary">IDADE</label>
                                <input type="number" name="age" class="form-control bg-black text-white border-secondary rounded-0 p-3" placeholder="00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">TIPO DE ENSAIO</label>
                            <select name="shoot_type" class="form-select bg-black text-white border-secondary rounded-0 p-3" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="esporte">Esporte</option>
                                <option value="performance">Performance</option>
                                <option value="gestante">Gestante</option>
                                <option value="lifestyle">Lifestyle</option>
                                <option value="publicitario">Publicitário</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>

                        <div class="form-check mb-4 mt-2">
                            <input class="form-check-input" type="checkbox" id="wantSchedule" onchange="toggleSchedule()">
                            <label class="form-check-label text-info small" for="wantSchedule">
                                DESEJO AGENDAR UMA VISITA OU ENSAIO AGORA
                            </label>
                        </div>

                        <div id="scheduleSection" style="display: none;" class="mb-4 animate__animated animate__fadeIn">
                            <label class="form-label small text-secondary mb-3">ESCOLHA UM HORÁRIO DISPONÍVEL</label>
                            <div id="unifiedSlots" class="row g-2">
                                <!-- Slots via JS -->
                            </div>
                            <input type="hidden" name="availability_id" id="unified_avail_id">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-hero-premium">
                                ENVIAR SOLICITAÇÃO
                                <span class="btn-shine"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        speed: 700,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        keyboard: {
            enabled: true,
        },
        a11y: true,
    });

    // Fluxo Unificado
    function loadSlotsInModal(heroId) {
        const container = document.getElementById('unifiedSlots');
        container.innerHTML = '<div class="col-12 text-center py-3"><div class="spinner-border spinner-border-sm text-light" role="status"></div></div>';
        
        fetch('<?= base_url('schedule/slots/') ?>' + heroId)
            .then(response => response.json())
            .then(slots => {
                if (slots.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center text-muted small py-2">Nenhum horário disponível no momento.</div>';
                    return;
                }

                let html = '';
                slots.forEach(slot => {
                    const dateObj = new Date(slot.date + 'T12:00:00');
                    const formattedDate = dateObj.toLocaleDateString('pt-BR', { day: 'numeric', month: 'short' });
                    const typeLabel = slot.type === 'photoshoot' ? 'Ensaio' : (slot.type === 'visit_online' ? 'Online' : 'Estúdio');
                    
                    html += `
                        <div class="col-4 col-md-3">
                            <div class="p-2 border border-secondary bg-black text-center slot-opt transition-all" 
                                 onclick="selectUnifiedSlot(this, ${slot.id})"
                                 style="cursor: pointer; font-size: 0.75rem;">
                                <div class="fw-bold text-white">${formattedDate}</div>
                                <div class="text-info">${slot.start_time.substring(0,5)}</div>
                                <div class="text-secondary" style="font-size: 0.65rem">${typeLabel}</div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            });
    }

    function toggleSchedule() {
        const section = document.getElementById('scheduleSection');
        const checkbox = document.getElementById('wantSchedule');
        section.style.display = checkbox.checked ? 'block' : 'none';
        if (!checkbox.checked) {
            document.getElementById('unified_avail_id').value = '';
            document.querySelectorAll('.slot-opt').forEach(el => el.classList.remove('border-info', 'bg-dark'));
        }
    }

    function selectUnifiedSlot(el, id) {
        document.querySelectorAll('.slot-opt').forEach(opt => {
            opt.classList.remove('border-info', 'bg-dark');
            opt.classList.add('border-secondary');
        });
        el.classList.remove('border-secondary');
        el.classList.add('border-info', 'bg-dark');
        document.getElementById('unified_avail_id').value = id;
    }

    const unifiedForm = document.getElementById('unifiedForm');
    if (unifiedForm) {
        unifiedForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const wantSchedule = document.getElementById('wantSchedule').checked;
            const availId = document.getElementById('unified_avail_id').value;
            
            if (wantSchedule && !availId) {
                alert('Por favor, selecione um horário ou desmarque a opção de agendamento.');
                return;
            }

            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerText = 'ENVIANDO...';
            btn.disabled = true;

            const formData = new FormData(this);

            fetch('<?= base_url('intentions/store') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 201 || data.message) {
                    this.innerHTML = `
                        <div class="text-center py-5 animate__animated animate__fadeIn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check2-circle text-success mb-3" viewBox="0 0 16 16">
                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                            </svg>
                            <h4 class="brand-font text-white mb-2">SOLICITAÇÃO RECEBIDA</h4>
                            <p class="text-secondary">Em breve entraremos em contato para transcender seus limites.</p>
                            <button type="button" class="btn btn-link text-white mt-3" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    `;
                } else {
                    alert('Erro: ' + (data.messages ? Object.values(data.messages).join('\n') : 'Falha no envio.'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                alert('Erro na conexão.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }

    // Auto-open modal if requested via URL
    if (window.location.search.includes('agenda=1')) {
        setTimeout(function() {
            const modalBtn = document.querySelector('[data-bs-target^="#unifiedModal"]');
            if (modalBtn) {
                modalBtn.click();
            }
        }, 1000);
    }
</script>
<?= $this->endSection() ?>
