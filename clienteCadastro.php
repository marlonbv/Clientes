<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php"); 

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CLIENTE_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CLIENTE_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CLIENTE_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Cliente";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
include "girComum.php";
include "gir_script.js";
include "sqlscope.php";


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["cliente"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Controle de Permissão"] = "";
    include("inc/ribbon.php"); 
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- Accordion de Cliente --> 
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Cliente</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formCliente" method="post">    
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro de Clientes 
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label" for="codigo">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">&nbsp;</label>
                                                                <label id="labelAtivo" class="checkbox ">
                                                                    <input checked="checked" id="ativo" name="ativo" type="checkbox" value="true"><i></i>
                                                                    Ativo 
                                                                </label>                                                                                    
                                                            </section>                                                                                                                                            
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row"><br> 
                                                            <section class="col col-6">
                                                                <label class="label" for="nome">Nome</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" type="text" value="" autocomplete="off" class="required" required>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="cpf">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" data-mask="999.999.999-99" maxlength="14" name="cpf" type="text" value="" class="required" required>
                                                                </label>
                                                            </section> 
                                                            <section class="col col-2">
                                                                <label class="label" for="dtNasc">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dtNasc"  name="dtNasc" type="text" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder= "-" autocomplete="off" required>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dtAdInicial">Data de Admissão</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dtAdInicial"  name="dtAdInicial" type="text" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder= "-" autocomplete="off">
                                                                </label>
                                                            </section> 
                                                             
                                                             
                                                        </div>
                                                        <div class="row">
                                                             <section class="col col-2">
                                                                <label class="label" for="sexo">Sexo</label>
                                                                <label class="select">
                                                                    <select id="sexo" name="sexo" class="required" required>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "sexo";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>            
                                                            </section> 
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoCliente">Tipo de Cliente</label>
                                                                <label class="select">
                                                                    <select id="tipoCliente" name="tipoCliente">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "tipoCliente";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $tipoCliente = $row['tipoCliente'];
                                                                            $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $tipoCliente . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label> 
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estadoCivil">Estado Civil</label>
                                                                <label class="select">
                                                                    <select id="estadoCivil" name="estadoCivil">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "estadoCivil";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['estadoCivil'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>            
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                        <section class="col col-12">
                                                                <label class="label" for="obs">Observação</label>
                                                                <label class="input">
                                                                    <input id="obs" maxlength="255" name="obs" type="text" value="">    
                                                                </label>
                                                            </section>

                                                        </div> 
                                                    </fieldset> 
                                                </div>                                                        
                                            </div> 
                                        </div>
                                        <!-- Accordion de Contato --> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="collapsed" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="JsonTels" name="JsonTels" type="hidden" value="[]">
                                                        <input id="JsonEmails" name="JsonEmails" type="hidden" value="[]">
                                                        <div id="formTelefone" class="col-sm-6">
                                                            <input id="telefoneId" name="telefoneId" type="hidden" value="">
                                                            <input id="descricaoTelefonePrincipal" name="descricaoTelefonePrincipal" type="hidden" value="">
                                                            <input id="sequencialTel" name="sequencialTel" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-5">
                                                                        <label class="label" for="telefone">Celular</label>
                                                                        <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                            <input id="telefone" class="form-control" data-mask-placeholder=" " data-mask="(99) 99999-9999" name="telefone" type="text" value="">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-5">
                                                                        <label class="label" for="telefoneFixo">Fixo</label>
                                                                        <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                            <input id="telefoneFixo" class="form-control" data-mask-placeholder=" " data-mask="(99) 9999-9999" name="telefoneFixo" type="text" value="">
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">

                                                                    <section class="col col-md-3">
                                                                        <label class="label" for="telefonePrincipal"> </label>
                                                                        <label id="labelTelefonePrincipal" class="checkbox ">
                                                                            <input id="telefonePrincipal" name="telefonePrincipal" type="checkbox" value="true"><i></i>
                                                                            Principal 
                                                                        </label>                                                                        
                                                                    </section>
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 100%;">Telefone</th> 
                                                                            <th class="text-left">Principal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div id="formEmail" class="col-sm-6">
                                                            <input id="emailId" name="emailId" type="hidden" value="">
                                                            <input id="sequencialEmail" name="sequencialEmail" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-10">
                                                                        <label class="label" for="email">Email</label>
                                                                        <label class="input"><i class="icon-prepend fa fa-envelope-o"></i>
                                                                            <input id="email" maxlength="50" name="email" type="text" value="">
                                                                        </label>
                                                                    </section>
                                                                    
                                                                </div>
                                                                <div class="row">
                                                                    
                                                                    <section class="col col-md-3">
                                                                        <label class="label" for="emailPrincipal"> </label>
                                                                        <label id="labelEmailPrincipal" class="checkbox ">
                                                                            <input id="emailPrincipal" name="emailPrincipal" type="checkbox" value="true"><i></i>
                                                                            Principal 
                                                                        </label>                                                                        
                                                                    </section>
                                                                    
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 100%;">Email</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>                                                    
                                        </div>
                                        <!-- Accordion de Endereço --> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco" class="collapsed" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <input id="JsonEnds" name="JsonEnds" type="hidden" value="[]">
                                                    <fieldset id="formEndereco">
                                                        <input id="enderecoId" name="enderecoId" type="hidden" value="">
                                                        <input id="sequencialEnd" name="sequencialEnd" type="hidden" value="">
                                                        <input id="tipoEndereco" name="tipoEndereco" type="hidden" value="">

                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="cep">Cep</label>
                                                                <label class="input">
                                                                    <input id="cep"  name="cep" type="text" data-mask="99999-999" data-mask-placeholder="X" value="" onchange="buscaCep()">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="enderecoPrincipal"> </label>
                                                                <label id="labelEnderecoPrincipal" class="checkbox ">
                                                                    <input checked="checked" id="enderecoPrincipal" name="enderecoPrincipal" type="checkbox" value="true"><i></i>
                                                                    Endereço Principal                                                                                 
                                                                </label>
                                                            </section>  

                                                            <section class="col col-4">
                                                                <label class="label" for="tipoEnd">Tipo Endereço</label>                                                                       
                                                                <div class="inline-group">
                                                                    <label class="radio">
                                                                        <input type="radio" id="tipoEnd" name="tipoEnd" value="1" checked><i></i>Residencial
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" id="tipoEnd" name="tipoEnd"><i></i>Comercial
                                                                    </label>
                                                                </div>
                                                            </section> 

                                                        </div>  
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="tipoLogradouro">Tipo Logradouro</label>
                                                                <label class="input">
                                                                    <input id="tipoLogradouro"  name="tipoLogradouro" maxlength="15" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-9">
                                                                <label class="label" for="logradouro">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro"  name="logradouro" maxlength="150" type="text" value="">
                                                                </label>
                                                            </section>
                                                        </div>                                                                
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="numero">Número</label>
                                                                <label class="input">
                                                                    <input id="numero"  name="numero" maxlength="20" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-9">
                                                                <label class="label" for="complemento">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento"  name="complemento" maxlength="50" type="text" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label" for="bairro">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro"  name="bairro" maxlength="30" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="unidadeFederacao">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao"> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "unidadeFederacao";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['sigla'];
                                                                            $descricao = mb_convert_encoding($row['sigla'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>                                                                                                                                
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade"  name="cidade" maxlength="30" type="text" value="">
                                                                </label>
                                                            </section>                                                                                        
                                                        </div> 
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label" for="referencia">Referência</label>
                                                                <label class="input">
                                                                    <input id="referencia"  name="referencia" maxlength="100" type="text" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <button id="btnLimparEndereco" type="button" class="btn btn-default" title="Limpar Endereço">
                                                                    <i class="fa fa-file-o"></i>
                                                                </button>
                                                                <button id="btnAddEndereco" type="button" class="btn btn-primary" title="Adicionar Endereço">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverEndereco" type="button" class="btn btn-danger" title="Remover Endereço">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableEndereco" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 10px;">Logradouro</th>
                                                                        <th class="text-left" style="min-width: 10px;">Tipo</th>
                                                                        <th class="text-left" style="min-width: 10px;">Número</th>
                                                                        <th class="text-left" style="min-width: 10px;">Complemento</th>
                                                                        <th class="text-left" style="min-width: 10px;">Bairro</th>
                                                                        <th class="text-left" style="min-width: 10px;">UF</th>
                                                                        <th class="text-left" style="min-width: 10px;">Cidade</th>
                                                                        <th class="text-left" style="min-width: 10px;">CEP</th>
                                                                        <th class="text-left" style="min-width: 10px;">Endereço Principal</th>
                                                                        <th class="text-left" style="min-width: 10px;">Tipo Endereço</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- Accordion de Redes Sociais --> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseRedeSocial" class="collapsed" id="accordionRedeSocial">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Redes Sociais
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseRedeSocial" class="panel-collapse collapse">
                                                <div  class="panel-body no-padding">
                                                    <fieldset id="formRedes">

                                                        <input id="jsonRedes" name="jsonRedes" type="hidden" value="[]">

                                                        <input id="redeSocialId" name="redeSocialId" type="hidden" value="">
                                                        <input id="sequencialRedes" name="sequencialRedes" type="hidden" value="">
                                                        <input id="descricaoRedeSocial" name="descricaoRedeSocial" type="hidden" value=""> 
                                                        <div class="form-group">

                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <section class="col col-md-3">
                                                                        <label class="label" for="redeSocial">Redes Sociais:</label>
                                                                        <select id="redeSocial" name="redeSocial" class="form-control">
                                                                            <option></option>
                                                                            <?php
                                                                            //include "js/repositorio.php";        
                                                                            $reposit = new reposit();
                                                                            $tabela = "redesSociais";

                                                                            $result = $reposit->SelectAll($tabela . "|" . "");

                                                                            while (($row = odbc_fetch_array($result))) {
                                                                                $id = $row['codigo'];
                                                                                $descricao = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');
                                                                                echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                            }
                                                                            ?>

                                                                        </select><i></i>
                                                                    </section>    
                                                                    <section class="col col-md-5">
                                                                    <label class="label" for="redeLink">Link:</label> 
                                                                    <label class="input"><i class="icon-prepend fa fa-link"></i>
                                                                    <input id="redeLink" name="redeLink" type="text" maxlength="255" value="" class="form-control">
                                                                    </label> 
                                                                    </section>
                                                                     <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddRedes" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverRedes" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section> 
                                                            </div>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableRedes" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 100%;">Redes Sociais</th>
                                                                        <th class="text-left" style="min-width: 100%;">Link </th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div> 

                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash" ></span>
                                        </button>
                                        
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" 
                                             tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" 
                                             style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>CONFIRMA A EXCLUSÃO ? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- CPF  -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" 
                                             tabindex="-1" role="dialog" aria-describedby="dlgSimpleConfirmaCPF" aria-labelledby="ui-id-1" 
                                             style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleConfirmaCPF" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>Este CPF já está registrado. Deseja reutilizá-lo? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o" ></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o" ></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward " ></span>
                                        </button>
                                    </footer>
                                </form>                                            
                            </div>
                        </div>                                
                    </div>                                
                </article>
            </div>
        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<script src="<?php echo ASSETS_URL; ?>/js/businessCliente.js" type="text/javascript"></script>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    //Transforma  os atributos das listas em JSON
    jsonTelsArray = JSON.parse($("#JsonTels").val());
    jsonEmailsArray = JSON.parse($("#JsonEmails").val());
    jsonEndsArray = JSON.parse($("#JsonEnds").val());
    jsonRedesArray = JSON.parse($("#jsonRedes").val());

    $(document).ready(function () {
      
        //-> ALTERAR $('.datepicker').mask('99/99/9999',{placeholder: "--/--/----"});
        
        //Ações dos botões de Telefone
        $('#btnAddTelefone').on("click", function () {
            if (validaTelefone() === true) {
                addTelefone();
            }
        });

        $('#btnRemoverTelefone').on("click", function () {
            excluirTelefone();
        });

        //Ações dos botões de Email
        $('#btnAddEmail').on("click", function () {
            if (validaEmail() === true) {
                addEmail();
            }
        });

        $('#btnRemoverEmail').on("click", function () {
            excluirEmail();
        });

        //Ações dos botões de Endereço
        $('#btnAddEndereco').on("click", function () {
            if (validaEndereco() === true) {
                addEndereco();
            }
        });

        $('#btnRemoverEndereco').on("click", function () {
            excluirEndereco();
        });

        $("#btnLimparEndereco").on("click", function () {
            clearFormEndereco();
        });

        //Ações dos botões de Redes Sociais
        $('#btnAddRedes').on("click", function () {
            addRedeSocial();
        });

        $('#btnRemoverRedes').on("click", function () {
            excluirRedes();
        });

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#formCliente').validate({
            // Rules for form validation
            rules: {
                'login': {
                    required: true,
                    maxlength: 15
                },
                'senha': {
                    senhaRequerida: true,
                    minlength: 7,
                    maxlength: 10
                },
                'senhaConfirma': {
                    confirmaSenhaRequerida: true,
                    confirmaSenhaequalto: true
                }
            },

            // Messages for form validation
            messages: {
                'login': {
                    required: 'Informe o Login.',
                    maxlength: 'Digite no máximo de 15 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres'
                },
                'senha': {
                    maxlength: 'Digite no máximo de 10 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres',
                    senharequerida: 'Informe a senha.'
                },
                'senhaConfirma': {
                    confirmacaosenharequerida: 'Informe a senha mais uma vez.',
                    confirmacaosenhaequalto: 'Informe a mesma senha digitada no campo senha.'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
                //$("#accordionCadastro").click();
                $("#accordionCadastro").removeClass("collapsed");
            },
            highlight: function (element) {
                //$(element).parent().addClass('error');
            },
            unhighlight: function (element) {
                //$(element).parent().removeClass('error');
            }
        });

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                    html: "Excluir registro",
                    "class": "btn btn-success",
                    click: function () {
                        $(this).dialog("close");
                        excluir();
                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
        });
        
        $('#dlgSimpleConfirmaCPF').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                    html: "Sim",
                    "class": "btn btn-success",
                    click: function () {
                        $(this).dialog("close");
                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Não",
                    "class": "btn btn-default",
                    click: function () {
                        $("#cpf").val("");
                        $(this).dialog("close");
                         
                    }
                }]
        });

        $("#btnExcluir").on("click", function () {
            var id = +$("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnNovo").on("click", function () {
            novo();
        });

        $("#btnVoltar").on("click", function () {
            voltar();

        });
        
        
        //Função que valida o cpf
         $("#cpf").on("change", function () {
         var val = $("#cpf").val();
         var retorno = validacao_cpf(val);
         
        recuperaCPF(val);
          
        if ( retorno === false) {
        smartAlert("Atenção", "O cpf digitado é inválido.", "error");
        $("#cpf").val("");
        return;  
        }  
        });
  
  
        //Ao alterar a data de Nascimento, faça...
        $("#dtNasc").on("change", function () {

            // Verificação de todas as datas
            var valor = $("#dtNasc").val();
            var validacao = validaData(valor);

            if(validacao === false){ 
             $("#dtNasc").val("");
            }
            
            //Verifica se a AdInicial > Data De Hoje.
            valor = formataData(valor); 
            var dtHoje = new Date();
        
            if(valor > dtHoje){
               smartAlert("Erro", "A data de nascimento não pode ser maior do que a data de hoje!", "error");
                $("#dtNasc").val("");  
            }        
        

        }); 
         
        //Ao alterar a data de admissão inicial, faça...
        $("#dtAdInicial").on("change", function () { 
          // Verificação de todas as datas
            var valor = $("#dtAdInicial").val();
            var validacao = validaData(valor);

            if(validacao === false){
             $("#dtAdInicial").val("");
            }
                  
        }); 
        
        //Função que permite apenas letras no campo nome.
        $('#nome').bind('keypress', validaCampoApenasLetras);
        
         
        carregaPagina();

    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaCliente(idd);
            }
        }
        $("#nome").focus();
    }

    function novo() {
        $(location).attr('href', 'clienteCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'clienteFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirCliente(id);
    }

    function gravar() { 
        //Atributos de cliente
        var id = +($("#codigo").val());
        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var dtNasc = $("#dtNasc").val();
        var dtAdInicial = $("#dtAdInicial").val();
        var sexo = +($("#sexo").val());
        var tipoCliente = ($("#tipoCliente").val());
        var estadoCivil = +($("#estadoCivil").val());
        var ativo = 0;
        if ($("#ativo").is(':checked')) {
            ativo = 1;
        }
        var obs = $("#obs").val();

        //Listas de email, tel e endereco
        var jsonTels = $("#JsonTels").val();
        var jsonEmails = $("#JsonEmails").val();
        var jsonEnds = $("#JsonEnds").val();
        var jsonRedesArrays = $("#jsonRedes").val();
         
        gravaCliente(id, nome, cpf, dtNasc, dtAdInicial, sexo, tipoCliente, estadoCivil, ativo, obs, jsonTels, jsonEmails, jsonEnds, jsonRedesArrays);
 
       }


    //****************************************************TELEFONE LISTA INICIO*****************************************
    function carregaTelefone(sequencialTel) {
        var arr = jQuery.grep(jsonTelsArray, function (item, i) {
            return (item.sequencialTel === sequencialTel);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefoneId").val(item.telefoneId);
            if (item.telefone.length === 15) {
                $("#telefone").val(item.telefone);
            } else {
                $("#telefoneFixo").val(item.telefone);
            }
            $("#sequencialTel").val(item.sequencialTel);
            $("#telefonePrincipal").val(item.telefonePrincipal);
            if (item.telefonePrincipal === 1) {
                $('#telefonePrincipal').prop('checked', true);
                $('#descricaoTelefonePrincipal').val("Sim");
            } else {
                $('#telefonePrincipal').prop('checked', false);
                $('#descricaoTelefonePrincipal').val("Não");
            }
        }
    }

    function clearFormTelefone() {
        $("#telefone").val('');
        $("#telefoneFixo").val('');
        $("#telefoneId").val('');
        $("#sequencialTel").val('');
        $('#telefonePrincipal').val(0);
        $('#telefonePrincipal').prop('checked', false);
        $('#descricaoTelefonePrincipal').val('');
    }

    function addTelefone() {
        var item = $("#formTelefone").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processDataTel});

        if (item["sequencialTel"] === '') {
            if (jsonTelsArray.length === 0) {
                item["sequencialTel"] = 1;
            } else {
                item["sequencialTel"] = Math.max.apply(Math, jsonTelsArray.map(function (o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTel"] = +item["sequencialTel"];
        }

        var index = -1;
        $.each(jsonTelsArray, function (i, obj) {
            if (+$('#sequencialTel').val() === obj.sequencialTel) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelsArray.splice(index, 1, item);
        else
            jsonTelsArray.push(item);

        $("#JsonTels").val(JSON.stringify(jsonTelsArray));
        fillTableTels();
        clearFormTelefone();
    }

    function excluirTelefone() {
        var arrSequencial = [];
        $('#tableTelefone input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonTelsArray.length - 1; i >= 0; i--) {
                var obj = jsonTelsArray[i];
                if (jQuery.inArray(obj.sequencialTel, arrSequencial) > -1) {
                    jsonTelsArray.splice(i, 1);
                }
            }

            $("#JsonTels").val(JSON.stringify(jsonTelsArray));
            fillTableTels();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 telefone para excluir.", "error");
    }
    //****************************************************TELEFONE LISTA FIM*****************************************

    //****************************************************REDE SOCIAL LISTA INICIO*****************************************
    function carregaRedes(sequencialRedes) {
        var arr = jQuery.grep(jsonRedesArray, function (item, i) {
            return (item.sequencialRedes === sequencialRedes);
        });

        clearFormRedes();

        if (arr.length > 0) {
            var item = arr[0];
            $("redeSocialId").val(item.redeSocialId);
            $("#redeSocial").val(item.redeSocial);
            $("#sequencialRedes").val(item.sequencialRedes);
            $("#descricaoRedeSocial").val(item.descricaoRedeSocial);
            $("#redeLink").val(item.redeLink);
        }

    }


    function clearFormRedes() {
        $("#redeSocialId").val('');
        $("#redeSocial").val('');
        $("#descricaoRedeSocial").val('');
        $("#sequencialRedes").val('');
    }


    function addRedeSocial() {
        var item = $("#formRedes").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processDataRedesSociais});

        if (item["sequencialRedes"] === '') {
            if (jsonRedesArray.length === 0) {
                item["sequencialRedes"] = 1;
            } else {
                item["sequencialRedes"] = Math.max.apply(Math, jsonRedesArray.map(function (o) {
                    return o.sequencialRedes;
                })) + 1;
            }
            item["redeSocialId"] = 0;
        } else {
            item["sequencialRedes"] = +item["sequencialRedes"];
        }

        var index = -1;
        $.each(jsonRedesArray, function (i, obj) {
            if (+$('#sequencialRedes').val() === obj.sequencialRedes) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonRedesArray.splice(index, 1, item);
        else
            jsonRedesArray.push(item);

        $("#jsonRedes").val(JSON.stringify(jsonRedesArray));
        fillTableRedes();
        clearFormRedes();
    }



    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailsArray, function (item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();

        if (arr.length > 0) {
            var item = arr[0];
            $("#emailId").val(item.emailId);
            $("#email").val(item.email);
            $("#sequencialEmail").val(item.sequencialEmail);
        }

    }

    function carregaEndereco(sequencialEnd) {
        var arr = jQuery.grep(jsonEndsArray, function (item, i) {
            return (item.sequencialEnd === sequencialEnd);
        });

        clearFormEndereco();

        if (arr.length > 0) {
            var item = arr[0];
            $("#enderecoId").val(item.enderecoId);
            $("#sequencialEnd").val(item.sequencialEnd);
            if (item.enderecoPrincipal === true) {
                $('#enderecoPrincipal').prop('checked', true);
            } else {
                $('#enderecoPrincipal').prop('checked', false);
            }
            $("#tipoLogradouro").val(item.tipoLogradouro);
            $("#logradouro").val(item.logradouro);
            $("#cidade").val(item.cidade);
            $("#numero").val(item.numero);
            $("#complemento").val(item.complemento);
            $("#unidadeFederacao").val(item.unidadeFederacao);
            $("#cep").val(item.cep);
            $("#bairro").val(item.bairro);
            $("#referencia").val(item.referencia);
            if (item.tipoEndereco === 'R') {
                $('#tipoEndereco1').prop('checked', true);
            }
            if (item.tipoEndereco === 'C') {
                $('#tipoEndereco2').prop('checked', true);
            }
        }
    }



    /*
     *  Limpa as listas de:
     *  Telefone, Email, Endereço e Rede Sociais. 
     */



    function clearFormEmail() {
        $("#email").val('');
        $("#emailId").val('');
        $("#sequencialEmail").val('');
    }

    function clearFormEndereco() {
        $("#enderecoId").val('');
        $("#sequencialEnd").val('');
        $('#enderecoPrincipal').prop('checked', false);
        $('#tipoEndereco1').prop('checked', false);
        $('#tipoEndereco2').prop('checked', false);
        $("#cep").val('');
        $("#tipoLogradouro").val('');
        $("#logradouro").val('');
        $("#numero").val('');
        $("#complemento").val('');
        $("#bairro").val('');
        $("#unidadeFederacao").val('');
        $("#cidade").val('');
        $("#referencia").val('');
        $("#tipoEndereco").val('');
    }

    // Funções que adicionam um item ás listas:
    // "+" de Telefone


    // "+" de Email
    function addEmail() {
        var item = $("#formEmail").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processData});

        if (item["sequencialEmail"] === '') {
            if (jsonEmailsArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailsArray.map(function (o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["emailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }

        var index = -1;
        $.each(jsonEmailsArray, function (i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailsArray.splice(index, 1, item);
        else
            jsonEmailsArray.push(item);

        $("#JsonEmails").val(JSON.stringify(jsonEmailsArray));
        fillTableEmails();
        clearFormEmail();
    }

    // "+" de Endereco
    function addEndereco() {
        var item = $("#formEndereco").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processDataEnd});

        if ((item["sequencialEnd"] === '') || (item["sequencialEnd"] === 0)) {
            if (jsonEndsArray.length === 0) {
                item["sequencialEnd"] = 1;
            } else {
                item["sequencialEnd"] = Math.max.apply(Math, jsonEndsArray.map(function (o) {
                    return o.sequencialEnd;
                })) + 1;
            }
            item["enderecoId"] = 0;
        } else {
            item["sequencialEnd"] = +item["sequencialEnd"];
        }

        item["descricaoEnderecoPrincipal"] = "Não";
        if (item["enderecoPrincipal"] === true) {
            item["descricaoEnderecoPrincipal"] = "Sim";
        }

        item["descricaoTipoEndereco"] = "";
        if (item["tipoEndereco"] === "R") {
            item["descricaoTipoEndereco"] = "Residencial";
        }
        if (item["tipoEndereco"] === "C") {
            item["descricaoTipoEndereco"] = "Comercial";
        }

        var index = -1;
        $.each(jsonEndsArray, function (i, obj) {
            if (+$('#sequencialEnd').val() === obj.sequencialEnd) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEndsArray.splice(index, 1, item);
        else
            jsonEndsArray.push(item);

        $("#JsonEnds").val(JSON.stringify(jsonEndsArray));
        fillTableEnds();
        clearFormEndereco();
    }

    // "+" de Redes Sociais


    //Processa as datas retornando os valores certos
    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefoneFixo")) {
            var valorTelFixo = $("#telefoneFixo").val();
            if (valorTelFixo !== '') {
                fieldName = "telefone";
            }
            return {name: fieldName, value: valorTelFixo};
        }

        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            var valorTelefonePrincipal = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                valorTelefonePrincipal = 1;
            }
            return {name: fieldName, value: valorTelefonePrincipal};
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefonePrincipal")) {
            var valorDescricaoTelefonePrincipal = "Não";
            if ($("#telefonePrincipal").is(':checked') === true) {
                valorDescricaoTelefonePrincipal = "Sim";
            }
            return {name: fieldName, value: valorDescricaoTelefonePrincipal};
        }


        return false;
    }

    function processData(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        return false;
    }
     

    function processDataEnd(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var tipoEndereco = "";

        if (fieldName !== '' && (fieldId === "tipoEndereco")) {
            if ($("#tipoEndereco1").is(':checked')) {
                tipoEndereco = "R";
            }
            if ($("#tipoEndereco2").is(':checked')) {
                tipoEndereco = "C";
            }
            return {name: fieldName, value: tipoEndereco};
        }
        if (fieldName !== '' && (fieldId === "sequencialEnd")) {
            var sequencialEnd = +$('#sequencialEnd').val();

            return {name: fieldName, value: sequencialEnd};
        }

        return false;
    }

    function processDataRedesSociais(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoRedeSocial")) {
            return {name: fieldName, value: $("#redeSocial option:selected").text()};
        }

     return false;
    }



    function excluirEmail() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonEmailsArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailsArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailsArray.splice(i, 1);
                }
            }

            $("#JsonEmails").val(JSON.stringify(jsonEmailsArray));
            fillTableEmails();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 email para excluir.", "error");
    }

    // Excluir endereços

    function excluirEndereco() {
        var arrSequencial = [];
        $('#tableEndereco input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonEndsArray.length - 1; i >= 0; i--) {
                var obj = jsonEndsArray[i];
                if (jQuery.inArray(obj.sequencialEnd, arrSequencial) > -1) {
                    jsonEndsArray.splice(i, 1);
                }
            }

            $("#JsonEnds").val(JSON.stringify(jsonEndsArray));
            fillTableEnds();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 endereço para excluir.", "error");
    }

    // Excluir Redes Sociais
    function excluirRedes() {
        var arrSequencial = [];
        $('#tableRedes input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonRedesArray.length - 1; i >= 0; i--) {
                var obj = jsonRedesArray[i];
                if (jQuery.inArray(obj.sequencialRedes, arrSequencial) > -1) {
                    jsonRedesArray.splice(i, 1);
                }
            }

            $("#jsonRedes").val(JSON.stringify(jsonRedesArray));
            fillTableRedes();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 endereço para excluir.", "error");
    }


    //Função que valida os campos:
    function validaTelefone() {
        var existe = false;
        var achou = false;
        var tel = $('#telefone').val();
        var telFixo = $('#telefoneFixo').val();
        var sequencial = +$('#sequencialTel').val();
        var telefonePrincipalMarcado = 0;
        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        } 
        
        if ((tel === '') & (telFixo === '')) {
            smartAlert("Erro", "Informe um telefone.", "error");
            return false;
        }
  
        for (i = jsonTelsArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelsArray[i].telefonePrincipal === 1) && (jsonTelsArray[i].sequencialTel !== sequencial)) {
                    achou = true;
                    break;
                }
            }


            if (tel !== "") {
                if ((jsonTelsArray[i].telefone === tel) && (jsonTelsArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }

            if (telFixo !== "") {
                if ((jsonTelsArray[i].telefone === telFixo) && (jsonTelsArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (telefonePrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone principal na lista.", "error");
            return false;
        }
 
        return true;
    }

    function validaEmail() {
        var existe = false;
        var email = $('#email').val();
        var sequencial = +$('#sequencialEmail').val();
        var emailValido = false;

        if (email === '') {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }

        if (validateEmail(email)) {
            emailValido = true;
        }

        if (emailValido === false) {
            smartAlert("Erro", "Email inválido.", "error");
            return false;
        }

        for (i = jsonEmailsArray.length - 1; i >= 0; i--) {
            var obj = jsonEmailsArray[i];

            if ((jsonEmailsArray[i].email === email) && (jsonEmailsArray[i].sequencialEmail !== sequencial)) {
                existe = true;
                break;
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado.", "error");
            return false;
        }

        return true;
    }

    function validaEndereco() {
        var achou = false;
        var cep = $('#cep').val();
        var sequencial = +$('#sequencialEnd').val();
        var enderecoPrincipalMarcado = $("#enderecoPrincipal").is(':checked');

        var tipoEnderecoMarcado = "";
        if ($("#tipoEndereco1").is(':checked')) {
            tipoEnderecoMarcado = "R";
        }
        if ($("#tipoEndereco2").is(':checked')) {
            tipoEnderecoMarcado = "C";
        }

        var existe = false;

        var tipo = $("#tipoLogradouro").val();
        var logradouro = $("#logradouro").val();
        var numero = $("#numero").val();
        var bairro = $("#bairro").val();
        var unidadeFederacao = $("#unidadeFederacao").val();
        var cidade = $("#cidade").val();


        if (tipoEnderecoMarcado === '') {
            smartAlert("Erro", "Informe o tipo de endereço.", "error");
            return false;
        }

        if (tipo === '') {
            smartAlert("Erro", "Informe o tipo do logradouro.", "error");
            return false;
        }

        if (logradouro === '') {
            smartAlert("Erro", "Informe o logradouro.", "error");
            return false;
        }

        if (numero === '') {
            smartAlert("Erro", "Informe o número.", "error");
            return false;
        }

        if (bairro === '') {
            smartAlert("Erro", "Informe o bairro.", "error");
            return false;
        }

        if (unidadeFederacao === '') {
            smartAlert("Erro", "Informe a U.F.", "error");
            return false;
        }

        if (cidade === '') {
            smartAlert("Erro", "Informe a cidade.", "error");
            return false;
        }

        for (i = jsonEndsArray.length - 1; i >= 0; i--) {
            if (enderecoPrincipalMarcado === true) {
                if ((jsonEndsArray[i].enderecoPrincipal === true) && (jsonEndsArray[i].sequencialEnd !== sequencial)) {
                    achou = true;
                    break;
                }
            }

            if ((jsonEndsArray[i].cepCom === cep) && (jsonEndsArray[i].sequencialEnd !== sequencial)) {
                existe = true;
                break;
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Endereço já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (enderecoPrincipalMarcado === true)) {
            smartAlert("Erro", "Já existe um endereço principal na lista.", "error");
            return false;
        }

        return true;
    }




    // Função que preenche as tabelas com os valores dos formulários
    function fillTableTels() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelsArray.length; i++) {
            var row = $('<tr />');
            $("#tableTelefone tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelsArray[i].sequencialTel + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelsArray[i].sequencialTel + ');">' + jsonTelsArray[i].telefone + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelsArray[i].descricaoTelefonePrincipal + '</td>'));
        }
    }

    function fillTableEmails() {
        $("#tableEmail tbody").empty();
        for (var i = 0; i < jsonEmailsArray.length; i++) {
            var row = $('<tr />');
            $("#tableEmail tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailsArray[i].sequencialEmail + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailsArray[i].sequencialEmail + ');">' + jsonEmailsArray[i].email + '</td>'));
        }
    }

    function fillTableEnds() {
        $("#tableEndereco tbody").empty();
        for (var i = 0; i < jsonEndsArray.length; i++) {
            var row = $('<tr />');
            $("#tableEndereco tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEndsArray[i].sequencialEnd + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEndereco(' + jsonEndsArray[i].sequencialEnd + ');">' + jsonEndsArray[i].logradouro + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].tipoLogradouro + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].numero + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].complemento + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].bairro + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].unidadeFederacao + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].cidade + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].cep + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].descricaoEnderecoPrincipal + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEndsArray[i].descricaoTipoEndereco + '</td>'));
        }
    }

    function fillTableRedes() {

        $("#tableRedes tbody").empty();
        for (var i = 0; i < jsonRedesArray.length; i++) {
            var row = $('<tr/>');
            $("#tableRedes tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRedesArray[i].sequencialRedes + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaRedes(' + jsonRedesArray[i].sequencialRedes + ');">' + jsonRedesArray[i].descricaoRedeSocial + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonRedesArray[i].redeLink + '</td>'));
        }
    }

    function buscaCep(){
        var cep = $("#cep").val();
        recuperaCep(cep);
    }
    
    //Função que permite digitar apenas letras em um campo html 
    function validaCampoApenasLetras(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäöëïüãõçÇãõáÁàÀéÉèÈíÍìÌóÓòÒúÚùÙ ]/i);
    return pattern.test(value);
    }
    
    
</script>