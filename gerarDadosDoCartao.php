<?php
    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    $conexaoPDO->beginTransaction(); // There is no active transaction

    $banco = "BIC";
    $consulta = 0;
    $numeroDeContaElectronica = "";
    $ultimoIbanAdicionado = 0;
    $ultimoNumeroDeContaAdiconado = 0;

    consultarDados2();
    if($banco == "BIC")
    {
        $numeroDeConta = gerarNumeroDeConta();
        $iban = "AOO600510000". $numeroDeConta;
        $numeroDeContaCompleto = $numeroDeConta.".10.001";
        $valorNaConta = pegarValorDeAberturaDeConta();
        $numeroDeContaElectronica .= $numeroDeContaCompleto . "-00BIC/AO";
        $pin = rand(1000, 9999);
        $estado = "Activo(a)";
        
        // Codigo de inserção de informação na tabela Banco
        $sql = 'INSERT INTO cartaobanco(Pessoa_codigoPessoa, Banco_codigoBanco, iban, numeroDeConta, numeroDeContaCompleto, valorNaConta, numeroDeContaElectronica, pin, estado) VALUES 
        ((SELECT MAX(codigoBanco) FROM banco), (SELECT MAX(codigoBanco) FROM banco), ?, ?, ?, ?, ?, ?, ?)';
        $pstmt = $conexaoPDO->prepare($sql);
        $pstmt->bindParam(1, $iban);
        $pstmt->bindParam(2, $numeroDeConta);
        $pstmt->bindParam(3, $numeroDeContaCompleto);
        $pstmt->bindParam(4, $valorNaConta);
        $pstmt->bindParam(5, $numeroDeContaElectronica);
        $pstmt->bindParam(6, $pin);
        $pstmt->bindParam(7, $estado);

        $pstmt->execute();
        $conexaoPDO->commit();

        $nome = pegarNome();

        require_once __DIR__ . '/vendor/autoload.php';
    
        $pagina = 
            "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <link rel='stylesheet' href='_css/styleParaPDF.css'>
                <title>Dados do Cliente</title>
            </head>
            <body>
                <h1>Banco BIC</h1>  
                <br><br>
                <img src='_galeria/_imagens/bic_logo_1.png' alt='Logottipo do BIC' div='logo' width='150' height='150'>
                <div>
                    <ul>
                        <li><span>Nome:</span> $nome</li>
                        <li><span>IBAN:</span> $iban</li>
                        <li><span>Número de Conta:</span> $numeroDeConta</li>
                        <li><span>Número de Conta Electrónica:</span> $numeroDeContaElectronica</li>
                        <li><span>PIN:</span> $pin</li>
                    </ul>
                </div>
                <footer id='rodape'>
                    <p><span>Localização da Sede:</span> Benfica, Autodrómo, Rua das Aves, Travessa do Kuito.</p>
                    <p>Banco Banco Internacional de Crédito(BIC)</p>
                    <p>Todos os direitos reservados <br> Copyright &copy; 2019 - by <a href='http://127.0.0.1/banco-emis'>Banco EMIS</a></p>
                 </footer>
            </body>
            </html>";

            $arquivo = "cadastar01.pdf";
            $mpdf = new \Mpdf\Mpdf();
            
            $mpdf -> WriteHtml($pagina);
            $mpdf -> Output($arquivo, 'I');

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
        
        if($GLOBALS['consulta'] == NULL)
        {
            $codigoNumeroDeConta = 15716978010113;
            $ultimoNumeroDeContaAdiconado = $codigoNumeroDeConta;
        }
        else
        {
            consultarDados1();
            $ultimoNumeroDeContaAdiconado = $GLOBALS['ultimoNumeroDeContaAdiconado'];
        }

        $numeroDeConta = $ultimoNumeroDeContaAdiconado;
        $numeroDeConta++; 

        return $numeroDeConta;
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

    function pegarNome()
    {
        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados

        $sql = 'SELECT * FROM cartaobanco WHERE Pessoa_codigoPessoa = (SELECT MAX(Pessoa_codigoPessoa) FROM cartaobanco)';
        
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
            $Pessoa_codigoPessoa = $valores[1];
        }

        $sql = 'SELECT * FROM pessoa WHERE codigoPessoa = '.$Pessoa_codigoPessoa;
        
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
            $nome = $valores[1];
        }
   
        return $nome;
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
            $GLOBALS['ultimoIbanAdicionado'] = $valores[3];
            $GLOBALS['ultimoNumeroDeContaAdiconado'] = $valores[4];  
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
    }

?>