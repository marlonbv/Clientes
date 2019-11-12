<?php

//CONFIGURATION for SmartAdmin UI
//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL . "/index.php"
);

include_once "js/repositorio.php";
session_start();
$login = $_SESSION['login'];
$login = "'" . $login . "'";

$arrayPermissao = array();

$reposit = new reposit();
$result = $reposit->SelectCondTrue("usuario| login = " . $login . " AND ativo = 1");
if ($row = $result) {

    $codigoUsuario = $row['codigo'];
    $tipoUsuario = $row['tipoUsuario'];

    if ($tipoUsuario === "C") {
        $sql = " SELECT FNC.nome FROM dbo.usuarioFuncionalidade USUF
				 INNER JOIN dbo.funcionalidade FNC ON FNC.codigo = USUF.funcionalidade ";
        $sql = $sql . " WHERE USUF.usuario = " . $codigoUsuario . " ";
        $result = $reposit->RunQuery($sql);
        while (($row = odbc_fetch_array($result))) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }
    if ($tipoUsuario === "S") {
        $sql = " SELECT nome FROM dbo.funcionalidade";
        $result = $reposit->RunQuery($sql);
        while (($row = odbc_fetch_array($result))) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }
}
 
// Menu de Configurações de Usuário
$page_nav = array("home" => array("title" => "Home", "icon" => "fa-home", "url" => APP_URL . "/index.php"));
$condicaoConfiguracoesOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) OR in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) OR in_array('PARAMETRO_ACESSAR', $arrayPermissao, true));

//Menu de Operações -> Cliente
$condicaoOperacaoOK = (in_array('CLIENTE_ACESSAR', $arrayPermissao,true));  
$condicaoTabelaBasicaOK = (in_array('TABELABASICA_ACESSAR', $arrayPermissao,true)); 
$condicaoEmpreendimentoOK = (in_array('EMPREENDIMENTO_ACESSAR', $arrayPermissao,true));  

// Menu de Configurações OK 
if ($condicaoConfiguracoesOK) {
    $page_nav['controle'] = array("title" => "Configurações", "icon" => "fa-gear");
    $page_nav['controle']['sub'] = array();
    if (in_array('USUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['controle']['sub'] += array("usuarios" => array("title" => "Usuário", "url" => APP_URL . "/usuarioFiltro.php"));
    }
    if (in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['controle']['sub'] += array("permissoesUsuarios" => array("title" => "Permissões do Usuário", "url" => APP_URL . "/usuarioFuncionalidadeFiltro.php"));
    }
//    if (in_array('PARAMETRO_ACESSAR', $arrayPermissao, true)) {
//        $page_nav['controle']['sub'] += array("parametro" => array("title" => "Parametros", "url" => APP_URL . "/parametro.php"));
//    }
} 

if ($condicaoOperacaoOK) {
    $page_nav['cadastro'] = array("title" => "Cadastros", "icon" => "fa-pencil-square-o");
    $page_nav['cadastro']['sub'] = array();
    if (in_array('CLIENTE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("cliente" => array("title" => "Clientes", "url" => APP_URL . "/clienteFiltro.php"));
    }
    if (in_array('CAMINHAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("caminhao" => array("title" => "Caminhões", "url" => APP_URL . "/caminhaoFiltro.php"));
    }
    if (in_array('PRODUTO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("produto" => array("title" => "Produtos", "url" => APP_URL . "/produtoFiltro.php"));
    }
    if (in_array('PRECO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("preco" => array("title" => "Tabela de Peços", "url" => APP_URL . "/tabelaPreco.php"));
    }
    
    //*******************************************INÍCIO EMPREENDIMENTO***********************************************
    if (in_array('EMPREENDIMENTO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("empreendimento" => array("title" => "Empreendimentos", "url" => APP_URL . "/empreendimentoFiltro.php"));
    }
    if (in_array('INCORPORADOR_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("incorporador" => array("title" => "Incorporador", "url" => APP_URL . "/incorporadorFiltro.php"));
    }
    if (in_array('BLOCO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("bloco" => array("title" => "Blocos", "url" => APP_URL . "/blocoFiltro.php"));
    }
    if (in_array('UNIDADE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("unidade" => array("title" => "Unidades", "url" => APP_URL . "/unidadeFiltro.php"));
    }
    //*******************************************FIM EMPREENDIMENTO**************************************************
      
}
 
//*******************************************INÍCIO TABELAS BÁSICAS**********************************************
if ($condicaoTabelaBasicaOK) {
    $page_nav['tabelasBasicas'] = array("title" => "Tabelas básicas", "icon" => "fa-pencil-square-o");
    $page_nav['tabelasBasicas']['sub'] = array();
    if (in_array('SEXO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("sexo" => array("title" => "Sexo", "url" => APP_URL . "/sexoFiltro.php"));
    }
    if (in_array('TIPOCLIENTE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("tipoCliente" => array("title" => "Tipo Cliente", "url" => APP_URL . "/tipoClienteFiltro.php"));
    }
    if (in_array('ESTADOCIVIL_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("estadoCivil" => array("title" => "Estado Civil", "url" => APP_URL . "/estadoCivilFiltro.php"));
    }
    if (in_array('REDESSOCIAIS_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("redesSociais" => array("title" => "Redes Sociais", "url" => APP_URL . "/RedesSociaisFiltro.php"));
    }
    if (in_array('UF_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("uf" => array("title" => "UF", "url" => APP_URL . "/ufFiltro.php"));
    }
    if (in_array('POSICAOUNIDADE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("posicaoUnidade" => array("title" => "Posição Relativa da Unidade", "url" => APP_URL . "/posicaoUnidadeFiltro.php"));
    }
    if (in_array('POSICAOSOL_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("posicaoSol" => array("title" => "Posição do Sol", "url" => APP_URL . "/posicaoSolFiltro.php"));
    }
    if (in_array('VISTAUNIDADE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("vistaUnidade" => array("title" => "Vista da Unidade", "url" => APP_URL . "/vistaUnidadeFiltro.php"));
    }
    if (in_array('NATUREZA_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("natureza" => array("title" => "Natureza", "url" => APP_URL . "/naturezaFiltro.php"));
    }
    if (in_array('ESTAGIOOBRA_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("estagioObra" => array("title" => "Estágio da obra", "url" => APP_URL . "/estagioObraFiltro.php"));
    }
    if (in_array('TIPOLOGIA_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("tipologia" => array("title" => "Tipologia", "url" => APP_URL . "/tipologiaFiltro.php"));
    }
    if (in_array('QUADROAREAS_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelasBasicas']['sub'] += array("quadroAreas" => array("title" => "Quadro de Áreas", "url" => APP_URL . "/quadroAreasFiltro.php"));
    }
}
//*******************************************FIM TABELAS BÁSICAS**********************************************

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>
