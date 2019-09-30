<?php
     header("Content-Type: text/html; charset=utf-8", TRUE); // Codigo para aceitaçao de caracteres acentuados
     include_once("coneccao.php"); // Função que chama a nossa conecção com a base de dados
     $conexaoPDO->beginTransaction(); // There is no active transaction

     $levantar = filter_input(INPUT_POST, 'levantar', FILTER_SANITIZE_STRING);

     if($levantar)
     {
        $identificacao = isset($_POST['identificacao']) ? $_POST['identificacao']:0;
        $numeroDeConta = isset($_POST['numeroDeConta']) ? $_POST['numeroDeConta']:0;
        $valorLevantar = isset($_POST['valorLevantar']) ? $_POST['valorLevantar']:0; 
        $pin = isset($_POST['pin']) ? $_POST['pin']:0;
        $resultado = 0;
        $dataHoraSistema = date('Y-m-d H:i:s');

        include("coneccao.php"); // Função que chama a nossa conecção com a base de dados

        $sql = "SELECT * FROM pessoa WHERE identificacao = '$identificacao'";
        
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
            $codigoPessoa = $valores[0];
            $nome = $valores[1];
            $identificacaoSistema = $valores[3];
        }

        if($resultado != null)
        {

            if($identificacao == $identificacaoSistema)
            {
                $sql = 'SELECT * FROM cartaobanco WHERE Pessoa_codigoPessoa = '.$codigoPessoa;
                
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
                    $numeroDeContaSistema = $valores[4];
                    $valorNaContaSistema = $valores[6];
                    $pinSistema = $valores[8];
                }

                if(($numeroDeConta == $numeroDeContaSistema) && ($pin == $pinSistema))
                {
                    if($valorLevantar <= $valorNaContaSistema)
                    {
                        $conexaoPDO->beginTransaction(); // There is no active transaction

                        $valorNovoDaConta = $valorNaContaSistema - $valorLevantar;
                        $sql = 'UPDATE cartaobanco set valorNaConta = ? WHERE Pessoa_codigoPessoa = ?';
            
                        $pstmt = $conexaoPDO->prepare($sql);
                        $pstmt->bindParam(1, $valorNovoDaConta);
                        $pstmt->bindParam(2, $codigoPessoa);
                        
                        $pstmt->execute();
                        $conexaoPDO->commit();

                        require_once __DIR__ . '/vendor/autoload.php';

                        $pagina = 
                            "<!DOCTYPE html>
                            <html lang='pt-BR'>
                                <head>
                                    <meta charset='UTF-8'>
                                    <link rel='stylesheet' href='_css/styleParaPDF.css'>
                                    <title>Dados do Levantamento</title>
                                </head>
                                <body>
                                    <h1>Banco BIC - <span>Levantamento</span></h1>  
                                    <br><br>
                                    <img src='_galeria/_imagens/bic_logo_1.png' alt='Logottipo do BIC' div='logo' width='150' height='150'>
                                        <ul>
                                            <li><span>Nome:</span> $nome</li>
                                            <li><span>Número de Conta:</span> $numeroDeConta</li>
                                            <li><span>Valor Antigo:</span> $valorNaContaSistema AKZ</li>
                                            <li><span>Valor Levantado:</span> $valorLevantar AKZ</li>
                                            <li><span>Valor total na Conta :</span> $valorNovoDaConta AKZ</li>
                                        </ul>
                                        
                                        <div id='valores'>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    $valorNaContaSistema AKZ<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - $valorLevantar       AKZ<br>
                                            ________________________<br>
                        valor total:        $valorNovoDaConta    AKZ<br>
                        <br><br>
                        Data e Hora: $dataHoraSistema <br>
                                        </div>

                                    <footer id='rodape'>
                                        <p><span>Localização da Sede:</span> Benfica, Autodrómo, Rua das Aves, Travessa do Kuito.</p>
                                        <p>Banco Banco Internacional de Crédito(BIC)</p>
                                        <p>Todos os direitos reservados <br> Copyright &copy; 2019 - by <a href='http://127.0.0.1/banco-emis'>Banco EMIS</a></p>
                                    </footer>
                                </body>
                            </html>";
            
                            $arquivo = "levantar01.pdf";
                            $mpdf = new \Mpdf\Mpdf();
                            
                            $mpdf -> WriteHtml($pagina);
                            $mpdf -> Output($arquivo, 'I');
            
                    }
                }
            }
        }



     }
     else
     {

     }
?>