<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Unidade</th> 
                    <th class="text-left" style="min-width:30px;">Andar</th>
                    <th class="text-left" style="min-width:30px;">Coluna</th> 
                    <th class="text-left" style="min-width:30px;">Tipologia</th> 
                    <th class="text-left" style="min-width:30px;">Vagas Vinculadas</th> 
                    <th class="text-left" style="min-width:30px;">Posicação Relativa do Sol</th> 
                    <th class="text-left" style="min-width:30px;">Vista da Unidade</th> 
                    <th class="text-left" style="min-width:30px;">Área Util</th> 
                    <th class="text-left" style="min-width:30px;">Área Privada</th> 
                    <th class="text-left" style="min-width:30px;">Área Comum</th> 
                    <th class="text-left" style="min-width:30px;">Área Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $unidadeFiltro = $_GET['unidadeFiltro']; 
                $where = "WHERE (0 = 0)";

                //Pega todas as variáveis do banco
                $sql = "SELECT	U.codigo, U.andar, U.coluna, U.vinculadas,
                U.areaUtil, U.areaPrivada, U.areaComum, U.areaTotal,
                T.descricao AS tipologia, P.descricao AS posicaoSol, VU.descricao as vistaUnidade
                FROM dbo.unidade U
                INNER JOIN dbo.bloco B ON B.codigo = U.bloco
                INNER JOIN dbo.tipologia T ON T.codigo = U.tipologia
                INNER JOIN dbo.posicaoSol P ON P.codigo = U.posicaoSol
                INNER JOIN dbo.vistaUnidade VU ON VU.codigo = U.vistaUnidade 
                ";
 
                //Se a unidadeFiltro não for nulo
                if ($unidadeFiltro != "") {
                    $where = $where . " AND U.codigo like $unidadeFiltro ";
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
                    $andar = mb_convert_encoding($row['andar'],'UTF-8','HTML-ENTITIES');
                    $coluna = mb_convert_encoding($row['coluna'],'UTF-8','HTML-ENTITIES');
                    $tipologia = mb_convert_encoding($row['tipologia'],'UTF-8','HTML-ENTITIES');
                    $vinculadas = mb_convert_encoding($row['vinculadas'],'UTF-8','HTML-ENTITIES');
                    $posicaoSol = mb_convert_encoding($row['posicaoSol'],'UTF-8','HTML-ENTITIES');
                    $vistaUnidade = mb_convert_encoding($row['vistaUnidade'],'UTF-8','HTML-ENTITIES');
                    $areaUtil = mb_convert_encoding($row['areaUtil'],'UTF-8','HTML-ENTITIES');
                    $areaPrivada = mb_convert_encoding($row['areaPrivada'],'UTF-8','HTML-ENTITIES');
                    $areaComum = mb_convert_encoding($row['areaComum'],'UTF-8','HTML-ENTITIES');
                    $areaTotal = mb_convert_encoding($row['areaTotal'],'UTF-8','HTML-ENTITIES');
                    
                    echo '<tr >';
                    echo '<td class="text-left"><a href="unidadeCadastro.php?codigo=' . $id . '">' . $id . '</a></td>';
                    echo '<td class="text-left">' . $andar . '</td>';
                    echo '<td class="text-left">' . $coluna . '</td>';
                    echo '<td class="text-left">' . $tipologia . '</td>';
                    echo '<td class="text-left">' . $vinculadas . '</td>';
                    echo '<td class="text-left">' . $posicaoSol . '</td>';
                    echo '<td class="text-left">' . $vistaUnidade . '</td>';
                    echo '<td class="text-left">' . $areaUtil . '</td>';
                    echo '<td class="text-left">' . $areaPrivada . '</td>';
                    echo '<td class="text-left">' . $areaComum . '</td>';
                    echo '<td class="text-left">' . $areaTotal . '</td>';
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
