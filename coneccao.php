<?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "Angola12";
    $nomeDaBaseDeDados = "lv_ec";
    $sqlPDO = "mysql:host=$servidor; dbname=$nomeDaBaseDeDados;";
    $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    //Criação de uma nova conecção usando PDO, $conexao é o objecto.   
    try 
    { 
        $conexaoPDO = new PDO($sqlPDO, $usuario, $senha, $dsn_Options);
        $conexaoPDO -> exec('SET CHARACTER SET utf8');
    } 
    catch (PDOException $error) 
    {
        echo 'Connection error: ' . $error->getMessage();
    }
?>