<?php
header('Content-Type: application/json charset=utf-8');
$response = array();
$response["erro"] = true;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     include 'conexao.php';

     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $sql = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
     $resultado_sql = mysqli_fetch_assoc($sql);

     if ($resultado_sql) {

          $token = md5(uniqid(rand(), true));
          $sql2 = mysqli_query($conn, "UPDATE login SET token = '$token' WHERE email = '$email'");

          if (mysqli_affected_rows($conn) > 0) {
               $response["erro"] = false;
               $arquivo = "
 
    <html>
    
          <h2>Recuperação de Senha - DISC</h2>
              <h3>Por favor clique no botão para alterar a senha ou copie o link abaixo:</h3>
             
             <a href='https://your site/alterasenha.php?token=$token'>Resetar Senha<a/>
               <h4>https://your site/alterasenha.php?token=$token</h4>   

    </html>
  ";

               $assunto = "Recuperação de Senha - DISC";
               $headers  = 'MIME-Version: 1.0' . "\r\n";
               $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
               $headers .= 'From: DISC<contato@disc.cf>';

               $enviaremail = mail($email, $assunto, $arquivo, $headers);
               if ($enviaremail) {

                    $response["mensagem"] = "Link para alterar senha enviado com sucesso!";
               } else {
                    $response["mensagem"] = "Erro ao enviar email, tente novamente!";
               }
          } else {
               $response["erro"] = true;
               $response["mensagem"] = "Erro ao gerar token para alterar senha, tente novamente!";
          }
     } else {

          $response["erro"] = true;
          $response["mensagem"] = "Email não encontrado em nossos registros!";
     }

     $conn->close();
}


echo json_encode($response);
