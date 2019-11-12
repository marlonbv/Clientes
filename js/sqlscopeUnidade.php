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
    $possuiPermissao = $reposit->PossuiPermissao("UNIDADE_ACESSAR|UNIDADE_GRAVAR");

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
 
    $empreendimento = +$_POST['empreendimento'];
    
    $blocos = +$_POST['blocos'];
    
    $vinculadas = +$_POST['vinculadas'];
    
    $matricula = $_POST['matricula'];
    $matricula = "'" . $matricula . "'";
    
    $unidade = +$_POST['unidade'];
    
    $andar = $_POST['andar'];
    $andar = "'" . $andar . "'";
    
    $coluna = +$_POST['coluna'];
    
    $tipologia = +$_POST['tipologia'];
    
    $posicaoSol = +$_POST['posicaoSol'];
    
    $vistaUnidade = +$_POST['vistaUnidade'];
    
    //Lista 
    $strArrayQuadroAreas = $_POST["jsonQuadroAreasArray"];
    $arrayQuadroAreas = json_decode($strArrayQuadroAreas, true);
    $xmlQuadroAreas = "";
    $nomeXml = "ArrayOfQuadroAreas";
    $nomeTabela = "unidade";
    if (sizeof($arrayQuadroAreas) > 0)
    {
        $xmlQuadroAreas = '<?xml version="1.0"?>';
        $xmlQuadroAreas = $xmlQuadroAreas . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayQuadroAreas as $chave)
        {
            $xmlQuadroAreas = $xmlQuadroAreas . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor)
            {
                if (($campo === "sequencialQuadroAreas") | ($campo === "jsonQuadroAreas"))
                {
                    continue;
                }
                $xmlQuadroAreas = $xmlQuadroAreas . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlQuadroAreas = $xmlQuadroAreas . "</" . $nomeTabela . ">";
        }
        $xmlQuadroAreas = $xmlQuadroAreas . "</" . $nomeXml . ">";
    }
    else
    {
        $xmlQuadroAreas = '<?xml version="1.0"?>';
        $xmlQuadroAreas = $xmlQuadroAreas . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlQuadroAreas = $xmlQuadroAreas . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlQuadroAreas);
    if ($xml === false)
    {
        $mensagem = "Erro na criação do XML de quadro de áreas";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlQuadroAreas = "'" . $xmlQuadroAreas . "'";  
    
    $inscricaoPredial = $_POST['inscricaoPredial'];
    $inscricaoPredial = "'" . $inscricaoPredial . "'";
    
    $areaUtil = $_POST['areaUtil'];
    
    $areaPrivada = $_POST['areaPrivada'];
    
    $vistaUnidade = $_POST['vistaUnidade'];
    
    $vistaComum = +$_POST['vistaComum'];
    
    $vistaTotal = +$_POST['vistaTotal'];
    
    $sql = "unidade_Atualiza(" .$id .",".$descricao.")";
  
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
    $sql = " SELECT * FROM dbo.unidade WHERE unidade.codigo = $id ";

     

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $descricao = mb_convert_encoding($row['descricao'],'UTF-8','HTML-ENTITIES');
         

        $out = $id . "^" . $descricao;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }

 }
 
  function recuperaDescricao() {
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
    $sql = " SELECT * FROM dbo.unidade S WHERE S.descricao = '$id' ";
 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = $row['descricao']; 
          
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
    $possuiPermissao = $reposit->PossuiPermissao("UNIDADE_ACESSAR|UNIDADE_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um unidade.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 

    $sql = "unidade_Deleta (" . $id . ") ";

    $repositCliente = new reposit();
    $result = $repositCliente->Execprocedure($sql);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

