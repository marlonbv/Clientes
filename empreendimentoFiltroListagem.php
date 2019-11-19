<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Empreendimento</th>
                    <th class="text-left" style="min-width:30px;">Incorporador Gestor</th>
                    <th class="text-left" style="min-width:30px;">Blocos</th>
                    <th class="text-left" style="min-width:30px;">Unidades</th> 
                    <th class="text-left" style="min-width:30px;">Vagas Vinculadas</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                
                $empreendimentoFiltro = $_GET['empreendimentoFiltro']; 
                $where = "WHERE (0 = 0)";

                //Pega todas as variáveis do banco
                $sql = "SELECT E.nome, E.codigo, I.razaoSocial AS incorporador,
                        (SELECT COUNT(*) FROM dbo.bloco B
                        WHERE B.empreendimento = E.codigo
                        )AS qtdBlocos, 
                        (SELECT COUNT(*) FROM dbo.unidade U
                        WHERE U.empreendimento = E.codigo)
                        AS qtdUnidades,
                        (SELECT SUM(U.vinculadas) FROM dbo.unidade U
                        WHERE U.empreendimento = E.codigo) 
                        AS qtdVinculadas
                        FROM dbo.empreendimento E
                        INNER JOIN dbo.incorporador I ON E.incorporador = I.codigo ";
 
                //Se o empreendimentoFiltro não for nulo
                if ($empreendimentoFiltro != "") {
                    $where = $where . " AND  E.codigo like $empreendimentoFiltro ";
                }

                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);
                $row = odbc_num_rows($result);
                if(($row == 0) || ($row == 'false')){
                    echo "Erro de SQL!"; 
                }

                while (($row = odbc_fetch_array($result))) {
                    $id = +$row['codigo'];
                    $nome = mb_convert_encoding($row['nome'],'UTF-8','HTML-ENTITIES');
                    $incorporadorGestor = mb_convert_encoding($row['incorporador'],'UTF-8','HTML-ENTITIES');
                    $blocos = +$row[qtdBlocos]; 
                    $unidades = +$row[qtdUnidades];
                    $vagas = +$row[qtdVinculadas];

                    echo '<tr >';
                    echo '<td class="text-left"><a href="empreendimentoCadastro.php?codigo=' . $id . '">' . $nome . '</a></td>';
                    echo '<td class="text-left">' . $incorporadorGestor . '</td>';
                    echo '<td class="text-left">' . $blocos . '</td>';
                    echo '<td class="text-left">' . $unidades . '</td>';
                    echo '<td class="text-left">' . $vagas . '</td>';
                    echo '</tr >';
                }
                ?>                            
            </tbody>
        </table>        
    </div>    
</div>    
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>
    $(document).ready(function () {

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth": true,
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

    });
</script>
