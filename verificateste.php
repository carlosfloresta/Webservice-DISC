<?php

header('Content-Type: application/json charset=utf-8');
   $response = array();
    $response["erro"] = true;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
     include 'conexao.php';
   
   
   
 $email = mysqli_real_escape_string($conn,$_POST['email']);
   $sql2 = mysqli_query($conn, "SELECT usuario.id, usuario.id_empresa FROM usuario INNER JOIN login ON usuario.id_login = login.id where usuario.email = '$email' ");
        $resultado2 = mysqli_fetch_array($sql2);
         $id_usuario = $resultado2['id'];
          $id_empresa = $resultado2['id_empresa'];
   
   
   $teste = mysqli_query($conn,"SELECT * FROM teste where id_usuario = '$id_usuario' AND id_empresa = '$id_empresa' ");
    $resultado3 = mysqli_fetch_array($teste);
 
    

    if(mysqli_affected_rows($conn) != 0){
        
              
    
        $response["erro"] = false;
        
        
            }else{
               $response["mensagem"] = "Erro ao alterar empresa";
              
                
            }
             $conn->close();
    } 
    
     echo json_encode($response);
            
?>

