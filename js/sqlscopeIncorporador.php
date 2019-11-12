<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaRazaoSocial') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("INCORPORADOR_ACESSAR|INCORPORADOR_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = +$_POST["id"];
    }
 
    $razaoSocial = $_POST['razaoSocial'];
    $razaoSocial = "'" . $razaoSocial . "'";
    
    $tipoPessoa = $_POST['tipoPessoa'];
    $tipoPessoa = "'" . $tipoPessoa . "'";
    
    $cnpjCpf = $_POST['cnpjCpf'];
    $cnpjCpf = "'" . $cnpjCpf . "'";
    
    $inscMunicipal = $_POST['inscMunicipal'];
    $inscMunicipal = "'" . $inscMunicipal . "'";
    
    $inscEstadual = $_POST['inscEstadual'];
    $inscEstadual = "'" . $inscEstadual . "'";
    
    $contato = $_POST['contato'];
    $contato = "'" . $contato . "'";
    
    $cargo = $_POST['cargo'];
    $cargo = "'" . $cargo . "'";
    
    $telefone = $_POST['telefone'];
    $telefone = "'" . $telefone . "'";
    
    $cep = $_POST['cep'];
    $cep = "'" . $cep . "'";

    $tipoLogradouro = $_POST['tipoLogradouro'];
    $tipoLogradouro = "'" . $tipoLogradouro . "'";
    
    $logradouro = $_POST['logradouro'];
    $logradouro = "'" . $logradouro . "'";
    
    $numero = +$_POST["numero"];
   
    $complemento = $_POST['complemento'];
    $complemento = "'" . $complemento . "'";
    
    $estado = $_POST['estado'];
    $estado = "'" . $estado . "'";
    
    $cidade = $_POST['cidade'];
    $cidade = "'" . $cidade . "'";
    
    $bairro = $_POST['bairro'];
    $bairro = "'" . $bairro . "'";
    
     $sql = "incorporador_Atualiza(" .$id .",".$razaoSocial.",".$tipoPessoa.",".$cnpjCpf.",".$inscMunicipal.","
             .$inscEstadual.",".$contato.",".$cargo.",".$telefone.",".$cep.",".$tipoLogradouro.",".$logradouro.",".$numero.",".$complemento.""
             . ",".$estado.",".$cidade.",".$bairro.")";
  
    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera() {
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $usuarioIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $id = $_POST['id'];
    $sql = " SELECT * FROM dbo.incorporador WHERE incorporador.codigo = $id ";

     

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $razaoSocial = mb_convert_encoding($row['razaoSocial'],'UTF-8','HTML-ENTITIES');
        $tipoPessoa =  mb_convert_encoding($row['tipoPessoa'],'UTF-8','HTML-ENTITIES');
        $cnpjCpf = mb_convert_encoding($row['cnpjCpf'],'UTF-8','HTML-ENTITIES');
        $inscMunicipal = mb_convert_encoding($row['inscMunicipal'],'UTF-8','HTML-ENTITIES');
        $inscEstadual = mb_convert_encoding($row['inscEstadual'],'UTF-8','HTML-ENTITIES');
        $contato = mb_convert_encoding($row['contato'],'UTF-8','HTML-ENTITIES');
        $cargo = mb_convert_encoding($row['cargo'],'UTF-8','HTML-ENTITIES');
        $telefone = mb_convert_encoding($row['telefone'],'UTF-8','HTML-ENTITIES');
        $cep = mb_convert_encoding($row['cep'],'UTF-8','HTML-ENTITIES');
        $tipoLogradouro = mb_convert_encoding($row['tipoLogradouro'],'UTF-8','HTML-ENTITIES');
        $logradouro = mb_convert_encoding($row['logradouro'],'UTF-8','HTML-ENTITIES');
        $numero = +$row['numero'];
        $complemento = mb_convert_encoding($row['complemento'],'UTF-8','HTML-ENTITIES');
        $estado = mb_convert_encoding($row['estado'],'UTF-8','HTML-ENTITIES');
        $cidade = mb_convert_encoding($row['cidade'],'UTF-8','HTML-ENTITIES');
        $bairro = mb_convert_encoding($row['bairro'],'UTF-8','HTML-ENTITIES');
        
         
        $out = $id . "^" . $razaoSocial . "^" . $cnpjCpf . "^" . $tipoPessoa . "^" . $inscMunicipal . "^" . $inscEstadual
                . "^" .  $contato . "^" . $cargo . "^" . $telefone . "^" . $cep . "^" . $tipoLogradouro . "^" .
                $logradouro . "^" . $numero . "^" . $complemento . "^" . $estado . "^" . $cidade
                . "^" . $bairro;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }

 }
 
function recuperaRazaoSocial() {
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $usuarioIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $id = $_POST['id'];
    $sql = " SELECT * FROM dbo.incorporador I WHERE I.razaoSocial = '$id' ";
 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = $row['razaoSocial']; 
          
        $out = $id;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }

 }
 
 function excluir() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("INCORPORADOR_ACESSAR|INCORPORADOR_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um incorporador.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 

    $sql = "incorporador_Deleta (" . $id . ") ";

    $repositCliente = new reposit();
    $result = $repositCliente->Execprocedure($sql);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

