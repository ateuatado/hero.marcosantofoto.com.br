<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContractSectionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $sections = [
            [
                'title'         => 'DAS PARTES',
                'content'       => "CONTRATADO: {contratado_nome}, CPF: {contratado_cpf}, {contratado_estado_civil}, com estudio em {contratado_endereco}.\n\nCONTRATANTE: {nome_cliente}, CPF: {cpf_cliente}, RG: {rg_cliente}, {estado_civil}, residente em {endereco_completo}, e-mail: {email}, telefone: {telefone}.",
                'display_order' => 10,
            ],
            [
                'title'         => 'DO OBJETO',
                'content'       => "Prestacao de servicos fotograficos conforme pacote {nome_pacote}, incluindo sessao fotografica com duracao maxima de 2 (duas) horas no estudio do CONTRATADO e {qtd_fotos} fotografias tratadas digitalmente.\n\nParagrafo 1: O tratamento digital abrange correcao de cor, exposicao, contraste e limpeza basica de pele. Manipulacoes avancadas de imagem (como alteracao corporal, troca de fundos ou remocao de objetos complexos) nao estao inclusas e, se solicitadas, serao orcadas a parte.\n\nParagrafo 2: Caso a sessao exceda o tempo estipulado por solicitacao do CONTRATANTE, sera cobrada hora adicional no valor de R\$ 150,00 (cento e cinquenta reais).",
                'display_order' => 20,
            ],
            [
                'title'         => 'DO VALOR E PAGAMENTO',
                'content'       => "Valor total de {valor} ({valor_extenso}), pago via {forma_pagamento} no ato da contratacao.\n\nParagrafo unico: Fotos adicionais alem do pacote serao cobradas a {valor_foto_extra} cada, mediante aprovacao previa do CONTRATANTE.",
                'display_order' => 30,
            ],
            [
                'title'         => 'DA DATA E LOCAL',
                'content'       => "A sessao sera realizada na data agendada entre as partes, no estudio do CONTRATADO ou em locacao externa previamente acordada.\n\nParagrafo unico: Em caso de locacao externa escolhida pelo CONTRATANTE, todas as despesas com deslocamento, alimentacao, ingressos e taxas de autorizacao do espaco serao de inteira responsabilidade e custeio do CONTRATANTE.",
                'display_order' => 40,
            ],
            [
                'title'         => 'DA ENTREGA',
                'content'       => "O CONTRATADO enviara uma galeria previa em baixa resolucao em ate 5 (cinco) dias uteis apos a sessao, para selecao pelo CONTRATANTE.\n\nParagrafo 1: As fotografias finais serao entregues tratadas em alta resolucao em ate 15 (quinze) dias uteis, contados a partir da data em que o CONTRATANTE enviar sua selecao final.\n\nParagrafo 2: Arquivos RAW nao fazem parte da entrega e permanecem sob propriedade exclusiva do CONTRATADO.\n\nParagrafo 3: O CONTRATANTE tera acesso a galeria por 30 (trinta) dias para download.",
                'display_order' => 50,
            ],
            [
                'title'         => 'DOS DIREITOS AUTORAIS',
                'content'       => "Em conformidade com a Lei 9.610/1998, o CONTRATADO e titular dos direitos autorais sobre todas as fotografias.\n\nParagrafo 1: O CONTRATANTE recebe licenca nao exclusiva para uso pessoal e profissional.\n\nParagrafo 2: Vedada revenda ou sublicenciamento sem autorizacao escrita.\n\nParagrafo 3: Uso publico deve manter credito ao fotografo.",
                'display_order' => 60,
            ],
            [
                'title'         => 'DO USO DE IMAGEM PELO CONTRATADO',
                'content'       => "O CONTRATANTE {autorizacao_imagem} o uso de suas imagens pelo CONTRATADO para portfolio, divulgacao e marketing.\n\nParagrafo unico: A autorizacao podera ser revogada mediante comunicacao escrita, aplicando-se apenas a novas publicacoes. O CONTRATADO nao sera obrigado a recolher materiais fisicos ja impressos ou remover campanhas publicitarias que ja estejam em veiculacao no momento da solicitacao.",
                'display_order' => 70,
            ],
            [
                'title'         => 'DO CANCELAMENTO E REAGENDAMENTO',
                'content'       => "a) Cancelamento com mais de 7 (sete) dias de antecedencia: reembolso integral.\n\nb) Cancelamento com menos de 7 (sete) dias: retencao de 50% do valor pago a titulo de multa compensatoria pela reserva de agenda, bloqueio da data para outros clientes e custos administrativos.\n\nc) Reagendamento permitido ate 2 (duas) vezes, sem custo, com 48h de antecedencia.\n\nd) Cancelamento pelo CONTRATADO: reembolso integral.",
                'display_order' => 80,
            ],
            [
                'title'         => 'DA AUSENCIA (NO-SHOW)',
                'content'       => "O nao comparecimento sem comunicacao previa de 24 (vinte e quatro) horas acarreta a perda integral dos valores ja pagos, configurando no-show.\n\nParagrafo unico: Caso deseje reagendar, incidira taxa administrativa de 20% sobre o valor do pacote.",
                'display_order' => 90,
            ],
            [
                'title'         => 'DA FORCA MAIOR',
                'content'       => "Em caso de impossibilidade por forca maior (catastrofes naturais, pandemias, falecimento ou enfermidade grave de qualquer das partes), a sessao sera reagendada sem custo adicional.",
                'display_order' => 100,
            ],
            [
                'title'         => 'DA PROTECAO DE DADOS (LGPD)',
                'content'       => "Dados pessoais tratados conforme Lei 13.709/2018, utilizados exclusivamente para execucao do contrato, comunicacao e documentos fiscais. Dados nao serao compartilhados com terceiros sem consentimento.",
                'display_order' => 110,
            ],
            [
                'title'         => 'DO FORO',
                'content'       => "As partes elegem o Foro da Comarca de Sao Paulo/SP para dirimir quaisquer controversias oriundas do presente contrato, com exclusao de qualquer outro, por mais privilegiado que seja.",
                'display_order' => 120,
            ],
        ];

        foreach ($sections as $s) {
            $s['is_active']  = 1;
            $s['created_at'] = date('Y-m-d H:i:s');
            $s['updated_at'] = date('Y-m-d H:i:s');
            $db->table('contract_sections')->insert($s);
        }
    }
}
