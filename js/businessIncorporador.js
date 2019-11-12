function gravaIncorporador(id,razaoSocial,tipoPessoa,cnpjCpf,inscMunicipal,inscEstadual,contato,cargo,telefone, cep, tipoLogradouro,logradouro,
numero,complemento,estado,cidade,bairro) {
    $.ajax({
        url: 'js/sqlscopeIncorporador.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id: id, razaoSocial: razaoSocial, tipoPessoa:tipoPessoa,cnpjCpf:cnpjCpf, inscMunicipal:inscMunicipal,
        inscEstadual:inscEstadual,contato:contato,cargo:cargo,telefone:telefone, cep:cep, tipoLogradouro:tipoLogradouro, logradouro:logradouro,numero:numero,
    complemento:complemento,estado:estado,cidade:cidade,bairro:bairro}, //valores enviados ao script     
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

function recuperaIncorporador(id) {
    $.ajax({
        url: 'js/sqlscopeIncorporador.php', //caminho do arquivo a ser executado
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
                
                piece = out.split("^");
                //Atributos de incorporador 
                var codigo = +piece[0];
                var razaoSocial = piece[1];
                var cnpjCpf = piece[2];
                var tipoPessoa = piece[3];
                var inscMunicipal = piece[4];
                var inscEstadual = piece[5];
                var contato = piece[6];
                var cargo = piece[7];
                var telefone = piece[8]; 
                var cep = piece[9];
                var tipoLogradouro = piece[10];
                var logradouro = piece[11];
                var numero = piece[12];
                var complemento = piece[13];
                var estado = piece[14]; 
                var cidade = piece[15];
                var bairro = piece[16];
                
                
                
                //Atributos de incorporador        
                $("#codigo").val(codigo);
                $("#razaoSocial").val(razaoSocial); 
                $("#cnpjCpf").val(cnpjCpf);
                $("#tipoPessoa").val(tipoPessoa);  
                $("#inscMunicipal").val(inscMunicipal);
                $("#inscEstadual").val(inscEstadual);
                $("#contato").val(contato);
                $("#cargo").val(cargo);
                $("#telefone").val(telefone);  
                $("#cep").val(cep);
                $("#tipoLogradouro").val(tipoLogradouro);
                $("#logradouro").val(logradouro);
                $("#numero").val(numero);
                $("#complemento").val(complemento);
                $("#unidadeFederacao").val(estado);
                $("#cidade").val(cidade);
                $("#bairro").val(bairro);  
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function recuperaRazaoSocial(id) {
    $.ajax({
        url: 'js/sqlscopeIncorporador.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaRazaoSocial', id: id}, //valores enviados ao script     
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
                smartAlert("Atenção", "A razão social já foi registrada.", "error"); 
                $("#razaoSocial").val("");
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

function excluirIncorporador(id) {
    $.ajax({
        url: 'js/sqlscopeIncorporador.php', //caminho do arquivo a ser executado
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