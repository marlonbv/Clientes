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

if ($funcao == 'recuperaCPF') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CLIENTE_ACESSAR|CLIENTE_GRAVAR");

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

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = +$_POST["ativo"];
    }

    $tipoCliente = $_POST['tipoCliente'];
    $tipoCliente = "'" . $tipoCliente . "'";

    if ((empty($_POST['tipoCliente'])) || (!isset($_POST['tipoCliente'])) || (is_null($_POST['tipoCliente']))) {
        $tipoCliente = 'NULL';
    } else {
        $tipoCliente = "'" . $_POST["tipoCliente"] . "'";
    }

    $nome = $_POST['nome'];
    $nome = "'" . $nome . "'";

    $cpf = $_POST['cpf'];
    $cpf = "'" . $cpf . "'";

    $dtNasc = $_POST['dtNasc'];
    $dtNasc = str_replace('/', '-', $dtNasc);
    $dtNasc = date("Y-m-d", strtotime($dtNasc)); 
    $dtNasc = "'" . $dtNasc . "'";

    $dtAdInicial = $_POST['dtAdInicial'];
    $dtAdInicial = str_replace('/', '-', $dtAdInicial);
    $dtAdInicial = date("Y-m-d", strtotime($dtAdInicial)); 
    $dtAdInicial = "'" . $dtAdInicial . "'";

    $sexo = +$_POST['sexo'];
    
    $estadoCivil = +$_POST['estadoCivil'];
    $estadoCivil = "'" . $estadoCivil . "'";
    
    $obs = $_POST['obs'];
    $obs = "'" . $obs . "'";

    //Gravação de Telefone
    $strArrayTelefone = $_POST["jsonTels"];
    $arrayTelefone = json_decode($strArrayTelefone, true);
    $xmlTelefone = "";
    $nomeXml = "ArrayOfClienteTelefone";
    $nomeTabela = "clienteTelefone";
    if (sizeof($arrayTelefone) > 0) {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTelefone as $chave) {
            $xmlTelefone = $xmlTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialTel") or ( $campo === "descricaoTelefonePrincipal")) {
                    continue;
                }
                $xmlTelefone = $xmlTelefone . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTelefone = $xmlTelefone . "</" . $nomeTabela . ">";
        }
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    } else {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTelefone);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTelefone = "'" . $xmlTelefone . "'";

    
    //Gravação de Email
    $strArrayEmail = $_POST["jsonEmails"];
    $arrayEmail = json_decode($strArrayEmail, true);
    $xmlEmail = "";
    $nomeXml = "ArrayOfClienteEmail";
    $nomeTabela = "clienteEmail";
    if (sizeof($arrayEmail) > 0) {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayEmail as $chave) {
            $xmlEmail = $xmlEmail . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEmail") or ( $campo === "descricaoEmailPrincipal")) {
                    continue;
                }
                $xmlEmail = $xmlEmail . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlEmail = $xmlEmail . "</" . $nomeTabela . ">";
        }
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    } else {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlEmail);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de email";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlEmail = "'" . $xmlEmail . "'";

    //Gravação de Endereço
    $strArrayEndereco = $_POST["jsonEnds"];
    $arrayEndereco = json_decode($strArrayEndereco, true);
    $xmlEndereco = "";
    $nomeXml = "ArrayOfClienteEndereco";
    $nomeTabela = "clienteEndereco";
    if (sizeof($arrayEndereco) > 0) {
        $xmlEndereco = '<?xml version="1.0"?>';
        $xmlEndereco = $xmlEndereco . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayEndereco as $chave) {
            $xmlEndereco = $xmlEndereco . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEnd") or ( $campo === "descricaoTipoEndereco") or ( $campo === "descricaoEnderecoPrincipal") or ( $campo === "tipoEnd")) {
                    continue;
                }
                $xmlEndereco = $xmlEndereco . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlEndereco = $xmlEndereco . "</" . $nomeTabela . ">";
        }
        $xmlEndereco = $xmlEndereco . "</" . $nomeXml . ">";
    } else {
        $xmlEndereco = '<?xml version="1.0"?>';
        $xmlEndereco = $xmlEndereco . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlEndereco = $xmlEndereco . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlEndereco);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de endereco";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlEndereco = "'" . $xmlEndereco . "'";

    //*********************************************************** Endereço FIM********************************
    //***********************************************************Redes Sociais INÍCIO*************************

    $strArrayRedes = $_POST["jsonRedesArray"];
    $arrayRedes = json_decode($strArrayRedes, true);
    $xmlRedes = "";
    $nomeXml = "ArrayOfClienteRedes";
    $nomeTabela = "clienteRedesSociais";
    if (sizeof($arrayRedes) > 0)
    {
        $xmlRedes = '<?xml version="1.0"?>';
        $xmlRedes = $xmlRedes . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayRedes as $chave)
        {
            $xmlRedes = $xmlRedes . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor)
            {
                if (($campo === "sequencialRedes") | ($campo === "jsonRedes"))
                {
                    continue;
                }
                $xmlRedes = $xmlRedes . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlRedes = $xmlRedes . "</" . $nomeTabela . ">";
        }
        $xmlRedes = $xmlRedes . "</" . $nomeXml . ">";
    }
    else
    {
        $xmlRedes = '<?xml version="1.0"?>';
        $xmlRedes = $xmlRedes . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlRedes = $xmlRedes . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlRedes);
    if ($xml === false)
    {
        $mensagem = "Erro na criação do XML de redes";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlRedes = "'" . $xmlRedes . "'";  

    //***********************************************************Redes Sociais FIM****************************
 
     $sql = "cliente_Atualiza(" .$id .",".$sexo.",".$ativo.",".$nome.",".$cpf.",".$dtNasc.",".$dtAdInicial.",".$estadoCivil.",".$tipoCliente.",".$obs.",".$xmlTelefone.",".$xmlEmail.",".$xmlEndereco.",".$xmlRedes. ") ";
 
            
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
    
    //Recupera Clientes
    $id = $_POST['id'];
    $sql = "SELECT * FROM dbo.cliente WHERE cliente.codigo = $id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {

        //Atributos de Cliente 
        $nome = mb_convert_encoding($row['nome'],'UTF-8','HTML-ENTITIES');
        $cpf = $row['cpf'];
        $sexo = +$row['sexo'];
        $dtNasc = $row['dtNasc'];
        $dtNasc = date("d-m-Y", strtotime($dtNasc));
        $dtNasc = str_replace('-', '/', $dtNasc);
        
        $dtAdInicial = $row['dtAdInicial'];
        $dtAdInicial = date("d-m-Y", strtotime($dtAdInicial)); 
        $dtAdInicial = str_replace('-', '/', $dtAdInicial); 
    
        $ativo = +$row['situacao'];
        $tipoCliente = $row['tipoCliente'];
        $estadoCivil = $row['estadoCivil'];
        $obs =  mb_convert_encoding($row['obs'],'UTF-8','HTML-ENTITIES');

        $out = $id . "^" . $nome . "^" . $cpf . "^" . $sexo . "^" . $dtNasc . "^" . $dtAdInicial . "^" . $ativo . "^" .
                $tipoCliente . "^" . $estadoCivil. "^" . $obs;

        // Recupera telefone:
        $sqlTel = " SELECT * FROM dbo.clienteTelefone WHERE clienteTelefone.cliente = $id";

        $repositTel = new reposit();
        $resultTel = $repositTel->RunQuery($sqlTel);

        $contadorTelefone = 0;
        $arrayTelefone = array();

        while (($row = odbc_fetch_array($resultTel))) {
            $idClienteTelefone = $row['codigo'];
            $telefone = $row['telefone'];
            $principalTelefone = +$row["principal"];
            if ($principalTelefone === 1) {
                $descricaoTelefonePrincipal = "Sim";
            } else {
                $descricaoTelefonePrincipal = "Não";
            }

            $contadorTelefone = $contadorTelefone + 1;
            $arrayTelefone[] = array("telefoneId" => $idClienteTelefone,
                "sequencialTel" => $contadorTelefone,
                "telefone" => $telefone,
                "telefonePrincipal" => $principalTelefone,
                "descricaoTelefonePrincipal" => $descricaoTelefonePrincipal);
        }
        $strArrayTelefone = json_encode($arrayTelefone);

        // recupera email
        $sqlEmail = " SELECT * FROM dbo.clienteEmail WHERE clienteEmail.cliente = $id";

        $repositEmail = new reposit();
        $resultEmail = $repositEmail->RunQuery($sqlEmail);

        $contadorEmail = 0;
        $arrayEmail = array();

        while (($row = odbc_fetch_array($resultEmail))) {
            $idClienteEmail = +$row['codigo'];
            $email = $row['email'];
            $principalEmail = +$row["principal"];
            if ($principalEmail === 1) {
                $descricaoEmailPrincipal = "Sim";
            } else {
                $descricaoEmailPrincipal = "Não";
            }

            $contadorEmail = $contadorEmail + 1;
            $arrayEmail[] = array("emailId" => $idClienteEmail,
            "sequencialEmail" => $contadorEmail,
            "email" => $email,
            "emailPrincipal" => $principalEmail 
            );
        }
        $strArrayEmail = json_encode($arrayEmail);

        // recupera endereço
        $sqlEndereco = "  SELECT * FROM dbo.clienteEndereco WHERE clienteEndereco.cliente = $id";

        $repositEndereco = new reposit();
        $resultEndereco = $repositEndereco->RunQuery($sqlEndereco);

        $contadorEndereco = 0;
        $arrayEndereco = array();

        while (($row = odbc_fetch_array($resultEndereco))) {
            $idClienteEndereco = $row['codigo']; 
            $tipoLogradouro = mb_convert_encoding($row['tipoLogradouro'],'UTF-8','HTML-ENTITIES');
            $logradouro = mb_convert_encoding($row['logradouro'],'UTF-8','HTML-ENTITIES');
            $cidade = mb_convert_encoding($row['cidade'],'UTF-8','HTML-ENTITIES');
            $numero = $row['numero'];
            $complemento = mb_convert_encoding($row['complemento'],'UTF-8','HTML-ENTITIES');
            $unidadeFederacao = $row['unidadeFederacao'];
            $cep = $row['cep'];
            $bairro = mb_convert_encoding($row['bairro'],'UTF-8','HTML-ENTITIES'); 
            $referencia = mb_convert_encoding($row['referencia'],'UTF-8','HTML-ENTITIES');
            $principalEndereco = +$row["enderecoPrincipal"];
            if ($principalEndereco == 1) {
                $descricaoEnderecoPrincipal = "Sim";
            } else {
                $descricaoEnderecoPrincipal = "Não";
            }
            $tipoEndereco = $row['tipoEndereco'];
            if ($tipoEndereco == 'R') {
                $descricaoTipoEndereco = "Residencial";
            } else {
                $descricaoTipoEndereco = "Comercial";
            } 

            $contadorEndereco = $contadorEndereco + 1;
            $arrayEndereco[] = array("enderecoId" => $idClienteEndereco,
                "sequencialEnd" => $contadorEndereco, 
                "tipoLogradouro" => $tipoLogradouro,
                "logradouro" => $logradouro,
                "cidade" => $cidade,
                "numero" => $numero,
                "complemento" => $complemento,
                "unidadeFederacao" => $unidadeFederacao, 
                "cep" => $cep, 
                "bairro" => $bairro, 
                "referencia" => $referencia,
                "descricaoEnderecoPrincipal" => $descricaoEnderecoPrincipal,
                "tipoEndereco" => $tipoEndereco,
                "descricaoTipoEndereco" => $descricaoTipoEndereco);
        }
        $strArrayEndereco = json_encode($arrayEndereco);

        // recupera redes   
         

        $sql = "SELECT CRS.codigo, CRS.cliente, CRS.redesSociais, CRS.descricao AS url,RS.codigo AS codigoRedeSocial, RS.nome AS descricaoRedeSocial
                FROM dbo.clienteRedesSociais CRS
                INNER JOIN dbo.redesSociais RS ON CRS.redesSociais = RS.codigo
                WHERE CRS.cliente = $id";
        
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorRedes = 0;
        $arrayRedes = array();

        while (($row = odbc_fetch_array($result))) {
            $idClienteRedeSocial = $row['codigo'];
            $codigoRedeSocial = +$row['codigoRedeSocial'];
            $redeLink = mb_convert_encoding($row['url'],'UTF-8','HTML-ENTITIES'); 
            $descricaoRedeSocial = mb_convert_encoding($row['descricaoRedeSocial'],'UTF-8','HTML-ENTITIES');
            
            $contadorRedes += 1;
            $arrayRedes[] = array("redeSocialId" => $idClienteRedeSocial,
                "sequencialRedes" => $contadorRedes,
                "redeSocial" => $codigoRedeSocial,
                "descricaoRedeSocial" => $descricaoRedeSocial,
                "redeLink" => $redeLink);
        
        }
        $strArrayRedes = json_encode($arrayRedes);

        if ($out == "") {
            echo "failed|";
        }
        if ($out != '') {
            echo "sucess|" . $out . "|" . $strArrayTelefone . "|" . $strArrayEmail . "|" . $strArrayEndereco . "|" . $strArrayRedes;
        }
        return;
    }
}

 function recuperaCPF() {
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
    $sql = " SELECT * FROM dbo.cliente CLI WHERE CLI.cpf = '$id' ";
 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql); 

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $id = $row['cpf']; 
          
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
    $possuiPermissao = $reposit->PossuiPermissao("CLIENTE_ACESSAR|CLIENTE_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um cliente.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 

    $sql = "cliente_Deleta (" . $id . ") ";

    $repositCliente = new reposit();
    $result = $repositCliente->Execprocedure($sql);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
