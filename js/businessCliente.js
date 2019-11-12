function gravaCliente(id, nome, cpf, dtNasc, dtAdInicial, sexo, tipoCliente, estadoCivil, ativo, obs, jsonTels, jsonEmails, jsonEnds, jsonRedesArray) {
    $.ajax({
        url: 'js/sqlscopeCliente.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id: id, nome: nome, cpf: cpf, dtNasc: dtNasc, dtAdInicial: dtAdInicial, sexo: sexo,
            tipoCliente: tipoCliente, estadoCivil:estadoCivil, ativo: ativo, obs: obs, jsonTels: jsonTels, jsonEmails: jsonEmails, jsonEnds: jsonEnds, jsonRedesArray:jsonRedesArray}, //valores enviados ao script     
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



function recuperaCPF(id) {
    $.ajax({
        url: 'js/sqlscopeCliente.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaCPF', id: id}, //valores enviados ao script     
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
                var logradouro = piece[0].trim();
                var bairro = piece[1].trim();
                var cidade = piece[2].trim();
                var uf = piece[3].trim();

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

function recuperaCliente(id) {
    $.ajax({
        url: 'js/sqlscopeCliente.php', //caminho do arquivo a ser executado
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
                var piece = data.split("|");

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];
                //recupera telefone
                var strArrayTelefone = piece[2];
                var strArrayEmail = piece[3];
                var strArrayEndereco = piece[4];
                var strArrayRedeSocial = piece[5];


                piece = out.split("^");
                //Atributos de cliente 
                var codigo = +piece[0];
                var nome = piece[1];
                var cpf = piece[2];
                var sexo = +piece[3];
                var dtNasc = piece[4];
                var dtAdInicial = piece[5];
                var ativo = piece[6];
                var tipoCliente = piece[7];
                var estadoCivil = piece[8];
                var obs = piece[9];


                //Atributos de cliente        
                $("#codigo").val(codigo);
                $("#nome").val(nome);
                $("#cpf").val(cpf);
                $("#sexo").val(sexo);
                $("#dtNasc").val(dtNasc);
                $("#dtAdInicial").val(dtAdInicial);
                $("#ativo").val(ativo);
                $("#tipoCliente").val(tipoCliente);
                $("#estadoCivil").val(estadoCivil);
                $("#obs").val(obs);

                if (ativo === 1) {
                    $('#ativo').prop('checked', true);
                } else {
                    $('#ativo').prop('checked', false);
                }

                $("#JsonTels").val(strArrayTelefone);
                $("#JsonEmails").val(strArrayEmail);
                $("#JsonEnds").val(strArrayEndereco);
                $("#jsonRedes").val(strArrayRedeSocial);
               
                
                jsonTelsArray = JSON.parse($("#JsonTels").val());
                jsonEmailsArray = JSON.parse($("#JsonEmails").val());
                jsonEndsArray = JSON.parse($("#JsonEnds").val());
                jsonRedesArray = JSON.parse($("#jsonRedes").val());
                
                fillTableTels();
                fillTableEmails();
                fillTableEnds();
                fillTableRedes();
                
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirCliente(id) {
    $.ajax({
        url: 'js/sqlscopeCliente.php', //caminho do arquivo a ser executado
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