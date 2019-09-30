<?php

require_once __DIR__ . '/vendor/autoload.php';
    
$pagina = 
    "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Dados do Cliente</title>
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
    $mpdf -> Output($arquivo, 'I');

 

        
        
?>