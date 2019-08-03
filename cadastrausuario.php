<?php
    header('Content-Type: application/json charset=utf-8');
    
     $response = array();
    $response["erro"] = true;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    
    include 'conexao.php';
    mysqli_set_charset($conn,"utf8");
   
    $nome_usuario = mysqli_real_escape_string($conn, $_POST['nome']);
    $email_usuario = mysqli_real_escape_string($conn,$_POST['email']);
    $cnpj_usuario = mysqli_real_escape_string($conn,$_POST['cpf']);
    $senha_usuario = mysqli_real_escape_string($conn, $_POST['senha']);
    $telefone_usuario = mysqli_real_escape_string($conn,$_POST['telefone']);
    $empresa_usuario = mysqli_real_escape_string($conn,$_POST['empresa']);
   $senha_usuario = md5($senha_usuario);
    
    
    $result_login = "INSERT INTO login(email, senha, nivel) values('$email_usuario', '$senha_usuario', '1')";
   $resultado_login = mysqli_query($conn, $result_login);
    
 
  
 $id = $conn->insert_id;
    
    $result_usuario = "INSERT INTO usuario (nome, telefone, cpf,  email, senha, nivel, id_login, id_empresa) VALUES ('$nome_usuario','$telefone_usuario','$cnpj_usuario','$email_usuario','$senha_usuario','1','$id', '$empresa_usuario')";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    
    if(mysqli_affected_rows($conn) != 0){
 
            $response["erro"] = false;
            $response["usuarioId"] = $id ;
            $response["usuarioEmail"] = $email_usuario ;
            $response["perfil"] = "1" ;
        
        
            }else{
                $response["mensagem"] = "Erro ao fazer cadastro";  
                
            }
        
   $conn->close();
    
    }
    echo json_encode($response);
            
?>

