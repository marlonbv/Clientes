<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Nome</th>
                    <th class="text-left" style="min-width:35px;">Cpf</th>
                    <th class="text-left" style="min-width:35px;">Data de Nascimento</th>
                    <th class="text-left" style="min-width:35px;">Sexo</th>
                    <th class="text-left" style="min-width:35px;">Email</th>
                    <th class="text-left" style="min-width:35px;">Data de Admissão</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomeFiltro = $_GET['nomeFiltro'];
                $dtAdInicial = $_GET['dtAdInicial'];

                //Pega todas as variáveis do banco
                $sql = " SELECT CLI.nome,CLI.cpf ,CLI.dtNasc, S.sexo, CE.email ,CLI.dtAdInicial, CLI.situacao,"
                     . " FROM dbo.cliente CLI JOIN dbo.sexo AS S ON CLI.sexo JOIN dbo.clienteEmail AS CE = S.codigo ";
                 $where = "WHERE (0 = 0)";


                if ($dtAdInicial != "") {
                    $where = $where . " AND CLI.dtAdInicial >= $dtAdInicial";
                }
                if ($dtAdFinal != "") {
                    $where = $where . " AND CLI.dtAdFinal <= $dtAdFinal";
                }
                //Se o nomeFiltro não for nulo
                if ($nomeFiltro != "") {
                    $where = $where . " AND (CLI.nome like '%' + " . "replace('" . $nomeFiltro . "',' ','%') + " . "'%')";
                }

                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);
                $row = odbc_num_rows($result);
                
                if(($row == 0) || ($row == 'false')){
                    echo "Erro de SQL!"; 
                }

                while (($row = odbc_fetch_array($result))) {
                    $nome = mb_convert_encoding($row['nome'],'UTF-8','HTML-ENTITIES');
                    $cpf = +$row['cpf'];
                    $dtNasc = $row['dtNasc'];
                    $sexo = mb_convert_encoding($row['descricao'],'UTF-8','HTML-ENTITIES');
                    $email = mb_convert_encoding($row['email'],'UTF-8','HTML-ENTITIES');
                    $situacao = +$row['situacao'];
                    
                    if(($dtNasc != null) ||($dtNasc != "")){
                    
                    $dtNasc = date("d-m-Y", strtotime($dtNasc));
                    $dtNasc = str_replace('-', '/', $dtNasc); 
                    
                    }
                    else {
                          $dtNasc = "Nascimento não registrado";
                    }
                    
                    $dtAdInicial = $row['dtAdInicial']; 
                    
                    if(($dtAdInicial != null) ||($dtAdInicial != "")){
                    
                    $dtAdInicial = date("d-m-Y", strtotime($dtAdInicial));
                    $dtAdInicial = str_replace('-', '/', $dtAdInicial); 
                    
                    }
                    else {
                          $dtAdInicial = "Data da admissão inicial não registrada";
                    }
                    
                    
                    $dtAdFinal = $row['dtAdFinal'];
                    
                    if(($dtAdFinal != null) ||($dtAdFinal != "")){
                    
                    $dtAdFinal = date("d-m-Y", strtotime($dtAdFinal));
                    $dtAdFinal = str_replace('-', '/', $dtAdFinal); 
                    
                    }
                    else {
                          $dtAdFinal = "Data do final da admissão não registrada";
                    }
                    

                    // $login = mb_convert_encoding($row['login'], 'UTF-8', 'HTML-ENTITIES');

                    $descricaoAtivo = "";
                    if ($situacao == 1) {
                        $descricaoAtivo = "Sim";
                    } else {
                        $descricaoAtivo = "Não";
                    }
                     

                    echo '<tr >';
                    echo '<td class="text-left"><a href="clienteCadastro.php?codigo=' . $id . '">' . $nome . '</a></td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $dtNasc . '</td>';
                    echo '<td class="text-left">' . $sexo . '</td>';
                    echo '<td class="text-left">' . $email . '</td>';
                    echo '<td class="text-left">' . $dtAdInicial . '</td>';
                    echo '<td class="text-left">' . $situacao . '</td>';
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
