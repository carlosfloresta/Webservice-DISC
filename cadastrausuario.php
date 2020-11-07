<?php
header('Content-Type: application/json charset=utf-8');

$response = array();
$response["erro"] = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    include 'conexao.php';
    mysqli_set_charset($conn, "utf8");

    $nome_usuario = mysqli_real_escape_string($conn, $_POST['nome']);
    $email_usuario = mysqli_real_escape_string($conn, $_POST['email']);
    $cnpj_usuario = mysqli_real_escape_string($conn, $_POST['cpf']);
    $senha_usuario = mysqli_real_escape_string($conn, $_POST['senha']);
    $tel = mysqli_real_escape_string($conn, $_POST['telefone']);


    $telefone = str_replace("(", "", $tel);
    $telefone2 = str_replace(")", "", $telefone);

    $telefone_usuario = str_replace("-", "", $telefone2);

    $codigo_rh = mysqli_real_escape_string($conn, $_POST['codigo_acesso_rh']);
    $senha_usuario = md5($senha_usuario);


    $pegaEmail = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email_usuario'");
    $resultado2 = mysqli_fetch_assoc($pegaEmail);

    if (isset($resultado2)) {

        $nivel = $resultado2['nivel'];

        if ($nivel === '1') {
            $response["mensagem"] = "Erro ao fazer cadastro, este email já está cadastrado no sistema!";
        } else if ($nivel === '2') {

            $response["mensagem"] = "Erro ao fazer cadastro, este email já está cadastrado no sistema como RH/Psicologo!";
        }
    } else {
        $response["erro"] = false;
        $pegaCpf = mysqli_query($conn, "SELECT * FROM usuario WHERE cpf = '$cnpj_usuario'");
        $resultado3 = mysqli_fetch_assoc($pegaCpf);


        if (isset($resultado3)) {
            $response["erro"] = true;
            $response["mensagem"] = "Erro ao fazer cadastro, este CPF já está cadastrado no sistema!";
        } else {

            $response["erro"] = false;

            $pegaCodigo = mysqli_query($conn, "SELECT * FROM rh WHERE codigo_acesso = '$codigo_rh'");
            $resultado4 = mysqli_fetch_assoc($pegaCodigo);



            if (isset($resultado4)) {

                $response["erro"] = false;
                $empresa_usuario = $resultado4["id"];
                $response["nomeempresa"] = $resultado4["nome"];


                $result_login = "INSERT INTO login(email, senha, nivel) values('$email_usuario', '$senha_usuario', '1')";
                $resultado_login = mysqli_query($conn, $result_login);



                $id = $conn->insert_id;

                $result_usuario = "INSERT INTO usuario (nome, telefone, cpf,  email, senha, nivel, id_login, id_empresa) VALUES ('$nome_usuario','$telefone_usuario','$cnpj_usuario','$email_usuario','$senha_usuario','1','$id', '$empresa_usuario')";
                $resultado_usuario = mysqli_query($conn, $result_usuario);

                if (mysqli_affected_rows($conn) != 0) {

                    $response["erro"] = false;
                    $response["usuarioId"] = $id;
                    $response["usuarioEmail"] = $email_usuario;
                    $response["perfil"] = "1";
                } else {
                    $response["erro"] = true;
                    $response["mensagem"] = "Erro ao fazer cadastro";
                }
            } else {
                $response["erro"] = true;
                $response["mensagem"] = "Código digitado de RH/Psicólogo não existe em nosso sistema!";
            }
        }
    }

    $conn->close();
}
echo json_encode($response);
