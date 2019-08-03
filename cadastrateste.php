<?php
   header('Content-Type: application/json charset=utf-8');
   
    $response = array();
    $response["erro"] = true;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include 'conexao.php';
    mysqli_set_charset($conn,"utf8"); 
        
        
    $d = mysqli_real_escape_string($conn, $_POST['d']);
    $i = mysqli_real_escape_string($conn,$_POST['i']);
    $s = mysqli_real_escape_string($conn,$_POST['s']);
    $c = mysqli_real_escape_string($conn, $_POST['c']);
    
   
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
 
    $sql2 = mysqli_query($conn, "SELECT usuario.nome, usuario.email, usuario.id, usuario.id_empresa FROM usuario INNER JOIN login ON usuario.id_login = login.id where usuario.email = '$email' ");
        $resultado2 = mysqli_fetch_array($sql2);
        
        $id_usuario = $resultado2['id'];
        $id_empresa = $resultado2['id_empresa'];
        $email_usuario = $resultado2['email'];
        $nome_usuario = $resultado2['nome'];
    
    
    $result_login = "INSERT INTO teste(d, i, s, c, id_usuario, id_empresa) values('$d', '$i', '$s', '$c','$id_usuario','$id_empresa')";
   $resultado_login = mysqli_query($conn, $result_login);
    
   $sql3 = mysqli_query($conn, "SELECT * FROM rh where id = '$id_empresa' ");
        $resultado3 = mysqli_fetch_array($sql3);
  
    
    if(mysqli_affected_rows($conn) != 0){
              
     
        $response["erro"] = false;
        
        $email_empresa = $resultado3['email'];
              
            
    
          $mensagem = "Teste Feito por: nome: $nome_usuario \n Email: $email_usuario \n Dominancia: '$d',Influencia: '$i' ,Estabilidade: '$s' ,Cautela: '$c'";
            
            
       $from = $email_usuario;

$to = $email_empresa;

$subject = "Teste Disc";

$message = $mensagem;

$headers = "De:". $from;

mail($to, $subject, $message, $headers);
        
        
        
            }else{
                 $response["mensagem"] = "Erro para enviar teste";     
                
            }
            
        $conn->close();      
        
    }


       echo json_encode($response);
            
?>


