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

if ($funcao == 'recuperaNome') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("BLOCO_ACESSAR|BLOCO_GRAVAR");

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
 
    $empreendimento = $_POST['empreendimento'];
    $empreendimento = "'" . $empreendimento . "'";
    
    $nome = $_POST['nome'];
    $nome = "'" . $nome . "'";
    
    $natureza = $_POST['natureza'];
    $natureza = "'" . $natureza . "'";
    
    $estagioObra = $_POST['estagioObra'];
    $estagioObra = "'" . $estagioObra . "'";
    
    $dataInicioConstrucao = $_POST['dataInicioConstrucao'];
    $dataInicioConstrucao = str_replace('/', '-', $dataInicioConstrucao);
    $dataInicioConstrucao = date("Y-m-d", strtotime($dataInicioConstrucao)); 
    $dataInicioConstrucao = "'" . $dataInicioConstrucao . "'";
    
    $dataEntregaChaves = $_POST['dataEntregaChaves'];
    $dataEntregaChaves = str_replace('/', '-', $dataEntregaChaves);
    $dataEntregaChaves = date("Y-m-d", strtotime($dataEntregaChaves)); 
    $dataEntregaChaves = "'" . $dataEntregaChaves . "'";
    
    $observacao = $_POST['observacao'];
    $observacao = "'" . $observacao . "'";
    
     //***********************************************************TIPOLOGIA INÍCIO*************************

    $strArrayTipologia = $_POST["jsonTipologiaArray"];
    $arrayTipologia = json_decode($strArrayTipologia, true);
    $xmlTipologia = "";
    $nomeXml = "ArrayTipologia";
    $nomeTabela = "Tipologia";
    if (sizeof($arrayTipologia) > 0)
    {
        $xmlTipologia = '<?xml version="1.0"?>';
        $xmlTipologia = $xmlTipologia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTipologia as $chave)
        {
            $xmlTipologia = $xmlTipologia . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor)
            {
                if (($campo === "sequencialTipologia") | ($campo === "jsonTipologia"))
                {
                    continue;
                }
                $xmlTipologia = $xmlTipologia . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTipologia = $xmlTipologia . "</" . $nomeTabela . ">";
        }
        $xmlTipologia = $xmlTipologia . "</" . $nomeXml . ">";
    }
    else
    {
        $xmlTipologia = '<?xml version="1.0"?>';
        $xmlTipologia = $xmlTipologia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTipologia = $xmlTipologia . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTipologia);
    if ($xml === false)
    {
        $mensagem = "Erro na criação do XML de redes";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTipologia = "'" . $xmlTipologia . "'";  

    //***********************************************************TIPOLOGIA FIM****************************
    
     $sql = "bloco_Atualiza(" .$id .",".$empreendimento.",".$nome.",".$natureza.",".$estagioObra.","
             .$dataInicioConstrucao.",".$dataEntregaChaves.",".$observacao.")";
  
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
    $sql = " SELECT *, 
            (SELECT COUNT(U.unidade) 
            FROM dbo.unidade U
            WHERE bloco = $id ) AS qtdUnidades,
            (SELECT SUM(U.vinculadas)
            FROM dbo.unidade U
            WHERE bloco = $id ) AS qtdVinculadas
            FROM dbo.bloco 
            WHERE bloco.codigo = $id ";

     

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $empreendimento = +$row['empreendimento'];
        $nome =  mb_convert_encoding($row['nome'],'UTF-8','HTML-ENTITIES');
        $natureza = +$row['natureza'];
        $estagioObra =  +$row['estagioObra'];
        $unidades = (int) $row['qtdUnidades'];
        $vinculadas =  (int) $row['qtdVinculadas'];
        
        
        //Recupera a data e formata no padrão certo para data a data do inicioConstrucao & EntregaChaves
        $dataInicioConstrucao = mb_convert_encoding($row['dataInicioConstrucao'],'UTF-8','HTML-ENTITIES');
        $dataInicioConstrucao = date("d-m-Y", strtotime($dataInicioConstrucao)); 
        $dataInicioConstrucao = str_replace('-', '/', $dataInicioConstrucao);  
        
        $dataEntregaChaves = mb_convert_encoding($row['dataEntregaChaves'],'UTF-8','HTML-ENTITIES');
        $dataEntregaChaves = date("d-m-Y", strtotime($dataEntregaChaves)); 
        $dataEntregaChaves = str_replace('-', '/', $dataEntregaChaves);  
        
        $observacao = mb_convert_encoding($row['observacao'],'UTF-8','HTML-ENTITIES');
          
        $out = $id . "^" . $empreendimento . "^" . $nome . "^" . $natureza . "^" . $estagioObra
                . "^" .  $dataInicioConstrucao . "^" . $dataEntregaChaves . "^" . $observacao ."^" . $unidades."^" . $vinculadas;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }

 }
 
function recuperaEmpreendimento() {
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
    $sql = " SELECT * FROM dbo.bloco I WHERE I.razaoSocial = '$id' ";
 
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
    $possuiPermissao = $reposit->PossuiPermissao("BLOCO_ACESSAR|BLOCO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um bloco.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 

    $sql = "bloco_Deleta (" . $id . ") ";

    $repositCliente = new reposit();
    $result = $repositCliente->Execprocedure($sql);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

