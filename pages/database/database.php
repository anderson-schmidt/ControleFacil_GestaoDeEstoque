<?php
$mysqli = new mysqli("banco", "user", "user", "controlefacil");
    if ($mysqli->connect_errno) {
        echo 'Erro conexão';
        die();
    } 
?>