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
            line-height: 1.5;
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
        }

        .clause-content {
            font-size: 10.5pt;
            line-height: 1.5;
            text-align: justify;
            margin: 0;
            color: #1a1a1a;
        }

        .clause-content p {
            margin: 0 0 6px 0;
        }

        .signature-section {
            margin-top: 50px;
        }

        .date-line {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 30px;
            color: #333;
        }

        .signatures {
            overflow: hidden;
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
        <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS FOTOGRÁFICOS</h1>
        <p class="contract-number">Contrato N. <?= esc($contractNumber) ?></p>
    </div>

    <?php
    // Ordinais por extenso para evitar problemas de encoding
    $ordinais = [
        1 => 'PRIMEIRA', 2 => 'SEGUNDA', 3 => 'TERCEIRA', 4 => 'QUARTA',
        5 => 'QUINTA', 6 => 'SEXTA', 7 => 'SÉTIMA', 8 => 'OITAVA',
        9 => 'NONA', 10 => 'DÉCIMA', 11 => 'DÉCIMA PRIMEIRA', 12 => 'DÉCIMA SEGUNDA',
        13 => 'DÉCIMA TERCEIRA', 14 => 'DÉCIMA QUARTA', 15 => 'DÉCIMA QUINTA',
    ];
    ?>

    <?php foreach ($sections as $index => $section): ?>
        <div class="clause">
            <p class="clause-title">CLÁUSULA <?= $ordinais[$index + 1] ?? ($index + 1) . 'ª' ?> – <?= esc($section->title) ?></p>
            <div class="clause-content">
                <?= $formatContent($section->content) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="signature-section">
        <p class="date-line">
            São Paulo, <?= esc($contractDate) ?>
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

        <!-- Testemunhas (Art. 784, III, CPC) -->
        <div style="margin-top:50px;clear:both;">
            <p style="font-size:9pt;color:#555;text-align:center;margin-bottom:30px;letter-spacing:1px;">TESTEMUNHAS</p>

            <div class="signatures">
                <div class="signature-block-left">
                    <div class="signature-line">
                        <p class="signature-name">_________________________________</p>
                        <p class="signature-cpf">Nome:</p>
                        <p class="signature-cpf">CPF:</p>
                    </div>
                </div>

                <div class="signature-block-right">
                    <div class="signature-line">
                        <p class="signature-name">_________________________________</p>
                        <p class="signature-cpf">Nome:</p>
                        <p class="signature-cpf">CPF:</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <?= esc($studioName) ?> &mdash; Contrato N. <?= esc($contractNumber) ?>
    </div>

</body>
</html>
