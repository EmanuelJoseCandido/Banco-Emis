<?php
    header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
    include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
    $conexaoPDO->beginTransaction(); // There is no active transaction

    $depositar = filter_input(INPUT_POST, 'depositar', FILTER_SANITIZE_STRING);

    if($depositar)
    {

        $numeroDeConta = isset($_POST['numeroDeConta']) ? $_POST['numeroDeConta']:0;
        $valorMonetario = isset($_POST['valorMonetario']) ? $_POST['valorMonetario']:0;
        $nome = pegarNome();
        date_default_timezone_set("Africa/Luanda");
        $dataHoraSistema = date('Y-m-d H:i:s');

        if($valorMonetario >= 1000)
        {
            include("coneccao.php"); // Função que chama a nossa conecção com a base de dados

            $sql = 'SELECT * FROM cartaobanco WHERE numeroDeConta = '.$numeroDeConta;
            
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
                $valorActualizado = $valores[6];
                $numeroDeConta = $valores[4];
            }

            $valorActualizado += $valorMonetario;

            $conexaoPDO->beginTransaction(); // There is no active transaction

            $sql = 'UPDATE cartaobanco set valorNaConta = ?';
            
            $pstmt = $conexaoPDO->prepare($sql);
            $pstmt->bindParam(1, $valorActualizado);

            $pstmt->execute();
            $conexaoPDO->commit();

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
                    <h1>Banco BIC - <span>Deposito</span></h1>  
                    <br><br>
                    <img src='_galeria/_imagens/bic_logo_1.png' alt='Logottipo do BIC' div='logo' width='150' height='150'>
                    <div>
                        <ul>
                            <li><span>Nome:</span> $nome</li>
                            <li><span>Número de Conta:</span> $numeroDeConta</li>
                            <li><span>Valor depositado:</span> $valorMonetario AKZ</li>
                            <li><span>Data e Hora: </span> $dataHoraSistema </li>
                        </ul>
                    </div>
                    <footer id='rodape'>
                        <p><span>Localização da Sede:</span> Benfica, Autodrómo, Rua das Aves, Travessa do Kuito.</p>
                        <p>Banco Banco Internacional de Crédito(BIC)</p>
                        <p>Todos os direitos reservados <br> Copyright &copy; 2019 - by <a href='http://127.0.0.1/banco-emis'>Banco EMIS</a></p>
                        </footer>
                </body>
                </html>";

                $arquivo = "depositar01.pdf";
                $mpdf = new \Mpdf\Mpdf();
                
                $mpdf -> WriteHtml($pagina);
                $mpdf -> Output($arquivo, 'I');
        }       
        else
        {
            echo"<script language='javascript' type='text/javascript'> 
            alert('O valor a depositar tem que ser superior a 1000 AKZ');
            </script>"; die(); 
        }
    }

    function pegarNome()
    {
        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados
       
        $sql = "SELECT * FROM cartaobanco WHERE numeroDeConta = ".$GLOBALS['numeroDeConta'];
        
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
            $numeroDeConta = $valores[4];
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


?>