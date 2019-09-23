<?php

require_once __DIR__ . '/vendor/autoload.php';

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
            <h1>Lista de Candidatos<h1/>
            <ul>
                <li>Emanuel Cândido</li>
                <li>Aldair Lopes</li>
                <li>Júnior Lopes</li>
            </ul>
            <h4>http://www.emis.co.ao<h4>
        </body>
        </html>";

        $arquivo = "cadastar01.pdf";
        $mpdf = new \Mpdf\Mpdf();
        
        $mpdf -> WriteHtml($pagina);
        $mpdf -> Output($arquivo, 'I');

 

        
        
?>