<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<style>
    @page {
        margin: 50px 45px 60px 45px;
    }
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 11pt;
        color: #333;
        line-height: 1.7;
    }

    /* ── Capa ── */
    .cover {
        text-align: center;
        padding-top: 200px;
    }
    .cover-brand {
        font-size: 12pt;
        letter-spacing: 6px;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 40px;
    }
    .cover-title {
        font-size: 28pt;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }
    .cover-subtitle {
        font-size: 13pt;
        color: #888;
        font-style: italic;
        margin-bottom: 60px;
    }
    .cover-client {
        font-size: 14pt;
        color: #C5A059;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .cover-meta {
        font-size: 10pt;
        color: #aaa;
        letter-spacing: 1px;
    }
    .cover-line {
        width: 60px;
        height: 2px;
        background: #C5A059;
        margin: 30px auto;
    }

    /* ── Seções ── */
    .section {
        page-break-inside: avoid;
        margin-bottom: 32px;
    }
    .section-title {
        font-size: 15pt;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid #eee;
    }
    .section-content {
        font-size: 10.5pt;
        color: #444;
        line-height: 1.75;
        white-space: pre-line;
    }

    /* ── Divider entre grupos ── */
    .group-header {
        font-size: 10pt;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #C5A059;
        margin: 40px 0 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #C5A059;
    }

    /* ── Contracapa ── */
    .backcover {
        page-break-before: always;
        text-align: center;
        padding-top: 240px;
    }
    .backcover-brand {
        font-size: 18pt;
        font-weight: 300;
        color: #1a1a1a;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }
    .backcover-info {
        font-size: 10pt;
        color: #888;
        line-height: 2;
    }
    .backcover-line {
        width: 40px;
        height: 1px;
        background: #C5A059;
        margin: 20px auto;
    }

    /* ── Footer ── */
    .page-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 8pt;
        color: #ccc;
        letter-spacing: 2px;
    }
</style>
</head>
<body>

<div class="page-footer">MARCO SANTO FOTOGRAFIA</div>

<!-- ══ CAPA ══ -->
<div class="cover">
    <div class="cover-brand">Marco Santo</div>
    <div class="cover-line"></div>
    <div class="cover-title">Guia Pré-Ensaio</div>
    <div class="cover-subtitle">Tudo que você precisa saber antes do seu ensaio</div>
    <div class="cover-line"></div>
    <div class="cover-client"><?= esc($clientName) ?></div>
    <?php if (!empty($shootType)): ?>
        <div class="cover-meta"><?= esc($shootType) ?></div>
    <?php endif; ?>
    <div class="cover-meta" style="margin-top:4px;"><?= esc($shootDate) ?></div>
</div>

<!-- ══ CONTEÚDO ══ -->
<div style="page-break-before:always;"></div>

<?php
    $lastCatId = 'NONE';
?>
<?php foreach ($sections as $s): ?>
    <?php
        $isNiche = !empty($s->category_id);
        if ($isNiche && $s->category_id !== $lastCatId) {
            $lastCatId = $s->category_id;
    ?>
        <div class="group-header">Orientações Específicas</div>
    <?php } ?>

    <div class="section">
        <div class="section-title"><?= esc($s->title) ?></div>
        <div class="section-content"><?= nl2br(esc($s->content)) ?></div>
    </div>
<?php endforeach; ?>

<!-- ══ CONTRACAPA ══ -->
<div class="backcover">
    <div class="backcover-brand">Marco Santo</div>
    <div class="backcover-line"></div>
    <div class="backcover-info">
        Estúdio na Lapa — um bairro encantador que parou no tempo<br>
        Estacionamento disponível na rua<br>
        Wi-Fi no estúdio<br>
        <br>
        Dúvidas? Chama no WhatsApp<br>
    </div>
    <div class="backcover-line"></div>
    <div class="backcover-info" style="font-size:8pt;color:#bbb;margin-top:20px;">
        Este guia foi preparado especialmente para <?= esc($clientName) ?><br>
        © <?= date('Y') ?> Marco Santo Fotografia — Todos os direitos reservados
    </div>
</div>

</body>
</html>
