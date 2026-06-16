<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 50px 100px;
        }

        body {
            font-family: 'Inter', 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 10.5pt;
            line-height: 1.4;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #333;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0 0 8px 0;
            color: #111;
        }

        .header .contract-number {
            font-size: 9pt;
            color: #555;
            margin: 0;
        }

        .clause {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .clause-title {
            font-size: 11pt;
            font-weight: bold;
            color: #111;
            margin: 0 0 6px 0;
            text-transform: uppercase;
        }

        .clause-content {
            font-size: 10.5pt;
            line-height: 1.4;
            text-align: justify;
            margin: 0;
            color: #1a1a1a;
        }

        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .date-line {
            text-align: center;
            margin-bottom: 50px;
            font-size: 10.5pt;
        }

        .signatures {
            width: 100%;
        }

        .signature-block {
            width: 45%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }

        .signature-block-left {
            float: left;
            width: 45%;
            text-align: center;
        }

        .signature-block-right {
            float: right;
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 8px;
        }

        .signature-name {
            font-size: 10pt;
            font-weight: bold;
            margin: 0;
        }

        .signature-role {
            font-size: 9pt;
            color: #555;
            margin: 2px 0 0 0;
        }

        .signature-cpf {
            font-size: 8.5pt;
            color: #666;
            margin: 2px 0 0 0;
        }

        .footer {
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 8.5pt;
            color: #888;
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CONTRATO DE PRESTACAO DE SERVICOS FOTOGRAFICOS</h1>
        <p class="contract-number">Contrato N. <?= esc($contractNumber) ?></p>
    </div>

    <?php foreach ($sections as $index => $section): ?>
        <div class="clause">
            <p class="clause-title">CLAUSULA <?= ($index + 1) ?>a - <?= esc($section->title) ?></p>
            <div class="clause-content">
                <?= $formatContent($section->content) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="signature-section">
        <p class="date-line">
            Sao Paulo, <?= esc($contractDate) ?>
        </p>

        <div class="signatures">
            <div class="signature-block-left">
                <div class="signature-line">
                    <p class="signature-name"><?= esc($ownerName) ?></p>
                    <p class="signature-role">CONTRATADO</p>
                    <p class="signature-cpf">CPF: <?= esc($ownerCpf) ?></p>
                    <p class="signature-cpf"><?= esc($studioName) ?></p>
                </div>
            </div>

            <div class="signature-block-right">
                <div class="signature-line">
                    <p class="signature-name"><?= esc($clientName) ?></p>
                    <p class="signature-role">CONTRATANTE</p>
                    <p class="signature-cpf">CPF: <?= esc($clientCpf) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <?= esc($studioName) ?> &mdash; Contrato N. <?= esc($contractNumber) ?>
    </div>

</body>
</html>
