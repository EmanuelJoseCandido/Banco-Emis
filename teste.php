<?php

    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    $conexaoPDO->beginTransaction(); // There is no active transaction

    /* $sql = 'SELECT * FROM banco WHERE Pessoa_codigoPessoa = (SELECT MAX(Pessoa_codigoPessoa) FROM banco)';
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

    #$valorParaAberturaDeConta = "";
    foreach($resultado as $valores)
    {
        $valorParaAberturaDeConta = $valores[5];
    }

    echo "Valor eh: ".$valorParaAberturaDeConta; */

   /*  include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
  
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
        $id = $valores[0];
    }
    echo "Valor eh: ".$id; */
/* 
    $iban = "AOO600510000571697801011";
    echo "<br>Iban antigo : ".$iban;

    $c = 2;
    $b = 0;
    $d = 0;

    for($i = 0; $i < $tamanho; $i++)
    {

       
        
        if($i == $c)
        {
            $iban2 .= "". substr($iban, $b, 3)." ";

            $c += 3;
            $b += 3;
            $d++;
       
        }
    }

   

   echo "<br>**Iban novo : ".$iban2;   */ 

  
   $identificacao = isset($_POST['identificacao']) ? $_POST['identificacao']:0;
   $senhaInformacao = criptografar(isset($_POST['senhaInformacao']) ? $_POST['senhaInformacao']:0);

   echo 'CONSULTA: '. $identificacao;
   echo '<br>CONSULTA2: '. $senhaInformacao;
   $sql = 'SELECT * FROM pessoa WHere identificacao = "$identificacao" and senhaInformacao = "$senhaInformacao"';
   
   
   try
   {
       $consulta = $conexaoPDO -> prepare($sql);
       while($row = $consulta -> fetch())
       {
           
       }
   }
   catch(PDOException $e) 
   {
       echo 'Error: ' . $e->getMessage();
   }

   foreach($resultado as $valores)
   {
       $id1 = $valores[3];
       $id2 = $valores[4];
       
   }
        echo 'CONSULTA: '. $id1;
        echo '<br>CONSULTA2: '. $id2;



/*
 function gerarNumeroDeConta()
    {
        $numeroDeConta = "";
        $padrao = ".10.001";
        
        if($GLOBALS['consulta'] == NULL)
        {
            $codigoNumeroDeConta = 15716978010113;
            $ultimoNumeroDeContaAdiconado = $codigoNumeroDeConta;
        }
        else
        {
            consultarDados1();
            echo "<br>Entrada normal depois da criacao da primeira conta.<br>";
            $ultimoNumeroDeContaAdiconado = $GLOBALS['ultimoNumeroDeContaAdiconado'];
        }

        $ultimoNumeroDeContaAdiconado .= $padrao;
        $numeroDeConta .= $ultimoNumeroDeContaAdiconado; 
        echo "<br>Ultima: ".$ultimoNumeroDeContaAdiconado;
        echo "<br>Numero de conta: ".$numeroDeConta;
        return $numeroDeConta;
    }
*/
?>


