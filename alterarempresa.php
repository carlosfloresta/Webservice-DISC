<?php
header('Content-Type: application/json charset=utf-8');
 $response = array();
 $response["erro"] = true;
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
       include 'conexao.php';
   
    $empresa_usuario = mysqli_real_escape_string($conn,$_POST['idempresa']);
    
     $email = mysqli_real_escape_string($conn,$_POST['email']);
 
   
  
    $result_login = "UPDATE usuario SET id_empresa = '$empresa_usuario' where email = '$email' ";
   $resultado_login = mysqli_query($conn, $result_login);
    
 
    
    if(mysqli_affected_rows($conn) != 0){
              
    
       $response["erro"] = false;
        
        
            }else{
               $response["mensagem"] = "Erro ao alterar empresa";
              
                
            }
            
              $conn->close();
            
          
 }
 
 echo json_encode($response);
        
            
?>
