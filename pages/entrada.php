<?php
session_start(); // Inicia a sessão para acessar variáveis de sessão
require('database/database.php'); // Inclui o arquivo de configuração e conexão com o banco de dados

$id_med_ctrl = $_GET['id_alt']; // Obtém o ID do medicamento no controle de estoque a ser alterado a partir da URL

$sql = "SELECT * FROM medicamento_controle m WHERE id = :id"; // Consulta SQL para obter as informações do medicamento no controle de estoque com o ID especificado
$stm = $con->prepare($sql); // Prepara a consulta SQL
$stm->bindParam(":id", $id_med_ctrl); // Define o valor do parâmetro :id com o ID obtido
$stm->execute(); // Executa a consulta SQL
$ctrl = $stm->fetch(); // Armazena o resultado da consulta em $ctrl

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Cabeçalho HTML -->
</head>

<body>
    <?php 
    if ($_SESSION['erro_msg'] != '') {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
     } ?>
    <!-- Corpo HTML -->
</body>

</html>
