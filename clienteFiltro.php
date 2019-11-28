<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CLIENTE_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CLIENTE_GRAVAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
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
include "gir_script.js";

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

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/clienteCadastro.php" style="float:right"></a>
                <?php } ?>    
            </div>                    

            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Cliente</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formClienteFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-5">
                                                                <label class="label" for="nome">Nome</label>
                                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                                    <input id="nome" maxlength="50" name="nome" type="text" value="" autocomplete="off">
                                                                </label>
                                                            </section> 
                                                            <section class="col col-3">
                                                                <label class="label">Data de admissão inicial</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dtAdInicial"  name="dtAdInicial" type="text" data-dateformat="dd/mm/yy" class="datepicker text-center" value="" data-mask="99/99/9999" data-mask-placeholder= "-">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data de admissão Final</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dtAdFinal"  name="dtAdFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker text-center" value="" data-mask="99/99/9999" data-mask-placeholder= "-">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">&nbsp;</label>
                                                                <button id="btnSearch" name= "btnSearch" type="button" class="btn btn-primary" title="Buscar">
                                                                    <i class="fa fa-search fa-lg"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="resultadoBusca"></div>
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
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/inputmask/jquery.inputmask.js"></script>  
<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $(document).ready(function () {
        $('#btnSearch').on("click", function () {
            listarFiltro();
        });

        //Faz com que o calendário fique em português.
        $.datepicker.setDefaults($.datepicker.regional[ "pt-BR" ]);

    });

    //Permite apenas letras
    $('#nome').bind('keypress', validaCampoApenasLetras);

    $("#dtAdInicial").on("change", function () {

        // Verificação de todas as datas
        var valor = $("#dtAdInicial").val();
        var validacao = validaData(valor);

        if (validacao === false) {
            $("#dtAdInicial").val("");
        }

        //Verificar se AdInicial > AdFinal
        valor = formataData(valor);
        var valorFinal = $("#dtAdFinal").val();
        valorFinal = formataData(valorFinal);

        if (valor > valorFinal) {
            smartAlert("Erro", "A data de admissão inicial não pode ser maior do que a final!", "error");
            $("#dtAdInicial").val("");

        }

    });


    // Ao clicar fora do campo data de admissão final, faça....    
    $("#dtAdFinal").on("change", function () {
        // Verificação de todas as datas
        var valor = $("#dtAdFinal").val();
        var validacao = validaData(valor);

        //Se a verificação for falsa, limpe o campo
        if (validacao === false) {
            $("#dtAdFinal").val("");
        }

        //Verificar se AdInicial > AdFinal
        valor = formataData(valor);
        var valorInicial = $("#dtAdInicial").val();
        valorInicial = formataData(valorInicial);

        if (valorInicial > valor) {
            smartAlert("Erro", "A data de admissão inicial não pode ser maior do que a final!", "error");
            $("#dtAdInicial").val("");

        }

    });


    function listarFiltro() {
        var nomeFiltro = $('#nome').val();
        var dtAdInicial = $('#dtAdInicial').val();
        var dtAdFinal = $('#dtAdFinal').val();

        if (nomeFiltro !== "") {
            nomeFiltro = nomeFiltro.replace(/^\s+|\s+$/g, "");
            nomeFiltro = encodeURIComponent(nomeFiltro);
        }

        var parametrosUrl = '&nomeFiltro=' + nomeFiltro + '&dtAdInicial=' + dtAdInicial + '&dtAdFinal=' + dtAdFinal;
        $('#resultadoBusca').load('clienteFiltroListagem.php?' + parametrosUrl);
    }

    //Função que valida todas as datas
    function validaData(valor) {
        var date = valor;
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            return false;
        }
        return true;
    }


    }

</script>    


//<?php
//	//include footer
//	include("inc/google-analytics.php"); 
//
?>



