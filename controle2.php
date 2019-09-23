<?php

     /**
     * Autor: Emanuel Cândido
     * Email: emanueljosecandido@hotmail.com
     * GitHub: EmanuelJoseCandido
     * Facebook: Emanuel Cândido
     * Telfones: (Unitel: 921815882) | (Movicel: 990815882)
     * Descrição: página denominada controle2.php, que serve como uma ponte entre o html e mysql para cadastro de dados enviadas pela p]agina conta2.html.
     * 
     */

    // Investigar sobre beginTransaction(),$pstmt->execute(), $conexaoPDO->commit(); 
    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    
    $conexaoPDO->beginTransaction(); // There is no active transaction
    
    try
    {   
        //Inicio Banco
        $nomeDoBanco = isset($_POST['nomeDoBanco']) ? $_POST['nomeDoBanco']:0;
        $CartaoDeContribuente = isset($_POST['CartaoDeContribuente']) ? $_POST['CartaoDeContribuente']:0;
        $salario = isset($_POST['salario']) ? $_POST['salario']:0;
        $valorAberturaDeConta = isset($_POST['valorParaAberturaDeConta']) ? $_POST['valorParaAberturaDeConta']:0; 
        $fotografia = isset($_POST['fotografia']) ? $_POST['fotografia']:0;

           // Codigo de inserção de informação na tabela Banco
            $sql = 'INSERT INTO banco(Pessoa_codigoPessoa, nomeBanco, cartaoDeContribuente, salario, valorDaAberturaDeConta, fotografia) VALUES 
            ((SELECT MAX(codigoPessoa) FROM pessoa), ?, ?, ?, ?, ?)';
            $pstmt = $conexaoPDO->prepare($sql);
            $pstmt->bindParam(1, $nomeDoBanco);
            $pstmt->bindParam(2, $CartaoDeContribuente);
            $pstmt->bindParam(3, $salario);
            $pstmt->bindParam(4, $valorAberturaDeConta);
            $pstmt->bindParam(5, $fotografia);
    
            $pstmt->execute();
            $conexaoPDO->commit();
            #$pstmt->bindParam(1, $conexaoPDO->lastInsertId());
            #require_once("../conexao/conect.php");
            
            echo"<script language='javascript' type='text/javascript'> 
	
			window.location .href='gerarDadosDoCartao.php';
	        </script>"; die(); 
    }
    catch(PDOException $e) 
    {
        echo 'Error: ' . $e->getMessage();
    }

    
?>