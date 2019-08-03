<?php

header('Content-Type: application/json charset=utf-8');
    
     $emparray = array();

        include 'conexao.php';
        mysqli_set_charset($conn,"utf8");
      
        $sql  = mysqli_query($conn, "select id,nome from rh");
        
        if($sql->num_rows>0){
       
while ($row = mysqli_fetch_assoc($sql)) {
$emparray[] = $row;
}

        }else{
      
            $response["mensagem"] = "Erro nada encontrado";
        }

   $conn->close();
    
    
   echo json_encode(array( 'status' => 'true','message' => 'Data fetched successfully!','data' => $emparray) );

?>

