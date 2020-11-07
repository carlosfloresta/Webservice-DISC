<?php
    header('Content-Type: application/json charset=utf-8');
    
     $response = array();
    $response["erro"] = true;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    
    include 'conexao.php';
    mysqli_set_charset($conn,"utf8");
   
    $nome_usuario = mysqli_real_escape_string($conn, $_POST['nome']);
    $email_usuario = mysqli_real_escape_string($conn,$_POST['email']);
    $cnpj_usuario = mysqli_real_escape_string($conn,$_POST['cnpj']);
    $senha_usuario = mysqli_real_escape_string($conn, $_POST['senha']);
    $telefone_usuario = mysqli_real_escape_string($conn,$_POST['telefone']);
    
     $codigo_acesso = mysqli_real_escape_string($conn,$_POST['codigo_acesso']);
   
   $senha_usuario = md5($senha_usuario);
   
    $pegaEmail = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email_usuario'");
$resultado2 = mysqli_fetch_assoc($pegaEmail);

if (isset($resultado2)) {

    $nivel = $resultado2['nivel'];

    if ($nivel === '2') {
        $response["mensagem"] = "Erro ao fazer cadastro, este email já está cadastrado no sistema!";
    } else if ($nivel === '1') {

      $response["mensagem"] = "Erro ao fazer cadastro, este email já está cadastrado no sistema como candidato";
    }
} else {
    
    
    $pegaCpf = mysqli_query($conn, "SELECT * FROM rh WHERE cnpj = '$cnpj_usuario'");
    $resultado3 = mysqli_fetch_assoc($pegaCpf);


    if (isset($resultado3)) {

        $response["mensagem"] = "Erro ao fazer cadastro, este CPF/CNPJ já está cadastrado no sistema!";
    } else {
        
         $codigo = mysqli_query($conn, "SELECT * FROM rh WHERE codigo_acesso = '$codigo_acesso'");
    $resultado4 = mysqli_fetch_assoc($codigo);
    
    if (isset($resultado4)) {
            
         $response["mensagem"] = "O código de acesso digitado já existe em nosso sistema, por favor escolha outro!";
    
      
    } else {
    
    
    $result_login = "INSERT INTO login(email, senha, nivel) values('$email_usuario', '$senha_usuario', '2')";
   $resultado_login = mysqli_query($conn, $result_login);
    
 
  
 $id = $conn->insert_id;
    
    $result_usuario = "INSERT INTO rh (nome, telefone, cnpj,  email, senha, nivel, id_login, codigo_acesso) VALUES ('$nome_usuario','$telefone_usuario','$cnpj_usuario','$email_usuario','$senha_usuario','2','$id','$codigo_acesso')";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    
    if(mysqli_affected_rows($conn) != 0){
 
            $response["erro"] = false;
            $response["usuarioId"] = $id ;
            $response["usuarioEmail"] = $email_usuario ;
            $response["perfil"] = "2" ;
        
        
            }else{
                $response["mensagem"] = "Erro ao fazer cadastro";  
                
            }
            
    }
}
}
        
   $conn->close();
    
    }
    echo json_encode($response);
