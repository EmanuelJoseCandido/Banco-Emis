<?php
    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    $conexaoPDO->beginTransaction(); // There is no active transaction

    /* $iban = "AOO600510000";
    $ultimoIbanAdicionado = "-5716978010113";
    $iban .=  $ultimoIbanAdicionado;

    echo $iban; 

    $ultimoIbanAdicionados;
    $ultimoNumeroDeContaAdiconado;
  
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
        $ultimoIbanAdicionado = $valores[3];
        $ultimoNumeroDeContaAdiconado = $valores[4];  
    }

    echo "<br>O Ultimo Iban: ".$ultimoIbanAdicionado;
    echo "<br>O Ultimo NumC: ".$ultimoNumeroDeContaAdiconado; */


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

?>