<?php

 header('Content-Type: application/json charset=utf-8');

 $response = array();
$response["erro"] = true;

 if($_SERVER['REQUEST_METHOD'] == 'POST'){

 include 'conexao.php';
 include 'email.php';
 mysqli_set_charset($conn,"utf8");
 
  $id_candidato = mysqli_real_escape_string($conn, $_POST['id_candidato']); 
  $id_empresa = mysqli_real_escape_string($conn, $_POST['id_empresa']); 
  $flag = mysqli_real_escape_string($conn, $_POST['flag']); 
  $email = mysqli_real_escape_string($conn, $_POST['email']); 
 
   $sql3 = mysqli_query($conn, "SELECT usuario.*,usuario.id AS id_usuario, teste.* FROM usuario INNER JOIN teste ON usuario.id = teste.id_usuario INNER JOIN rh ON teste.id_empresa = rh.id where usuario.id = '$id_candidato' and rh.id_login = '$id_empresa' ORDER BY usuario.id DESC  ");
                 $resultado = mysqli_fetch_assoc($sql3);
                
            if (isset($resultado)) { 
                
                 $response["erro"] = false;
                 
                 $response["nome_candidato"]=$resultado["nome"];
                  $response["telefone_candidato"]=$resultado["telefone"];
                   $response["email_candidato"]=$resultado["email"];
                 
                 $d = $resultado['d'];
                 $i = $resultado['i'];
                 $s = $resultado['s'];
                 $c = $resultado['c'];
                 
                 $response["d"]=$d;
                 $response["i"]=$i;
                 $response["s"]=$s;
                 $response["c"]=$c;
                 
//                 maior
                 if($d>$i && $d>$s && $d>$c ){    

             $response["mensagemMaior"] = 'Dominante \n São pessoas que possuem mais facilidade em lidar com desafios, pois são determinadas, exigentes, ousadas e assertivas. Por outro lado, essas pessoas não são muito atenciosas com os sentimentos e necessidades dos outros, podendo se tornar egoístas.';
              $response["corMaior"]= 'F32D2D';
               
                 }else if($i>$s && $i>$c){  
                    
          $response["mensagemMaior"] ='Influente \n São pessoas mais emocionais e que possuem grande habilidade em influenciar pessoas. São animadas, entusiasmadas, extrovertidas e motivadoras. Sabem persuadir, se comunicar e manter o otimismo. Entretanto, essas pessoas constantemente iniciam projetos e não os terminam, e seu entusiasmo pode parecer superficialidade para os outros.';
            $response["corMaior"]=  '49A55E';
           }else if($s>$c){
            $response["mensagemMaior"] ='Estável \n São pessoas que lidam melhor com rotinas e padrões. São paciêncientes, tranquilas, confiáveis, leais, persistentes e gentis. Por outro lado, a estabilidade muitas vezes é acompanhada pelo medo das mudanças e uma grande falta de iniciativa. Pessoas com essa tendência de comportamento possuem dificuldade em lidar com conflitos.';
           $response["corMaior"]= '667FCE';
            }else{ 
            
           $response["mensagemMaior"] ='Cauteloso \n São pessoas que possuem uma maior facilidade em lidar com regras e processos. São metódicas, analíticas, técnicas e determinadas. Elas seguem ordens e normas, e realizam suas tarefas com um cuidado exemplar. Por serem muito perfeccionistas, tendem a se perder em detalhes e são extremamente críticas — tanto com elas mesmas, quanto com as outras pessoas.';
            $response["corMaior"]= 'F9BF3B';
           }
           
           
//               segundo maior
              if(($d<=$i && $d>=$s && $d>=$c)||($d>=$i && $d<=$s && $d>=$c) || ($d>=$i && $d>=$s && $d<=$c)){
               
             $response["mensagemSegMaior"]= 'Dominante <br> São pessoas que possuem mais facilidade em lidar com desafios, pois são determinadas, exigentes, ousadas e assertivas. Por outro lado, essas pessoas não são muito atenciosas com os sentimentos e necessidades dos outros, podendo se tornar egoístas.';
             $response["corSegMaior"] = 'F32D2D';
               
           }else if(($i<=$s && $i>=$d && $i>=$c) || ($i>=$s && $i<=$d && $i>=$c) || ($i>=$s && $i>=$d && $i<=$c)){
               
             $response["mensagemSegMaior"] ='Influente /n São pessoas mais emocionais e que possuem grande habilidade em influenciar pessoas. São animadas, entusiasmadas, extrovertidas e motivadoras. Sabem persuadir, se comunicar e manter o otimismo. Entretanto, essas pessoas constantemente iniciam projetos e não os terminam, e seu entusiasmo pode parecer superficialidade para os outros.';
            $response["corSegMaior"] = '49A55E';
               
           }else if(($s<=$i && $s>=$d && $s>=$c) || ($s>=$i && $s<=$d && $s>=$c) || ($s>=$i && $s>=$d && $s<=$c)){
               
               $response["mensagemSegMaior"] ='Estável <br> São pessoas que lidam melhor com rotinas e padrões. São paciêncientes, tranquilas, confiáveis, leais, persistentes e gentis. Por outro lado, a estabilidade muitas vezes é acompanhada pelo medo das mudanças e uma grande falta de iniciativa. Pessoas com essa tendência de comportamento possuem dificuldade em lidar com conflitos.';
              $response["corSegMaior"] = '667FCE';
           }else{    
                           $response["mensagemSegMaior"] ='Cauteloso<br>São pessoas que possuem uma maior facilidade em lidar com regras e processos. São metódicas, analíticas, técnicas e determinadas. Elas seguem ordens e normas, e realizam suas tarefas com um cuidado exemplar. Por serem muito perfeccionistas, tendem a se perder em detalhes e são extremamente críticas — tanto com elas mesmas, quanto com as outras pessoas.';
                          $response["corSegMaior"] = 'F9BF3B';
           }    
 
           if($flag=='2'){
               
               $cor1 = "#";
               $cor1.= $response["corMaior"];
               $cor2 ="#";
               $cor2 .= $response["corSegMaior"];
               
               email($response["mensagemMaior"], $email, $response["telefone_candidato"], $response["nome_candidato"], $response["email_candidato"],$response["mensagemSegMaior"],$cor1, $cor2, $d, $i, $s, $c);

           }else if($flag =='3'){
               
               $id_usuario = $resultado["id_usuario"];
               
                $sql2     = "delete from teste where id_usuario='$id_usuario'";
                $executa = mysqli_query($conn,$sql2);

                if(!$executa){
                   $response["erro"] = true;
                   $response["mensagem"] = "Erro ao tentar excluir";
                }
           }
 
            }else{
                 $response["mensagem"] = "Erro ao buscar Teste do candidato";
            }
 
   $conn->close();
 
 }

echo json_encode($response);
