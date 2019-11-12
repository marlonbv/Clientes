<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Razão Social</th>
                    <th class="text-left" style="min-width:30px;">CNPJ/CPF</th> 
                    <th class="text-left" style="min-width:30px;">Contato</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                
                $incorporadorFiltro = $_GET['incorporadorFiltro']; 
                $where = "WHERE (0 = 0)";

                //Pega todas as variáveis do banco
                $sql = " SELECT * from dbo.incorporador I ";
 
                //Se o incorporadorFiltro não for nulo
                if ($incorporadorFiltro != "") {
                    $where = $where . " AND  I.codigo like $incorporadorFiltro ";
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
                    $razaoSocial = mb_convert_encoding($row['razaoSocial'],'UTF-8','HTML-ENTITIES');
                    $cnpjCpf = mb_convert_encoding($row['cnpjCpf'],'UTF-8','HTML-ENTITIES');
                    $contato = mb_convert_encoding($row['contato'],'UTF-8','HTML-ENTITIES');

                    echo '<tr >';
                    echo '<td class="text-left"><a href="incorporadorCadastro.php?codigo=' . $id . '">' . $razaoSocial . '</a></td>';
                    echo '<td class="text-left">'. $cnpjCpf.'</td>';
                    echo '<td class="text-left">'. $contato.'</td>';
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
