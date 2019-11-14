<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('UNIDADE_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('UNIDADE_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('UNIDADE_EXCLUIR', $arrayPermissao, true));

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
$page_nav["cadastro"]["sub"]["unidade"]["active"] = true;

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
                            <h2>Unidade</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding"> 
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUnidade" method="post">    
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro de unidades
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row"> 
                                                            <input id="codigo" name="codigo" type="hidden"> 
                                                            <section class="col col-10">
                                                                <label class="label">Empreendimento</label>
                                                                <label class="select">
                                                                    <select id="empreendimento" name="empreendimento" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "empreendimento";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['codigo'];
                                                                            $nome = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label> 
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class="label">Vinculadas</label>
                                                                <label class="input">
                                                                    <input  type="text" id="vinculadas" name="vinculadas" class="required" required/>
                                                                </label>       
                                                            </section> 

                                                            <section class="col col-8">
                                                                <label class="label">Bloco</label>
                                                                <label class="select">
                                                                    <select id="bloco" name="bloco" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "bloco";

                                                                        $result = $reposit->SelectAll($tabela . "|" . "");

                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = $row['codigo'];
                                                                            $nome = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>    
                                                                </label>
                                                            </section>  

                                                            <section class="col col-4">
                                                                <label class="label">Matrícula</label>
                                                                <label class="input">
                                                                    <input  type="text" id="matricula" name="matricula" class="required" required/>
                                                                </label>       
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class="label">Unidade</label>
                                                                <label class="input">
                                                                    <input  type="text" id="unidade" name="unidade" class="required" required/>
                                                                </label>       
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class="label">Andar</label>
                                                                <label class="input">
                                                                    <input  type="text" id="andar" name="andar" class="required" required/>
                                                                </label>       
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class="label">Coluna</label>
                                                                <label class="input">
                                                                    <input  type="text" id="coluna" name="coluna" class="required" required/>
                                                                </label>       
                                                            </section> 

                                                            <section class="col col-6">
                                                                <label class="label">Tipologia</label>
                                                                <label class="select">
                                                                    <select id="tipologia" name="tipologia" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "tipologia";

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

                                                            <section class="col col-6">
                                                                <label class="label">Posição Relativa do Sol </label>
                                                                <label class="select">
                                                                    <select id="posicaoSol" name="posicaoSol" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "posicaoSol";

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

                                                            <section class="col col-6">
                                                                <label class="label">Vista da Unidade </label>
                                                                <label class="select">
                                                                    <select id="vistaUnidade" name="vistaUnidade" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "vistaUnidade";

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

                                                            <section class="col col-12">
                                                                <label class="label">Inscrição Predial</label>
                                                                <label class="input">
                                                                    <input id="inscricaoPredial" name="inscricaoPredial" type="text">
                                                                </label>
                                                            </section> 
                                                        </div>  
                                                    </fieldset> 
                                                </div>                                                        
                                            </div>  

                                        </div>
                                        <!-- Accordion do Quadro de Áreas --> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseQuadroAreas" class="collapsed" id="accordionQuadroAreas">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Áreas
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseQuadroAreas" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">      
                                                    <fieldset id="formQuadroAreas"> 
                                                        <input id="JsonQuadroAreas" name="JsonQuadroAreas" type="hidden" value="[]">
                                                        <input id="quadroAreasId" name="quadroAreasId" type="hidden" value="">
                                                        <input id="sequencialQuadroAreas" name="sequencialQuadroAreas" type="hidden" value=""> 
                                                        <input id="descricaoQuadroAreas" name="descricaoQuadroAreas" type="hidden" value="">                          

                                                        <div class="row"> 

                                                            <section class="col col-4">
                                                                <label class="label">Quadro de Áreas </label>
                                                                <label class="select">
                                                                    <select id="quadroAreas" name="quadroAreas"> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "quadroAreas";

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

                                                            <section class="col col-4">
                                                                <label class="label">Tamanho em metros quadrados</label>
                                                                <label class="input">
                                                                    <input id="tipoLogradouro"  name="tamanho"  type="text" value="">
                                                                </label>
                                                            </section>

                                                            <!-- Aparencia dos botões -->
                                                            <section class="col col-md-4">
                                                                <label class="label"> </label>
                                                                <button id="btnAddQuadroAreas" type="button" class="btn btn-primary">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverQuadroAreas" type="button" class="btn btn-danger">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>

                                                        </div>

                                                        <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableQuadroAreas" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 100%;">Área</th>
                                                                        <th class="text-left" style="min-width: 100%;">Metragem </th>

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

                                        <!-- Fim do accordion -->

                                        <!-- Accordion da Área Privada --> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="collapsed" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Área Privativa
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset> 
                                                        <div id="form" class="col-sm-6"> 
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-6">
                                                                        <label class="label">Área Util</label>
                                                                        <label class="input">
                                                                            <input id="areaUtil"  name="areaUtil"  type="text" value="">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-6">
                                                                        <label class="label">Área Privativa</label>
                                                                        <label class="input">
                                                                            <input id="areaPrivada"  name="areaPrivada"  type="text" value="">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-6">
                                                                        <label class="label">Área Comum</label>
                                                                        <label class="input">
                                                                            <input id="areaComum"  name="areaComum" maxlength="50" type="text" value="">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-6">
                                                                        <label class="label">Área Total</label>
                                                                        <label class="input">
                                                                            <input id="areaTotal"  name="areaTotal" maxlength="30" type="text" value="">
                                                                        </label>
                                                                    </section> 
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>                                                    
                                        </div>
                                    <footer>
                                        <!-- Ações dos botões -->
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
                                        <button type="submit" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php
                                        echo $esconderBtnGravar 
                                                ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/businessUnidade.js" type="text/javascript"></script>

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
    jsonQuadroAreasArray = JSON.parse($("#JsonQuadroAreas").val());
    
    $(document).ready(function () {
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#formUnidade').validate({
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
                $("#descricao").focus();
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

        $("#descricao").on("change", function () {
            var idd = $("#descricao").val();
            recuperaDescricao(idd);

        });

        $('#descricao').bind('keypress', apenasLetras);
        //Ações dos botões do Quadro de Áreas Sociais
        $('#btnAddQuadroAreas').on("click", function () {
            addQuadroAreas();
        });

        $('#btnRemoverQuadroAreas').on("click", function () {
            excluirQuadroAreas();
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
                recuperaUnidade(idd);
            }
        }
        $("#nome").focus();
    }

    //****************************************************QUADRO DE ÁREAS LISTA INICIO*****************************************
    function carregaQuadroAreas(sequencialQuadroAreas) {
        var arr = jQuery.grep(jsonQuadroAreasArray, function (item, i) {
            return (item.sequencialQuadroAreas === sequencialQuadroAreas);
        });

        clearFormQuadroAreas();

        if (arr.length > 0) {
            var item = arr[0];
            $("quadroAreasId").val(item.quadroAreasId);
            $("#quadroAreas").val(item.quadroAreas);
            $("#sequencialQuadroAreas").val(item.sequencialQuadroAreas);
            $("#descricaoQuadroAreas").val(item.descricaoQuadroAreas);
        }

    }


    function clearFormQuadroAreas() {
        $("#quadroAreasId").val('');
        $("#quadroAreas").val('');
        $("#descricaoQuadroAreas").val('');
        $("#sequencialQuadroAreas").val('');
    }

    function addQuadroAreas() {
        var item = $("#formQuadroAreas").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processDataQuadroAreas});

        if (item["sequencialQuadroAreas"] === '') {
            if (jsonQuadroAreasArray.length === 0) {
                item["sequencialQuadroAreas"] = 1;
            } else {
                item["sequencialQuadroAreas"] = Math.max.apply(Math, jsonQuadroAreasArray.map(function (o) {
                    return o.sequencialQuadroAreas;
                })) + 1;
            }
            item["quadroAreasId"] = 0;
        } else {
            item["sequencialQuadroAreas"] = +item["sequencialQuadroAreas"];
        }

        var index = -1;
        $.each(jsonQuadroAreasArray, function (i, obj) {
            if (+$('#sequencialQuadroAreas').val() === obj.sequencialQuadroAreas) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonQuadroAreasArray.splice(index, 1, item);
        else
            jsonQuadroAreasArray.push(item);

        $("#JsonQuadroAreas").val(JSON.stringify(jsonQuadroAreasArray));
        fillTableQuadroAreas();
        clearFormQuadroAreas();
    }

    function excluirQuadroAreas() {
        var arrSequencial = [];
        $('#tableQuadroAreas input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonQuadroAreasArray.length - 1; i >= 0; i--) {
                var obj = jsonQuadroAreasArray[i];
                if (jQuery.inArray(obj.sequencialQuadroAreas, arrSequencial) > -1) {
                    jsonQuadroAreasArray.splice(i, 1);
                }
            }

            $("#JsonQuadroAreas").val(JSON.stringify(jsonQuadroAreasArray));
            fillTableQuadroAreas();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 quadro para excluir.", "error");
    }

    function fillTableQuadroAreas() {

        $("#tableQuadroAreas tbody").empty();
        for (var i = 0; i < jsonQuadroAreasArray.length; i++) {
            var row = $('<tr/>');
            $("#tableQuadroAreas tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonQuadroAreasArray[i].sequencialQuadroAreas + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaQuadroAreas(' + jsonQuadroAreasArray[i].sequencialQuadroAreas + ');">' + jsonQuadroAreasArray[i].descricaoQuadroAreas + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonQuadroAreasArray[i].tamanhoQuadrados + '</td>'));
        }
    }

    function processDataQuadroAreas(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoQuadroAreas")) {
            return {name: fieldName, value: $("#quadroAreas option:selected").text()};
        }

        return false;
    }

//****************************************************REDE SOCIAL LISTA FIM*****************************************

    function novo() {
        $(location).attr('href', 'unidadeCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'unidadeFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirUnidade(id);
    }

    function gravar() {
        var id = +($("#codigo").val());
        var empreendimento = $("#empreendimento").val();
        var bloco = $("#bloco").val();
        var vinculadas = $("#vinculadas").val();
        var matricula = $("#matricula").val();
        var unidade = $("#unidade").val();
        var andar = $("#andar").val();
        var coluna = $("#coluna").val();
        var tipologia = $("#tipologia").val();
        var posicaoSol = $("#posicaoSol").val();
        var vistaUnidade = $("#vistaUnidade").val();
        var inscricaoPredial = $("#inscricaoPredial").val();
        var jsonQuadroAreasArray = $("#JsonQuadroAreas").val();
        var areaUtil = $("#areaUtil").val();
        var areaPrivada = $("#areaPrivada").val();
        var areaComum = $("#areaComum").val();
        var areaTotal = $("#areaTotal").val();
 
        gravaUnidade(id, empreendimento, bloco, vinculadas, matricula, unidade, andar, coluna, tipologia, posicaoSol, vistaUnidade,
        inscricaoPredial, jsonQuadroAreasArray, areaUtil, areaPrivada, areaComum, areaTotal );
        
    }

    //Função que permite digitar apenas letras em um campo html 
    function apenasLetras(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäöëïüãõçÇãõáÁàÀéÉèÈíÍìÌóÓòÒúÚùÙ ]/i);
        return pattern.test(value);
    }

</script>
