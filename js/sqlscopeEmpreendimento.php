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

if ($funcao == 'recuperaDescricao') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("EMPREENDIMENTO_ACESSAR|EMPREENDIMENTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    
    //Recupera os atributos de business Empreendimento
    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = +$_POST["id"];
    }
   
    $nome = $_POST['nome'];
    $nome = "'" . $nome . "'";
    
    $inscricaoMunicipal = $_POST['inscricaoMunicipal'];
    $inscricaoMunicipal = "'" . $inscricaoMunicipal . "'";
    
    $engenheiroResponsavel = $_POST['engenheiroResponsavel'];
    $engenheiroResponsavel = "'" . $engenheiroResponsavel . "'";
    
    $incorporador = +$_POST['incorporador'];
    
    $observacao = $_POST['observacao'];
    $observacao = "'" . $observacao . "'";
    
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
     
    $sql = "empreendimento_Atualiza(" .$id .",".$nome.",".$inscricaoMunicipal .",".$engenheiroResponsavel .",".$incorporador.",".$observacao.",".$cep .",".$tipoLogradouro .",".$logradouro .",".$numero .",".$complemento .",".$estado .",".$cidade .",".$bairro .")";
  
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
    $sql = "SELECT *, (
            SELECT COUNT(*)
            FROM dbo.bloco B
            WHERE B.empreendimento = E.codigo) 
            AS qtdBlocos,
            (SELECT COUNT(*)
            FROM dbo.unidade U
            WHERE U.empreendimento = E.codigo)
            AS qtdUnidades,
            (SELECT SUM(U.vinculadas) 
            FROM dbo.unidade U
            WHERE U.empreendimento = E.codigo)
            AS qtdVinculadas
            FROM dbo.empreendimento E
            WHERE E.codigo = $id "; 

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $nome = mb_convert_encoding($row['nome'],'UTF-8','HTML-ENTITIES');
        $inscricaoMunicipal = mb_convert_encoding($row['inscricaoMunicipal'],'UTF-8','HTML-ENTITIES');
        $engenheiroResponsavel = mb_convert_encoding($row['engenheiroResponsavel'],'UTF-8','HTML-ENTITIES');
        $incorporador = +$row['incorporador'];
        $observacao = mb_convert_encoding($row['observacao'],'UTF-8','HTML-ENTITIES');
        $cep = mb_convert_encoding($row['cep'],'UTF-8','HTML-ENTITIES');
        $tipoLogradouro = mb_convert_encoding($row['tipoLogradouro'],'UTF-8','HTML-ENTITIES');
        $logradouro = mb_convert_encoding($row['logradouro'],'UTF-8','HTML-ENTITIES');
        $numero = +$row['numero'];
        $complemento = mb_convert_encoding($row['complemento'],'UTF-8','HTML-ENTITIES');
        $estado = mb_convert_encoding($row['estado'],'UTF-8','HTML-ENTITIES');
        $cidade = mb_convert_encoding($row['cidade'],'UTF-8','HTML-ENTITIES');
        $bairro = mb_convert_encoding($row['bairro'],'UTF-8','HTML-ENTITIES');
        $qtdBlocos = +$row['qtdBlocos'];
        $qtdUnidades = +$row['qtdUnidades'];
        $qtdVinculadas = +$row['qtdVinculadas'];

        $out = $id . "^" . $nome . "^" . $inscricaoMunicipal . "^" . $engenheiroResponsavel . "^" . $incorporador
                . "^" . $observacao . "^" . $cep . "^" . $tipoLogradouro . "^" . $logradouro . "^" . $numero
                . "^" . $complemento . "^" . $estado . "^" . $cidade . "^" . $bairro. "^" . $qtdBlocos . "^" .
                $qtdUnidades . "^" . $qtdVinculadas;

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
    $possuiPermissao = $reposit->PossuiPermissao("EMPREENDIMENTO_ACESSAR|EMPREENDIMENTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um empreendimento.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 

    $sql = "empreendimento_Deleta (" . $id . ") ";

    $repositCliente = new reposit();
    $result = $repositCliente->Execprocedure($sql);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

