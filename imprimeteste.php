<?php
$d = filter_input(INPUT_GET, 'd', FILTER_SANITIZE_STRING);
$i =  filter_input(INPUT_GET, 'i', FILTER_SANITIZE_STRING);
$s =  filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
$c =  filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_GET, 'telefone', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_STRING);
$maior = filter_input(INPUT_GET, 'maior', FILTER_SANITIZE_STRING);
$maiorCor = filter_input(INPUT_GET, 'maiorcor', FILTER_SANITIZE_STRING);
$maior2 = filter_input(INPUT_GET, 'segmaior', FILTER_SANITIZE_STRING);
$segMaiorCor = filter_input(INPUT_GET, 'segmaiorcor', FILTER_SANITIZE_STRING);

?>
<html>
<head>
    <style>
        h2 {

            font-size: 15px;

        }

        body {
            -webkit-print-color-adjust: exact;
            font-family: arial;

        }

        .estilo {


            font-size: 14px;
            color: #fff;
            padding: 10px;
        }

        .estilo2 {

            background-color: <?php echo $segMaiorCor ?>;
            font-size: 14px;
            color: #fff;
            padding: 10px;
        }
    </style>
</head>

<body onload="Javascript:window.print();">
    <div>
        <h2>Nome:<?php echo $nome ?></h2>
        <h2>Email:<?php echo $email ?></h2>
        <h2>Telefone/celular:<?php echo $telefone ?></h2>
        <h3>Este candidato é mais...</h3>
        <div class="estilo" style=" background-color: <?php echo $maiorCor ?>;">
            <p><?php echo $maior ?></p><br>
        </div>
        <h3>Com ascendente...</h3>
        <div class="estilo2">
            <p><?php echo $maior2 ?></p><br>
        </div>
        <br>
        <br>
        <img style="width:50%" src="https://your site/funcoes/grafico.php?d=<?php echo $d ?>&i=<?php echo $i ?>&s=<?php echo $s ?>&c=<?php echo $c ?>">
    </div>
</body>
</html>