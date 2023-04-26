<?php
    session_start();
    #error_reporting(E_ERROR | E_PARSE);
    $mysqli = new mysqli("banco", "user", "user", "controlefacil");
   

    $var_data = $_POST['dt_entrada'];
    //$var_data = DATE($var_data);
    $reme = $_POST['remedio'];
    $lot = $_POST['lote'];
    $dt_venc = $_POST['dt_venc'];
    $qtd = $_POST['qtd'];

    
    $sql = $mysqli->query("insert into medicamentos(nome, dt_vencimento, qtd, lote)
    VALUES('$reme','$dt_venc','$qtd', '$lot', '$var_data')");
    $id_medicamento =$mysqli->insert_id;
    $sql = $mysqli->query("insert into entrada(dt_entrada, id_med) values('$var_data', '$id_medicamento')");

    
        include('../entrada.php');     
    $mysqli->close();
?>