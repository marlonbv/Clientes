function gravaBloco(id, empreendimento,nome,natureza,estagioObra,dataInicioConstrucao,dataEntregaChaves,
observacao, jsonTipologia) {
    $.ajax({
        url: 'js/sqlscopeBloco.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id: id, empreendimento: empreendimento,nome:nome,
        natureza:natureza,estagioObra:estagioObra,dataInicioConstrucao:dataInicioConstrucao,dataEntregaChaves:dataEntregaChaves,
        observacao:observacao, jsonTipologia:jsonTipologia}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }

                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function recuperaBloco(id) {
    $.ajax({
        url: 'js/sqlscopeBloco.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                return;
            } else {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");
 
                var mensagem = piece[0];
                var out = piece[1];  
                var strArrayTipologia = piece[8];
                piece = out.split("^");
                //Atributos de bloco 
                var codigo = +piece[0];
                var empreendimento = piece[1];
                var nome = piece[2];
                var natureza = piece[3];
                var estagioObra = piece[4];
                var dataInicioConstrucao = piece[5];
                var dataEntregaChaves = piece[6];
                var observacao = piece[7];
                var unidades = piece[8];
                var vinculadas = piece[9];
                
                //Atributos de bloco        
                $("#codigo").val(codigo);
                $("#empreendimento").val(empreendimento);
                $("#nome").val(nome);
                $("#natureza").val(natureza);
                $("#estagioObra").val(estagioObra);
                $("#dataInicioConstrucao").val(dataInicioConstrucao);
                $("#dataEntregaChaves").val(dataEntregaChaves);
                $("#observacao").val(observacao);
                $("#unidade").val(unidades);
                $("#vinculadas").val(vinculadas);
                $("#JsonTipologia").val(strArrayTipologia);
                
                fillTableTipologia();
        
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function recuperaDescricao(id) {
    $.ajax({
        url: 'js/sqlscopeBloco.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaDescricao', id: id}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                return;
            } else {
                data = data.replace(/failed/g, '');
                
                if(data !== "" ){
                smartAlert("Atenção", "A descricao já foi registrada.", "error"); 
                $("#descricao").val("");
                }
                
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirBloco(id) {
    $.ajax({
        url: 'js/sqlscopeBloco.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                novo();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}