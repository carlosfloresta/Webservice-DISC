<?php

//constantes
$databaseHost = 'localhost';
$databaseName = ''; 
$databaseUsername = '';
$databasePassword = '';

    $conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
//        echo "Conexao realizada com sucesso";
    }
