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
    
    $sql = $mysqli->query("INSERT INTO medicamento(nome,dt_vencimento, qtd, lote) VALUES('$reme','$dt_venc','$qtd', '$lot')");
    
    $sql = $mysqli->query("INSERT INTO movimentacao(dt_entrada) VALUES('$var_data')");
    
        include('../entrada.php');     
    $mysqli->close();
?>