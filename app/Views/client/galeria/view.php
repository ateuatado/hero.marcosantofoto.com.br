<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<style>
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.25rem;
    }
    .photo-item {
        position: relative;
        cursor: pointer;
        overflow: hidden;
        border-radius: 6px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #111;
    }
    .photo-item img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .photo-item:hover img {
        transform: scale(1.03);
    }
    .photo-item.selected img {
        opacity: 0.55;
    }
    .photo-item.selected {
        box-shadow: 0 0 0 4px var(--mst-gold, #c5a059);
        transform: scale(0.975);
    }
    /* Badge de check */
    .check-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: var(--mst-gold, #c5a059);
        color: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        opacity: 0;
        transform: scale(0);
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        pointer-events: none;
    }
    .photo-item.selected .check-icon {
        opacity: 1;
        transform: scale(1);
    }
    /* Número da foto */
    .photo-number {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 20px;
        pointer-events: none;
    }
    /* Loading skeleton */
    .photo-skeleton {
        width: 100%;
        height: 260px;
        background: linear-gradient(90deg, #1a1a1a 25%, #222 50%, #1a1a1a 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
    }
    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    /* Barra flutuante */
    .floating-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(8, 8, 8, 0.96);
        backdrop-filter: blur(16px);
        border-top: 1px solid rgba(197, 160, 89, 0.35);
        padding: 1rem 0;
        z-index: 1000;
        transform: translateY(100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .floating-bar.visible {
        transform: translateY(0);
    }
    /* Alerta de erro S3 */
    .s3-warning {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #ffc107;
        font-size: 0.9rem;
    }
    /* Estado vazio */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: #555;
    }
    .empty-state .icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.4;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4" style="margin-top: 100px; padding-bottom: 140px;">

    <!-- Cabeçalho -->
    <div class="text-center mb-5">
        <h1 class="text-gold brand-font text-uppercase mb-2" style="font-size: 2rem; letter-spacing: 0.12em;">
            Seleção de Fotos
        </h1>
        <p class="text-muted mb-1">
            Projeto #<?= esc($project->id) ?> &mdash; Pacote: <strong class="text-white"><?= esc($package->name) ?></strong>
        </p>
        <p class="small text-white-50">
            Seu pacote inclui <strong><?= esc($package->included_photos) ?> foto<?= $package->included_photos != 1 ? 's' : '' ?></strong>.
            Fotos extras custam <strong>R$ <?= number_format($package->extra_photo_price, 2, ',', '.') ?></strong> cada.
        </p>
        <?php if ($project->status === 'completed'): ?>
            <span class="badge bg-success mt-1">Seleção finalizada</span>
        <?php elseif ($project->status === 'selecting'): ?>
            <span class="badge bg-warning text-dark mt-1">Em seleção</span>
        <?php else: ?>
            <span class="badge bg-secondary mt-1">Aguardando fotos</span>
        <?php endif; ?>
    </div>

    <!-- Aviso de erro de sincronização S3 -->
    <?php if (!empty($syncError)): ?>
        <div class="s3-warning">
            ⚠️ Não foi possível sincronizar com o servidor de fotos agora. Exibindo fotos registradas anteriormente.
        </div>
    <?php endif; ?>

    <!-- Grade de fotos -->
    <?php if (!empty($photos)): ?>
        <div class="photo-grid" id="photoGrid">
            <?php foreach ($photos as $i => $photo): ?>
                <div
                    class="photo-item <?= $photo->status === 'selected' ? 'selected' : '' ?>"
                    data-id="<?= $photo->id ?>"
                    title="<?= esc($photo->original_filename) ?>"
                >
                    <?php if (!empty($photo->presigned_url)): ?>
                        <img
                            src="<?= esc($photo->presigned_url) ?>"
                            alt="Foto <?= $i + 1 ?>"
                            loading="lazy"
                            onerror="this.closest('.photo-item').classList.add('load-error'); this.src='data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'260\' height=\'260\'><rect fill=\'%23111\'/><text x=\'50%25\' y=\'50%25\' fill=\'%23444\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'12\'>Erro ao carregar</text></svg>'"
                        >
                    <?php else: ?>
                        <div class="photo-skeleton"></div>
                    <?php endif; ?>
                    <div class="check-icon">✓</div>
                    <div class="photo-number"><?= $i + 1 ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="icon">📷</div>
            <h4 class="text-white-50 mb-2">Nenhuma foto disponível ainda</h4>
            <p class="text-muted small">
                As fotos do ensaio aparecerão aqui assim que forem processadas.<br>
                Isso acontece automaticamente após o fotógrafo enviar as imagens.
            </p>
        </div>
    <?php endif; ?>

</div>

<!-- Barra Flutuante de Ação -->
<?php if (!empty($photos) && in_array($project->status, ['open', 'selecting'])): ?>
<div class="floating-bar" id="floatingBar">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="mb-0 text-white brand-font">
                Selecionadas: <span id="selectedCount" class="text-gold">0</span>
                <span class="text-muted fw-normal" style="font-size:0.85rem;">/ <?= esc($package->included_photos) ?> incluídas</span>
            </h5>
            <small class="text-muted" id="extraInfo">Sem custos extras.</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-light" id="btnSaveProgress">
                <span id="btnSaveText">Salvar Progresso</span>
            </button>
            <a href="<?= site_url('client/galeria/' . $project->id . '/checkout') ?>"
               class="btn btn-terroso" id="btnCheckout">
                Finalizar Seleção →
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    const includedPhotos = <?= (int)$package->included_photos ?>;
    const extraPrice     = <?= (float)$package->extra_photo_price ?>;
    const saveUrl        = "<?= site_url('client/galeria/' . $project->id . '/save') ?>";

    // Inicia com as já marcadas no banco
    let selectedIds = new Set(
        [...document.querySelectorAll('.photo-item.selected')].map(el => el.dataset.id)
    );

    const fmtBRL = val => 'R$ ' + val.toFixed(2).replace('.', ',');

    function updateUI() {
        const count = selectedIds.size;
        const extra = Math.max(0, count - includedPhotos);

        const countEl = document.getElementById('selectedCount');
        const infoEl  = document.getElementById('extraInfo');
        const bar     = document.getElementById('floatingBar');

        if (countEl) countEl.textContent = count;

        if (infoEl) {
            if (extra > 0) {
                infoEl.innerHTML = `<span class="text-warning">${extra} foto${extra > 1 ? 's' : ''} extra${extra > 1 ? 's' : ''} — ${fmtBRL(extra * extraPrice)}</span>`;
            } else {
                infoEl.textContent = count > 0 ? 'Sem custos extras.' : '';
            }
        }

        if (bar) {
            bar.classList.toggle('visible', count > 0);
        }
    }

    // Clique nas fotos
    const grid = document.getElementById('photoGrid');
    if (grid) {
        grid.addEventListener('click', function (e) {
            const item = e.target.closest('.photo-item');
            if (!item) return;

            const id = item.dataset.id;
            item.classList.toggle('selected');
            if (item.classList.contains('selected')) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
            updateUI();
        });
    }

    // Botão Salvar Progresso
    const btnSave = document.getElementById('btnSaveProgress');
    if (btnSave) {
        btnSave.addEventListener('click', function () {
            const textEl = document.getElementById('btnSaveText');
            textEl.textContent = 'Salvando...';
            btnSave.disabled = true;

            fetch(saveUrl, {
                method:  'POST',
                headers: {
                    'Content-Type':     'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ selected_photos: [...selectedIds] }),
            })
            .then(r => r.json())
            .then(data => {
                textEl.textContent = data.success ? '✓ Salvo!' : 'Erro ao salvar';
                setTimeout(() => {
                    textEl.textContent = 'Salvar Progresso';
                    btnSave.disabled = false;
                }, 2000);
            })
            .catch(() => {
                textEl.textContent = 'Erro de conexão';
                setTimeout(() => {
                    textEl.textContent = 'Salvar Progresso';
                    btnSave.disabled = false;
                }, 2000);
            });
        });
    }

    // Inicializa UI
    updateUI();
})();
</script>
<?= $this->endSection() ?>
