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
                'content'       => "CONTRATADO: Marco Santo, pessoa fisica, com estudio na Lapa, Sao Paulo/SP.\n\nCONTRATANTE: {nome_cliente}, CPF: {cpf_cliente}, {estado_civil}, residente em {endereco_completo}, e-mail: {email}, telefone: {telefone}.",
                'display_order' => 10,
            ],
            [
                'title'         => 'DO OBJETO',
                'content'       => "Prestacao de servicos fotograficos conforme pacote {nome_pacote}, incluindo sessao fotografica no estudio do CONTRATADO e {qtd_fotos} fotografias tratadas digitalmente.",
                'display_order' => 20,
            ],
            [
                'title'         => 'DO VALOR E PAGAMENTO',
                'content'       => "Valor total de R\$ {valor}, pago via {forma_pagamento} no ato da contratacao.\n\nParagrafo unico: Fotos adicionais alem do pacote serao cobradas a R\$ {valor_foto_extra} cada, mediante aprovacao previa do CONTRATANTE.",
                'display_order' => 30,
            ],
            [
                'title'         => 'DA DATA E LOCAL',
                'content'       => "A sessao sera realizada na data agendada entre as partes, no estudio do CONTRATADO na Lapa, Sao Paulo/SP, ou em locacao externa previamente acordada.",
                'display_order' => 40,
            ],
            [
                'title'         => 'DA ENTREGA',
                'content'       => "Fotografias entregues em formato digital (alta resolucao) no prazo de ate 15 dias uteis apos a sessao, por meio de galeria online privada.\n\nParagrafo 1: Arquivos RAW nao fazem parte da entrega e permanecem sob propriedade exclusiva do CONTRATADO.\n\nParagrafo 2: O CONTRATANTE tera acesso a galeria por 30 dias para download.",
                'display_order' => 50,
            ],
            [
                'title'         => 'DOS DIREITOS AUTORAIS',
                'content'       => "Em conformidade com a Lei 9.610/1998, o CONTRATADO e titular dos direitos autorais sobre todas as fotografias.\n\nParagrafo 1: O CONTRATANTE recebe licenca nao exclusiva para uso pessoal e profissional.\n\nParagrafo 2: Vedada revenda ou sublicenciamento sem autorizacao escrita.\n\nParagrafo 3: Uso publico deve manter credito ao fotografo.",
                'display_order' => 60,
            ],
            [
                'title'         => 'DO USO DE IMAGEM PELO CONTRATADO',
                'content'       => "O CONTRATANTE {autorizacao_imagem} o uso de suas imagens pelo CONTRATADO para portfolio, divulgacao e marketing.\n\nParagrafo unico: A autorizacao podera ser revogada a qualquer momento mediante comunicacao escrita.",
                'display_order' => 70,
            ],
            [
                'title'         => 'DO CANCELAMENTO E REAGENDAMENTO',
                'content'       => "a) Cancelamento com mais de 7 dias de antecedencia: reembolso integral.\n\nb) Cancelamento com menos de 7 dias: retencao de 50% do valor.\n\nc) Reagendamento permitido ate 2 vezes, sem custo, com 48h de antecedencia.\n\nd) Cancelamento pelo CONTRATADO: reembolso integral.",
                'display_order' => 80,
            ],
            [
                'title'         => 'DA AUSENCIA (NO-SHOW)',
                'content'       => "Nao comparecimento sem comunicacao previa de 24h sera considerado no-show, sem direito a reembolso.\n\nParagrafo unico: Reagendamento possivel mediante taxa de 20% do valor do pacote.",
                'display_order' => 90,
            ],
            [
                'title'         => 'DA FORCA MAIOR',
                'content'       => "Em caso de impossibilidade por forca maior, a sessao sera reagendada sem custo adicional.",
                'display_order' => 100,
            ],
            [
                'title'         => 'DA PROTECAO DE DADOS (LGPD)',
                'content'       => "Dados pessoais tratados conforme Lei 13.709/2018, utilizados exclusivamente para execucao do contrato, comunicacao e documentos fiscais. Dados nao serao compartilhados com terceiros sem consentimento.",
                'display_order' => 110,
            ],
            [
                'title'         => 'DO FORO',
                'content'       => "As partes elegem o Foro da Comarca de Sao Paulo/SP.",
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
