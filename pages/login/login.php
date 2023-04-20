<?php
    session_start();
    #error_reporting(E_ERROR | E_PARSE);
    $mysqli = new mysqli("banco", "user", "user", "controlefacil");
    if ($mysqli->connect_errno) {
        echo 'Erro conexão';
        die();
    } 
    $res = $mysqli->query("SELECT id FROM usuario where usuario='".$_POST['email']."' and password='".$_POST['pass']."' LIMIT 1;");
    if ($res->num_rows == 1) {
        $_SESSION['user'] = $_POST['email'];
        include('../telaPrincipal.php');
        $_SESSION['erro_msg'] = null;
    } else {
        
        $_SESSION['erro_msg'] = 'Usuario inválido';
        include('../../index.php');     
    }
    $mysqli->close();
?>