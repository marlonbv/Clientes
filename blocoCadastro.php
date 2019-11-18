<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('BLOCO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('BLOCO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('BLOCO_EXCLUIR', $arrayPermissao, true));

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
include "gir_script.js";

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["bloco"]["active"] = true;

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
                            <h2>Bloco</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formBloco" method="post" autocomplete="off" />    
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro do bloco 
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row"> 
                                                            <input id="codigo" name="codigo" type="hidden"> 
                                                            <section class="col col-9">
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

                                                            <section class="col col-3">
                                                                <label class="label">Unidades</label>
                                                                <label class="input">
                                                                    <input  type="text" id="unidade" name="unidade" class="readonly" readonly/>
                                                                </label>       
                                                            </section> 
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <section class="col col-9">
                                                                <label class="label">Nome do bloco</label>
                                                                <label class="input">
                                                                    <input  type="text" id="nome" name="nome" class="required" required/>
                                                                </label>       
                                                            </section>  

                                                            <section class="col col-3">
                                                                <label class="label">Vinculadas</label>
                                                                <label class="input">
                                                                    <input  type="text" id="vinculadas" name="vinculadas" class="readonly" readonly/>
                                                                </label>       
                                                            </section> 
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Natureza</label>
                                                                <label class="select">
                                                                    <select id="natureza" name="natureza" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "natureza";

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
                                                                <label class="label">Estágio da Obra</label>
                                                                <label class="select">
                                                                    <select id="estagioObra" name="estagioObra" class="required" required> 
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $tabela = "estagioObra";

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
                                                        </div>
                                                        <div class="row">
                                                        <section class="col col-3">
                                                                <label class="label">Início da construção</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataInicioConstrucao"  name="dataInicioConstrucao" type="text" class="datepicker required" required>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Entrega das chaves</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataEntregaChaves"  name="dataEntregaChaves" type="text" data-dateformat="dd/mm/yy" class="datepicker required" required>
                                                                </label>
                                                            </section>

                                                            <section class="col col-6">
                                                                <label class="label">Observação</label>
                                                                <label class="input">
                                                                    <input id="observacao" name="observacao" type="text">
                                                                </label>
                                                            </section> 
                                                        </div>
                                                        <div class="row"> 
                                                            <fieldset id="formTipologia">
                                                                
                                                                <input id="JsonTipologia" name="JsonTipologia" type="hidden" value="[]">
                                                                <input id="tipologiaId" name="tipologiaId" type="hidden" value="">
                                                                <input id="sequencialTipologia" name="sequencialTipologia" type="hidden" value="">
                                                                <input id="descricaoTipologia" name="descricaoTipologia" type="hidden" value=""> 
                                                                <div class="form-group">

                                                                    <div class="row">
                                                                        <section class="col col-6"> 
                                                                            <label class="label">Tipologia:</label>
                                                                            <select id="tipologia" name="tipologia" class="form-control">
                                                                                <option></option>
                                                                                <?php
                                                                                //include "js/repositorio.php";        
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
                                                                        </section>     
                                                                        <section class="col col-md-4">
                                                                            <label class="label"> </label>
                                                                            <button id="btnAddTipologia" type="button" class="btn btn-primary">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                            <button id="btnRemoverTipologia" type="button" class="btn btn-danger">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </section> 
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableTipologia" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 100%;">Tipologia</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>


                                                            </fieldset> 
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

