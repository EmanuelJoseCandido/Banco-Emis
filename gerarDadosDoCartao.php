<?php
    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    $conexaoPDO->beginTransaction(); // There is no active transaction

    $banco = "BIC";
    $consulta = 0;
    $numeroDeContaElectronica = "";
    $ultimoIbanAdiconado = 0;
    $ultimoNumeroDeContaAdiconado = 0;
    $nome = "Sem nome";

    consultarDados2();
    if($banco == "BIC")
    {
        $iban = gerarIban();
        $numeroDeConta = gerarNumeroDeConta();
        $valorNaConta = pegarValorDeAberturaDeConta();
        $numeroDeContaElectronica .= $numeroDeConta . "-00BIC/AO";
        $pin = rand(1000, 9999);
        $estado = "Activo(a)";
        
        // Codigo de inserção de informação na tabela Banco
        $sql = 'INSERT INTO cartaobanco(Pessoa_codigoPessoa, Banco_codigoBanco, iban, numeroDeConta, valorNaConta, numeroDeContaElectronica, pin, estado) VALUES 
        ((SELECT MAX(codigoBanco) FROM banco), (SELECT MAX(codigoBanco) FROM banco), ?, ?, ?, ?, ?, ?)';
        $pstmt = $conexaoPDO->prepare($sql);
        $pstmt->bindParam(1, $iban);
        $pstmt->bindParam(2, $numeroDeConta);
        $pstmt->bindParam(3, $valorNaConta);
        $pstmt->bindParam(4, $numeroDeContaElectronica);
        $pstmt->bindParam(5, $pin);
        $pstmt->bindParam(6, $estado);

        $pstmt->execute();
        $conexaoPDO->commit();

        /* require_once __DIR__ . '/vendor/autoload.php';
    
        $pagina = 
            "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <title>Document</title>
            </head>
            <body>
                <h1>Banco BIC<h1/>
                <img src='_galeria/_imagens/bic_logo_1.png' alt='Logottipo do BIC'>
                <ul>
                    <li>Nome: '$nome'</li>
                    <li>IBAN: '$iban'</li>
                    <li>Número de Conta: '$numeroDeConta'</li>
                    <li>Número de Conta Electrónica: '$numeroDeContaElectronica'</li>
                    <li>PIN: '$pin'</li>
                </ul>
                <h4>http://www.emis.co.ao<h4>
            </body>
            </html>";

            $arquivo = "cadastar01.pdf";
            $mpdf = new \Mpdf\Mpdf();
            
            $mpdf -> WriteHtml($pagina);
            $mpdf -> Output($arquivo, 'I'); */

            echo"<script language='javascript' type='text/javascript'> 
        alert('Dados Cadastrados com sucesso.');
        </script>"; die(); 

        #cadastrar1();
    }
    else if($banco == "BPC")
    {
        $iban = gerarIban();
        $numeroDeConta = gerarNumeroDeConta();
        $valorNaConta;
        $numeroDeContaElectronica = $numeroDeConta + "-00BPC/AO";
        $pin = range(1000, 9999);
        $estado = "Activo(a)";
    }


    // Função para gerar (NÚMERO DE CONTA) do Banco BIC
    function gerarNumeroDeConta()
    {
        $numeroDeConta = "";
        $padrao = ".10.001";
        echo "<br>3 - O que eh: ".$GLOBALS['consulta'];
        
        if($GLOBALS['consulta'] == NULL)
        {
            $codigoNumeroDeConta = 15716978010113;
            $ultimoNumeroDeContaAdiconado = $codigoNumeroDeConta;
        }
        else
        {
            consultarDados1();
            $ultimoNumeroDeContaAdiconado = $GLOBALS['ultimoNumeroDeContaAdiconado']++;
        }

        $ultimoNumeroDeContaAdiconado .= $padrao;
        $numeroDeConta .= $ultimoNumeroDeContaAdiconado; 
        echo "<br>Ultima: ".$ultimoNumeroDeContaAdiconado;
        echo "<br>Numero de conta: ".$numeroDeConta;
        return $numeroDeConta;
    }

    // Função para gerar (IBAN) do Banco BIC
    function gerarIban()
    {
        $iban = "AOO600510000";
        if($GLOBALS['consulta'] == NULL)
        {
            $codigoIban = 5716978010113;
            $ultimoIbanAdiconado = $codigoIban;
        }
        else
        {
            $ultimoIbanAdiconado = $GLOBALS['ultimoIbanAdiconado']++;
        }

        $iban .=  $ultimoIbanAdiconado;
        echo "Iban: ".$iban;

        return $iban;
    }

    // Função para pegar o valor depósito de abertura de conta do Banco BIC
    function pegarValorDeAberturaDeConta()
    {
        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados
  
        $sql = 'SELECT * FROM banco WHERE Pessoa_codigoPessoa = (SELECT MAX(Pessoa_codigoPessoa) FROM banco)';
        
        try
        {
            $consulta = $conexaoPDO -> prepare($sql);
            $consulta -> execute();
            $resultado = $consulta -> fetchAll(PDO::FETCH_NUM);
        }
        catch(PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
        }
    
        foreach($resultado as $valores)
        {
            $valorParaAberturaDeConta = $valores[5];
        }
   
        return $valorParaAberturaDeConta;
    }


    function consultarDados1()
    {
        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados
  
        $sql = 'SELECT * FROM cartaobanco WHERE codigoCartaoBanco  = (SELECT MAX(codigoCartaoBanco ) FROM cartaobanco)';
    
        try
        {
            $consulta = $conexaoPDO -> prepare($sql);
            $consulta -> execute();
            $resultado = $consulta -> fetchAll(PDO::FETCH_NUM);
        }
        catch(PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
        }

        foreach($resultado as $valores)
        {
            $GLOBALS['ultimoIbanAdiconado'] = $valores[3];
            $GLOBALS['ultimoNumeroDeContaAdiconado'] = $valores[6];  
        }
    
    }

    function consultarDados2()
    {
        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados
  
        $sql = 'SELECT MAX(codigoCartaoBanco) FROM CartaoBanco';
    
        try
        {
            $consulta = $conexaoPDO -> prepare($sql);
            $consulta -> execute();
            $resultado = $consulta -> fetchAll(PDO::FETCH_NUM);
        }
        catch(PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
        }

        foreach($resultado as $valores)
        {
            $GLOBALS['consulta'] = $valores[0];
            
        }
        echo 'CONSULTA: '.$GLOBALS['consulta'];
    
    }

?>