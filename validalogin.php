<?php
header('Content-Type: application/json charset=utf-8');
   
    
    $response = array();
    $response["erro"] = true;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         

    include 'conexao.php';
   
    mysqli_set_charset($conn,"utf8");
    
   
        $usuario = mysqli_real_escape_string($conn, $_POST['login']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
        $senha = mysqli_real_escape_string($conn,$_POST['senha']);
      $senha = md5($senha);

        $result_usuario = "SELECT * FROM login WHERE email = '$usuario' AND senha = '$senha'";
        $result = $conn->query($result_usuario);
        
        $ses_sql = mysqli_query($conn,"select nome from usuario INNER JOIN login ON login.id = usuario.id_login where login.email = '$usuario' ");
         $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
         
          $sql2 = mysqli_query($conn, "SELECT rh.nome FROM rh INNER JOIN usuario ON usuario.id_empresa = rh.id where usuario.email = '$usuario' ");
        $resultado2 = mysqli_fetch_array($sql2);

        if($result->num_rows>0){
            
            $registro = mysqli_fetch_array($result);
            $response["registros"] = $result->num_rows;
            $response["erro"] = false;
            $response["login"] = $registro['email'] ;
            $response["senha"] = $registro['senha'] ;
            $response["perfil"] = $registro['nivel'] ;
            $response["idempresa"] = $registro['id_empresa'] ;
            $response["nome"]= $row['nome'];
            $response["nomeempresa"]= $resultado2['nome'];
            

            
        }else{
      
            $response["mensagem"] = "Usuário não existe";
        }
   
    
    
    $conn->close();
    
    }
    echo json_encode($response);
?>