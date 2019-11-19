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

function recuperaEmpreendimento(id) {
    $.ajax({
        url: 'js/sqlscopeEmpreendimento.php', //caminho do arquivo a ser executado
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
                piece = out.split("^");
                
                //Atributos de Empreendimento
                var codigo = +piece[0];
                var nome = piece[1];
                var inscricaoMunicipal = piece[2];
                var engenheiroResponsavel = piece[3];
                var incorporador = +piece[4];
                var observacao = piece[5];
                var cep = piece[6];
                var tipoLogradouro = piece[7];
                var logradouro = piece[8];
                var numero = +piece[9];
                var complemento = piece[10];
                var estado = piece[11];
                var cidade = piece[12];
                var bairro = piece[13];
                var qtdBlocos = piece[14];
                var qtdUnidades = piece[15];
                var qtdVinculadas = piece[16];
                
                //Atributos de Empreendimento
                $("#codigo").val(codigo);
                $("#nomeEmprendi").val(nome);
                $("#insMunicipal").val(inscricaoMunicipal);
                $("#engResponsavel").val(engenheiroResponsavel);
                $("#incorGestor").val(incorporador);
                $("#observacao").val(observacao);
                $("#cep").val(cep);
                $("#tipoLogradouro").val(tipoLogradouro);
                $("#logradouro").val(logradouro);
                $("#numero").val(numero);
                $("#complemento").val(complemento);
                $("#unidadeFederacao").val(estado);
                $("#cidade").val(cidade);
                $("#bairro").val(bairro);
                $("#blocos").val(qtdBlocos);
                $("#unidade").val(qtdUnidades);
                $("#vinculadas").val(qtdVinculadas);
                 
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