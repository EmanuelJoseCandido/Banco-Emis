<?php

    /**
     * Autor: Emanuel Cândido
     * Email: emanueljosecandido@hotmail.com
     * GitHub: EmanuelJoseCandido
     * Facebook: Emanuel Cândido
     * Telfones: (Unitel: 921815882) | (Movicel: 990815882)
     * Descrição: página denominada controle.php, que serve como uma ponte entre o html e mysql para cadastro de dados enviadas pela p]agina conta.html.
     * 
     */

    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
 
    try
    {
        //Inicio Pessoa
        $nome = isset($_POST['nome']) ? $_POST['nome']:0;
        $dataDeNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento']:0;
        $identificacao = isset($_POST['identificacao']) ? $_POST['identificacao']:0;
        $senhaInformacao1 = criptografar(isset($_POST['senhaInformacao1']) ? $_POST['senhaInformacao1']:0);
        $senhaInformacao2 = criptografar(isset($_POST['senhaInformacao2']) ? $_POST['senhaInformacao2']:0);
       

        //Inicio Contacto
        $telefone1 = isset($_POST['telefone1']) ? $_POST['telefone1']:0;
        $telefone2 = isset($_POST['telefone2']) ? $_POST['telefone2']:0;
        $email = isset($_POST['email']) ? $_POST['email']:0;

        //Inicio Filiacao
        $nomeDoPai = isset($_POST['nomePai']) ? $_POST['nomePai']:0;
        $nomeDaMae = isset($_POST['nomeMae']) ? $_POST['nomeMae']:0;

        //Inicio Endereço
        $provincia = isset($_POST['provincia']) ? $_POST['provincia']:0;
        $municipio = isset($_POST['municipio']) ? $_POST['municipio']:0;
        $bairro= isset($_POST['bairro']) ? $_POST['bairro']:0;
        $rua = isset($_POST['rua']) ? $_POST['rua']:0;
        $numeroDeCasa = isset($_POST['numeroDeCasa']) ? $_POST['numeroDeCasa']:0;
        
        //Codição para checar se as senhas coincidem
        if($senhaInformacao1 == $senhaInformacao2)
        {
            $sql1 = 'INSERT INTO pessoa(nome, dataDeNascimento, identificacao, senhaInformacao) VALUES (:nome, :dataDeNascimento, :identificacao, :senhaInformacao1)';
            $stmt1 = $conexaoPDO -> prepare($sql1);
            $stmt1 -> execute(array(
                ':nome' => $nome, 
                ':dataDeNascimento' => $dataDeNascimento,
                ':identificacao' => $identificacao,
                ':senhaInformacao1' => $senhaInformacao1,
            ));
        
            //Pegar o último id inserido na base de dados
            $Pessoa_codigoPessoa = $conexaoPDO->lastInsertId();

            // Codigo de inserção de informação na tabela filiação
            $sql2 = 'INSERT INTO filiacao(Pessoa_codigoPessoa, nomeDoPai, nomeDaMae) VALUES (:Pessoa_codigoPessoa, :nomeDoPai, :nomeDaMae)';
            $stmt2 = $conexaoPDO -> prepare($sql2);
            $stmt2 -> execute(array(
                ':Pessoa_codigoPessoa' => $Pessoa_codigoPessoa,
                ':nomeDoPai' => $nomeDoPai, 
                ':nomeDaMae' => $nomeDaMae,
            ));

            // Codigo de inserção de informação na tabela contactos
            $sql3 = 'INSERT INTO contactos(Pessoa_codigoPessoa, telefone1, telefone2, email) VALUES (:Pessoa_codigoPessoa, :telefone1, :telefone2, :email)';
            $stmt3 = $conexaoPDO -> prepare($sql3);
            $stmt3 -> execute(array(
                ':Pessoa_codigoPessoa' => $Pessoa_codigoPessoa,
                ':telefone1' => $telefone1, 
                ':telefone2' => $telefone2,
                ':email' => $email,
            ));

            // Codigo de inserção de informação na tabela endereço
            $sql4 = 'INSERT INTO endereco(Pessoa_codigoPessoa, provincia, municipio, bairro, rua, numeroDeCasa) VALUES (:Pessoa_codigoPessoa, :provincia, :municipio, :bairro, :rua, :numeroDeCasa)';
            $stmt4 = $conexaoPDO -> prepare($sql4);
            $stmt4 -> execute(array(
                ':Pessoa_codigoPessoa' => $Pessoa_codigoPessoa,
                ':provincia' => $provincia, 
                ':municipio' => $municipio,
                ':bairro' => $bairro,
                ':rua' => $rua,
                ':numeroDeCasa' => $numeroDeCasa,
            ));

            echo"<script language='javascript' type='text/javascript'> 
                   
                    window.location .href='contas2.html';
                </script>"; die(); 
        }
        else
        {
            // Senao coincidirem ela volta para página contas.html 
            echo"<script language='javascript' type='text/javascript'> 
            alert('As senhas não coicidem.');
            window.location .href='contas.html';
            </script>"; die(); 
        }
    }
    catch(PDOException $e) 
    {
        echo 'Error: ' . $e->getMessage();
    }  
    
    function criptografar($texto)
    {
        return sha1(md5($texto));
    }
?>
