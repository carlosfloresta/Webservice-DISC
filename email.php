<?php

function email($maior, $email, $telefone, $nome, $emailCandidato, $segundoMaior, $corfundo, $corfundo2, $d, $i, $s, $c)
{
  // Compo E-mail
  $arquivo = "
 
    <html>
    
          <h2>Nome: $nome</h2>
              <h4>Email: $emailCandidato</h4>
              <h4>Telefone: $telefone</h4>
             
             <h3>Este candidato é mais...</h3>
             
             <div style='background-color: $corfundo;  font-size: 20px; color: #fff; padding: 10px;'>
             
      
            <p>$maior</p><br>
            
          
            
             </div>
             
                <h3>Com ascendente em...</h3>
            <div style='background-color: $corfundo2;  font-size: 20px; color: #fff; padding: 10px;'>
             
      
            <p>$segundoMaior</p><br>
            
          
            
             </div>    
             
               <img style='width:100%' src='https://your site/funcoes/grafico.php?d=$d&i=$i&s=$s&c=$c'>
       
    </html>
  ";

  //enviar

  // emails para quem será enviado o formulário
  $emailenviar = $email;
  $destino = $emailenviar;
  $assunto = "Teste DISC";

  // É necessário indicar que o formato do e-mail é html
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From:' . $nome . '<' . $emailCandidato . '>';
  //$headers .= "Bcc: $EmailPadrao\r\n";

  mail($destino, $assunto, $arquivo, $headers);
}
