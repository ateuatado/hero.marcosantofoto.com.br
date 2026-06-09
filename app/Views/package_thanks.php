<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div style="min-height:100vh;background:#000;display:flex;align-items:center;justify-content:center;padding:60px 24px;">
    <div style="max-width:560px;text-align:center;">

        <?php $status = $status ?? 'success'; ?>

        <?php if ($status === 'success'): ?>
            <div style="font-size:3rem;margin-bottom:24px;">✨</div>
            <p style="font-family:'Inter',sans-serif;font-size:.7rem;letter-spacing:.25em;text-transform:uppercase;color:rgba(197,160,89,.6);margin-bottom:12px;">PAGAMENTO CONFIRMADO</p>
            <h1 style="font-family:'EB Garamond',Georgia,serif;font-size:clamp(2rem,5vw,3rem);color:#fff;font-weight:400;margin-bottom:16px;">
                <?= $nome ? 'Obrigado, ' . esc($nome) . '!' : 'Pagamento recebido!' ?>
            </h1>
            <?php if ($pacote): ?>
            <p style="font-family:'EB Garamond',Georgia,serif;font-style:italic;color:rgba(255,255,255,.5);font-size:1.1rem;margin-bottom:32px;">
                Seu ensaio <strong style="color:#C5A059;"><?= esc($pacote) ?></strong> está confirmado.<br>
                Entraremos em contato para agendar e preparar tudo com cuidado.
            </p>
            <?php endif; ?>

        <?php elseif ($status === 'falha'): ?>
            <div style="font-size:3rem;margin-bottom:24px;">😔</div>
            <h1 style="font-family:'EB Garamond',Georgia,serif;font-size:clamp(2rem,5vw,2.8rem);color:#fff;font-weight:400;margin-bottom:16px;">Pagamento não concluído</h1>
            <p style="font-family:'EB Garamond',Georgia,serif;font-style:italic;color:rgba(255,255,255,.5);font-size:1.1rem;margin-bottom:32px;">
                Ocorreu um problema com o pagamento. Você pode tentar novamente ou entrar em contato.
            </p>

        <?php else: ?>
            <div style="font-size:3rem;margin-bottom:24px;">⏳</div>
            <h1 style="font-family:'EB Garamond',Georgia,serif;font-size:clamp(2rem,5vw,2.8rem);color:#fff;font-weight:400;margin-bottom:16px;">Pagamento em análise</h1>
            <p style="font-family:'EB Garamond',Georgia,serif;font-style:italic;color:rgba(255,255,255,.5);font-size:1.1rem;margin-bottom:32px;">
                Seu pagamento está sendo processado. Assim que confirmado, entraremos em contato.
            </p>
        <?php endif; ?>

        <a href="/" style="display:inline-block;background:transparent;border:1px solid rgba(197,160,89,.4);color:#C5A059;padding:14px 40px;font-family:'Inter',sans-serif;font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;text-decoration:none;transition:all .2s;">
            VOLTAR AO INÍCIO
        </a>
    </div>
</div>
<?= $this->endSection() ?>