<script src="<?php echo ASSETS_URL; ?>/js/businessBloco.js" type="text/javascript"></script>

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
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    jsonTipologiaArray = JSON.parse($("#JsonTipologia").val());

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

        //Deixa o menu de escolha das datas em português.
        $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );     
        
        //Máscara das datas 
        $("input[id*='dataInicioConstrucao']").inputmask({
        mask: ['99/99/9999'],
        placeholder: "X",
        keepStatic: true
        });
        
        $("input[id*='dataEntregaChaves']").inputmask({
        mask: ['99/99/9999'],
        placeholder: "X",
        keepStatic: true
        });
        
        $('#formBloco').validate({
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

        //Ao alterar a data de inicio da construção, faça...
        $("#dataInicioConstrucao").on("change", function () {

            // Verificação de todas as datas
            var valor = $("#dataInicioConstrucao").val();
            var validacao = validaData(valor);

            if(validacao === false){   
             $("#dataInicioConstrucao").val("");
            }
            
            //Verifica se a dataInicioConstrucao > dataEntregaChaves
            valor = formataData(valor); 
            var entregaChaves = $("#dataEntregaChaves").val();
            entregaChaves = formataData(entregaChaves);
        
            if(valor > entregaChaves){
               smartAlert("Erro", "A data de início da construção não pode ser maior do que a data da entrega das chaves!", "error");
                $("#dataInicioConstrucao").val("");  
            }        
         
        }); 

        //Ao alterar a data da entrega das chaves, faça...
        $("#dataEntregaChaves").on("change", function () {

            // Verificação de todas as datas
            var valor = $("#dataEntregaChaves").val();
            var validacao = validaData(valor);

            if(validacao === false){ 
             $("#dataEntregaChaves").val("");
            }
            
            //Verifica se a dataInicioConstrucao > dataEntregaChaves
            valor = formataData(valor); 
            var dataInicioConstrucao = $("#dataInicioConstrucao").val();
            dataInicioConstrucao = formataData(dataInicioConstrucao);
        
            if(valor < dataInicioConstrucao){
               smartAlert("Erro", "A data de início da construção não pode ser maior do que a data da entrega das chaves!", "error");
                $("#dataInicioConstrucao").val("");  
            }        
         
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
                recuperaBloco(idd);
            }
        }
        $("#nome").focus();
    }

    function novo() {
        $(location).attr('href', 'blocoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'blocoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirBloco(id);
    }
    
    function validaTipologia(){
        var existe = false; 
        var tipologia = $('#tipologia').val();
        var sequencial = +$('#sequencialTipologia').val();
        
        if (tipologia === '') {
            smartAlert("Erro", "Informe a tipologia.", "error");
            return false;
        }
        
        for (i = jsonTipologiaArray.length - 1; i >= 0; i--) {
            
            if ((jsonTipologiaArray[i].tipologia === tipologia) && (jsonTipologiaArray[i].sequencialTipologia !== sequencial)) {
                existe = true;
                break;
            }
            
        }
        
        if (existe === true) {
            smartAlert("Erro", "A tipologia já foi cadastrada.", "error");
            return false;
        }
        
        return true;
    }
    
    function processDataTipologia(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoTipologia")) {
            return {name: fieldName, value: $("#tipologia option:selected").text()};
        }

        return false;
    }

    function gravar() {
        var id = +($("#codigo").val());
        var empreendimento = $("#empreendimento").val();
        var nome = $("#nome").val();
        var natureza = $("#natureza").val();
        var estagioObra = $("#estagioObra").val();
        var dataInicioConstrucao = $("#dataInicioConstrucao").val();
        var dataEntregaChaves = $("#dataEntregaChaves").val();
        var observacao = $("#observacao").val();

        if ((empreendimento === 0) || (empreendimento === "")) {

            smartAlert("Atenção", "Informe o bloco.", "error");
            $("#empreendimento").focus();
            return;
        } else {
            gravaBloco(id, empreendimento, nome, natureza, estagioObra, dataInicioConstrucao, dataEntregaChaves, observacao);
        }
    }
    
    //Ações dos botões de Tipologia
        $('#btnAddTipologia').on("click", function () {
            if (validaTipologia() === true){
            addTipologia();
            }
        });

        $('#btnRemoverTipologia').on("click", function () {
            excluirTipologia();
        });

    // '+' de Tipologia
    function addTipologia() {
        var item = $("#formTipologia").toObject({mode: 'combine', skipEmpty: false, nodeCallback: processDataTipologia});

        if (item["sequencialTipologia"] === '') {
            if (jsonTipologiaArray.length === 0) {
                item["sequencialTipologia"] = 1;
            } else {
                item["sequencialTipologia"] = Math.max.apply(Math, jsonTipologiaArray.map(function (o) {
                    return o.sequencialTipologia;
                })) + 1;
            }
            item["tipologiaId"] = 0;
        } else {
            item["sequencialTipologia"] = +item["sequencialTipologia"];
        }

        var index = -1;
        $.each(jsonTipologiaArray, function (i, obj) {
            if (+$('#sequencialTipologia').val() === obj.sequencialTipologia) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTipologiaArray.splice(index, 1, item);
        else
            jsonTipologiaArray.push(item);

        $("#jsonTipologia").val(JSON.stringify(jsonTipologiaArray));
        fillTableTipologia();
        clearFormTipologia();
    }
    
    function excluirTipologia() {
        var arrSequencial = [];
        $('#tableTipologia input[type=checkbox]:checked').each(function () {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonTipologiaArray.length - 1; i >= 0; i--) {
                var obj = jsonTipologiaArray[i];
                if (jQuery.inArray(obj.sequencialTipologia, arrSequencial) > -1) {
                    jsonTipologiaArray.splice(i, 1);
                }
            }

            $("#jsonTipologia").val(JSON.stringify(jsonTipologiaArray));
            fillTableTipologia();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 endereço para excluir.", "error");
    }

    function clearFormTipologia() {
        $("tipologiaId").val('');
        $("#tipologia").val('');
        $("#sequencialTipologia").val('');
        $("#descricaoTipologia").val('');
    }

    function carregaTipologia(sequencialTipologia) {
        var arr = jQuery.grep(jsonTipologiaArray, function (item, i) {
            return (item.sequencialTipologia === sequencialTipologia);
        });

        clearFormTipologia();

        if (arr.length > 0) {
            var item = arr[0];
            $("tipologiaId").val(item.tipologiaId);
            $("#tipologia").val(item.tipologia);
            $("#sequencialTipologia").val(item.sequencialTipologia);
            $("#descricaoTipologia").val(item.descricaoTipologia);
        }

    }

    //Função que permite digitar apenas letras em um campo html 
    function apenasLetras(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäöëïüãõçÇãõáÁàÀéÉèÈíÍìÌóÓòÒúÚùÙ ]/i);
        return pattern.test(value);
    }

    function fillTableTipologia() {

        $("#tableTipologia tbody").empty();
        for (var i = 0; i < jsonTipologiaArray.length; i++) {
            var row = $('<tr/>');
            $("#tableTipologia tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTipologiaArray[i].sequencialTipologia + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTipologia(' + jsonTipologiaArray[i].sequencialTipologia + ');">' + jsonTipologiaArray[i].descricaoTipologia + '</td>'));

        }
    }
     

</script>
