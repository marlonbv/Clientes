<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('EMPREENDIMENTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('EMPREENDIMENTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('EMPREENDIMENTO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Cadastro";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["empreendimento"]["active"] = true;

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
                            <h2>Empreendimento</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formEmpreendimento" method="post" autocomplete="off" />    
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Informações
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <div class="row">
                                                            
                                                            <section class="col col-8">
                                                                <label class="label" for="nomeEmprendi">Nome do empreendimento</label>
                                                                <label class="input">
                                                                    <input  type="text" id="nomeEmprendi" name="nomeEmprendi" class="required" required/>
                                                                </label>       
                                                            </section>  
                                                            
                                                            <section class="col col-4">
                                                                <label class="label" for="insMunicipal">Inscrição municipal</label>
                                                                <label class="input">
                                                                    <input  type="text" id="insMunicipal" name="insMunicipal"/>
                                                                </label>       
                                                            </section> 
                                                            
                                                            <section class="col col-8">
                                                                <label class="label" for="engResponsavel">Engenheiro responsável</label>
                                                                <label class="input">
                                                                    <input  type="text" id="engResponsavel" name="engResponsavel"/>
                                                                </label>       
                                                            </section> 
                                                            
                                                            <section class="col col-4">
                                                                <label class="label" for="incorGestor">Incorporador gestor</label> 
                                                                <label class="select">
                                                                    <select id="incorGestor" name="incorGestor" class="required" required>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "incorporador";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['razaoSocial'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>        
                                                            </section> 
                                                            
                                                            <section class="col col-8">
                                                                <label class="label" for="observacao">Observação</label>
                                                                <label class="input">
                                                                    <input  type="text" id="observacao" name="observacao"/>
                                                                </label>       
                                                            </section> 
                                                            
                                                            <section class="col col-1">
                                                                <label class="label" for="blocos">Blocos</label>
                                                                <label class="input">
                                                                    <input id="blocos" name="blocos" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            
                                                            <section class="col col-1">
                                                                <label class="label" for="unidade">Unidade</label>
                                                                <label class="input">
                                                                    <input id="unidade" name="unidade" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            
                                                            <section class="col col-1">
                                                                <label class="label" for="vinculadas">Vinculadas</label>
                                                                <label class="input">
                                                                    <input id="vinculadas" name="vinculadas" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                     
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
                                                                <label class="input"> <!-- add onchange="buscaCep()" -->
                                                                    <input id="cep"  name="cep" type="text" data-mask="99999-999" data-mask-placeholder="X" value=""  class="required" required onchange="buscaCep()">
                                                                </label>
                                                            </section>

                                                        </div>  
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="tipoLogradouro">Tipo Logradouro</label>
                                                                <label class="input">
                                                                    <input id="tipoLogradouro"  name="tipoLogradouro" maxlength="15" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>
                                                            <section class="col col-9">
                                                                <label class="label" for="logradouro">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro"  name="logradouro" maxlength="150" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>
                                                        </div>                                                                
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="numero">Número</label>
                                                                <label class="input">
                                                                    <input id="numero"  name="numero" maxlength="20" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>
                                                            <section class="col col-9">
                                                                <label class="label" for="complemento">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento"  name="complemento" maxlength="50" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label" for="bairro">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro"  name="bairro" maxlength="30" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="unidadeFederacao">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "unidadeFederacao";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['sigla'];
                                                                            $descricao = mb_convert_encoding($row['unidadeFederacao'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $id . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>                                                                                                                                
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade"  name="cidade" maxlength="30" type="text" value="" class="required" required>
                                                                </label>
                                                            </section>                                                                                        
                                                        </div> 
                                                         
                                                    </fieldset>
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
                                            <button type="submit" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/businessEmpreendimento.js" type="text/javascript"></script>

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

    $(document).ready(function () { 
        
        $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );
        
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        })); 
        
        $('#formEmpreendimento').validate({
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

        $("#btnExcluir").on("click", function () {
            var id = +$("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                 
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
                recuperaEmpreendimento(idd);
            }
        } 
    }

    function buscaCep(){
        var cep = $("#cep").val();
        recuperaCep(cep);
    }

    function novo() {
        $(location).attr('href', 'empreendimentoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'empreendimentoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirEmpreendimento(id);
    }

    function gravar() {
        var id = +($("#codigo").val()); 
        var nome = $("#nomeEmprendi").val();
        var inscricaoMunicipal = $("#insMunicipal").val();
        var engenheiroResponsavel = $("#engResponsavel").val();
        var incorporador = $("#incorGestor").val();
        var observacao = $("#observacao").val();
        var cep = $("#cep").val();
        var tipoLogradouro = $("#tipoLogradouro").val();
        var logradouro = $("#logradouro").val();
        var numero = +($("#numero").val()); 
        var complemento = $("#complemento").val();
        var estado = $("#unidadeFederacao").val();
        var cidade = $("#cidade").val();
        var bairro = $("#bairro").val();
        
        if ((nome === 0) || (nome === "")) {
                smartAlert("Atenção", "Informe o empreendimento.", "error");
                $("#nome").focus();
                return;
            }
            
        if ((incorporador === 0) || (incorporador === "")) {
                smartAlert("Atenção", "Informe o incorporador gestor.", "error");
                $("#incorporador").focus();
                return;
        } 
        
        if ((cep === 0) || (cep === "")) {
                smartAlert("Atenção", "Informe o cep.", "error");
                $("#cep").focus();
                return;
        }
        
        if ((tipoLogradouro === 0) || (tipoLogradouro === "")) {
                smartAlert("Atenção", "Informe o tipo do logradouro.", "error");
                $("#tipoLogradouro").focus();
                return;
        }
        
        if ((numero === 0) || (numero === "")) {
                smartAlert("Atenção", "Informe o número.", "error");
                $("#numero").focus();
                return;
        }
        
        if ((complemento === 0) || (complemento === "")) {
                smartAlert("Atenção", "Informe o complemento.", "error");
                $("#complemento").focus();
                return;
        }
        
        if ((estado === 0) || (estado === "")) {
                smartAlert("Atenção", "Informe o estado.", "error");
                $("#unidadeFederacao").focus();
                return;
        }
        
        if ((cidade === 0) || (cidade === "")) {
                smartAlert("Atenção", "Informe a cidade.", "error");
                $("#cidade").focus();
                return;
        }
        
        if ((bairro === 0) || (bairro === "")) {
                smartAlert("Atenção", "Informe o bairro.", "error");
                $("#bairro").focus();
                return;
        }
         
             gravaEmpreendimento(id, nome, inscricaoMunicipal, engenheiroResponsavel,
             incorporador, observacao, cep, tipoLogradouro, logradouro, numero, complemento,
             estado, cidade, bairro
            );
         
    }  
   
    //Função que permite digitar apenas letras em um campo html 
    function apenasLetras(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäöëïüãõçÇãõáÁàÀéÉèÈíÍìÌóÓòÒúÚùÙ ]/i);
    return pattern.test(value);
    }
    
</script>
    