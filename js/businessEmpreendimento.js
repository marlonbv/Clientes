function gravaEmpreendimento(id, nome, inscricaoMunicipal, engenheiroResponsavel,incorporador, observacao, cep, tipoLogradouro, logradouro, numero, complemento,estado, cidade, bairro) {
    $.ajax({
        url: 'js/sqlscopeEmpreendimento.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, nome:nome, inscricaoMunicipal:inscricaoMunicipal, engenheiroResponsavel:engenheiroResponsavel,
            incorporador:incorporador, observacao:observacao, cep:cep, tipoLogradouro:tipoLogradouro, logradouro:logradouro, numero:numero,
            complemento:complemento, estado:estado, cidade:cidade, bairro:bairro}, //valores enviados ao script     
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

function recuperaSexo(id) {
    $.ajax({
        url: 'js/sqlscopeSexo.php', //caminho do arquivo a ser executado
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

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];
                //recupera telefone


                piece = out.split("^");
                //Atributos de sexo 
                var codigo = +piece[0];
                var descricao = piece[1];
                
                //Atributos de sexo        
                $("#codigo").val(codigo);
                $("#descricao").val(descricao);
        
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function recuperaCep(cep) {
    $.ajax({
        url: 'js/sqlscope.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaCep', cep: cep}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
               if (textStatus !== 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                var out = piece[1];
                piece = out.split("^");
                var tipoLogradouro = piece[0].trim();
                var logradouro = piece[1].trim(); 
                var bairro = piece[2].trim();
                var cidade = piece[3].trim();
                var uf = piece[4].trim();

                $("#tipoLogradouro").val(tipoLogradouro);
                $("#logradouro").val(logradouro);
                $("#bairro").val(bairro);
                $("#cidade").val(cidade);
                $("#unidadeFederacao").val(uf);


                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

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
        url: 'js/sqlscopeSexo.php', //caminho do arquivo a ser executado
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

function excluirSexo(id) {
    $.ajax({
        url: 'js/sqlscopeSexo.php', //caminho do arquivo a ser executado
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