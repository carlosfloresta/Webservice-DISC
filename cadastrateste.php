<?php

header('Content-Type: application/json charset=utf-8');

$response = array();
$response["erro"] = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexao.php';
    include 'email.php';
    mysqli_set_charset($conn, "utf8");


    $d = mysqli_real_escape_string($conn, $_POST['d']);
    $i = mysqli_real_escape_string($conn, $_POST['i']);
    $s = mysqli_real_escape_string($conn, $_POST['s']);
    $c = mysqli_real_escape_string($conn, $_POST['c']);


    $email = mysqli_real_escape_string($conn, $_POST['email']);


    // maior
    if ($d > $i && $d > $s && $d > $c) {

        $maior = 'Dominante <br> São pessoas que possuem mais facilidade em lidar com desafios, pois são determinadas, exigentes, ousadas e assertivas. Por outro lado, essas pessoas não são muito atenciosas com os sentimentos e necessidades dos outros, podendo se tornar egoístas.';
        $corfundo = '#F32D2D';
    } else if ($i > $s && $i > $c) {

        $maior = 'Influente <br> São pessoas mais emocionais e que possuem grande habilidade em influenciar pessoas. São animadas, entusiasmadas, extrovertidas e motivadoras. Sabem persuadir, se comunicar e manter o otimismo. Entretanto, essas pessoas constantemente iniciam projetos e não os terminam, e seu entusiasmo pode parecer superficialidade para os outros.';
        $corfundo = '#49A55E';
    } else if ($s > $c) {
        $maior = 'Estável <br> São pessoas que lidam melhor com rotinas e padrões. São paciêncientes, tranquilas, confiáveis, leais, persistentes e gentis. Por outro lado, a estabilidade muitas vezes é acompanhada pelo medo das mudanças e uma grande falta de iniciativa. Pessoas com essa tendência de comportamento possuem dificuldade em lidar com conflitos.';
        $corfundo = '#667FCE';
    } else {

        $maior = 'Cauteloso<br>São pessoas que possuem uma maior facilidade em lidar com regras e processos. São metódicas, analíticas, técnicas e determinadas. Elas seguem ordens e normas, e realizam suas tarefas com um cuidado exemplar. Por serem muito perfeccionistas, tendem a se perder em detalhes e são extremamente críticas — tanto com elas mesmas, quanto com as outras pessoas.';
        $corfundo = '#F9BF3B';
    }


//               segundo maior
    if (($d <= $i && $d >= $s && $d >= $c) || ($d >= $i && $d <= $s && $d >= $c) || ($d >= $i && $d >= $s && $d <= $c)) {

        $maior2 = 'Dominante <br> São pessoas que possuem mais facilidade em lidar com desafios, pois são determinadas, exigentes, ousadas e assertivas. Por outro lado, essas pessoas não são muito atenciosas com os sentimentos e necessidades dos outros, podendo se tornar egoístas.';
        $corfundo2 = '#F32D2D';
    } else if (($i <= $s && $i >= $d && $i >= $c) || ($i >= $s && $i <= $d && $i >= $c) || ($i >= $s && $i >= $d && $i <= $c)) {

        $maior2 = 'Influente <br> São pessoas mais emocionais e que possuem grande habilidade em influenciar pessoas. São animadas, entusiasmadas, extrovertidas e motivadoras. Sabem persuadir, se comunicar e manter o otimismo. Entretanto, essas pessoas constantemente iniciam projetos e não os terminam, e seu entusiasmo pode parecer superficialidade para os outros.';
        $corfundo2 = '#49A55E';
    } else if (($s <= $i && $s >= $d && $s >= $c) || ($s >= $i && $s <= $d && $s >= $c) || ($s >= $i && $s >= $d && $s <= $c)) {

        $maior2 = 'Estável <br> São pessoas que lidam melhor com rotinas e padrões. São paciêncientes, tranquilas, confiáveis, leais, persistentes e gentis. Por outro lado, a estabilidade muitas vezes é acompanhada pelo medo das mudanças e uma grande falta de iniciativa. Pessoas com essa tendência de comportamento possuem dificuldade em lidar com conflitos.';
        $corfundo2 = '#667FCE';
    } else {
        $maior2 = 'Cauteloso<br>São pessoas que possuem uma maior facilidade em lidar com regras e processos. São metódicas, analíticas, técnicas e determinadas. Elas seguem ordens e normas, e realizam suas tarefas com um cuidado exemplar. Por serem muito perfeccionistas, tendem a se perder em detalhes e são extremamente críticas — tanto com elas mesmas, quanto com as outras pessoas.';
        $corfundo2 = '#F9BF3B';
    }


    $sql2 = mysqli_query($conn, "SELECT usuario.nome, usuario.email, usuario.id, usuario.id_empresa FROM usuario INNER JOIN login ON usuario.id_login = login.id where usuario.email = '$email' ");
    $resultado2 = mysqli_fetch_array($sql2);

    $id_usuario = $resultado2['id'];
    $id_empresa = $resultado2['id_empresa'];
    $email_usuario = $resultado2['email'];
    $nome_usuario = $resultado2['nome'];
    $telefone_usuario = $resultado2['telefone'];


    if ($resultado2) {
        $response["erro"] = false;
        
        $pegaEmail = mysqli_query($conn, "SELECT * FROM teste WHERE id_usuario = '$id_usuario' AND id_empresa = '$id_empresa'");
$resultado4 = mysqli_fetch_assoc($pegaEmail);

    if (isset($resultado4)) {
            $response["erro"] = true;

               $response["mensagem"] = "Erro! Você já enviou o teste para essa empresa";

    } else {

        $result_login = "INSERT INTO teste(d, i, s, c, id_usuario, id_empresa) values('$d', '$i', '$s', '$c','$id_usuario','$id_empresa')";
        $cadastra_teste = mysqli_query($conn, $result_login);

        if ($cadastra_teste) {
            $response["erro"] = false;

            $sql3 = mysqli_query($conn, "SELECT * FROM rh where id = '$id_empresa' ");
            $resultado3 = mysqli_fetch_array($sql3);
            $email_empresa = $resultado3['email'];

            email($maior, $email_empresa, $telefone_usuario, $nome_usuario, $email_usuario, $maior2, $corfundo, $corfundo2, $d, $i, $s, $c);
        } else {
            $response["erro"] = true;
            $response["mensagem"] = "Não foi possivel o envio do teste, verifique a conexão com a internet e tente novamente!";
        }
    }
    } else {

        $response["erro"] = true;
        $response["mensagem"] = "Erro! Não foi possivel buscar seus dados para efetuar o envio do teste";
    }



    $conn->close();
}


echo json_encode($response);
