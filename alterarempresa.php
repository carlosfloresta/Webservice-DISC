<?php
header('Content-Type: application/json charset=utf-8');
 $response = array();
 $response["erro"] = true;
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
       include 'conexao.php';
   
    $codigo_rh = mysqli_real_escape_string($conn,$_POST['codigo_acesso']);
    
     $email = mysqli_real_escape_string($conn,$_POST['email']);
     
    $pegaCodigo = mysqli_query($conn, "SELECT * FROM rh WHERE codigo_acesso = '$codigo_rh'");
    $resultado4 = mysqli_fetch_assoc($pegaCodigo);
     if (isset($resultado4)) {
    $empresa_usuario = $resultado4["id"];
    $response["nomeempresa"] = $resultado4["nome"];
    $result_login = "UPDATE usuario SET id_empresa = '$empresa_usuario' where email = '$email' ";
   $resultado_login = mysqli_query($conn, $result_login);
    
 
    
    if(mysqli_affected_rows($conn) != 0){
              
    
       $response["erro"] = false;
        
        
            }else{
               $response["mensagem"] = "Erro ao alterar RH/Psicologo(a)";
              
                
            }
            
     }else{
         
         
           $response["erro"] = true;
             $response["mensagem"] = "Código digitado de RH/Psicólogo não existe em nosso sistema!"; 
     }
            
              $conn->close();
            
          
 }
 
 echo json_encode($response);
