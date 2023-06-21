<?php
session_start();

// Inclui o arquivo de configuração do banco de dados
require_once('../database/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remedio'])) {
    // Obtém o valor do campo de formulário 'remedio'
    $desc = $_POST['remedio'];

    // Monta a consulta SQL para selecionar os registros da tabela 'remedios'
    $sql = "SELECT produto, pd_sem_impostos AS remedio FROM remedios";

    if (!empty($desc)) {
        // Adiciona uma cláusula WHERE à consulta se o campo 'remedio' não estiver vazio
        $sql .= " WHERE produto = '" . $desc . "'";
    }

    // Executa a consulta no banco de dados
    $res = $con->query($sql);

    // Aqui você pode processar o resultado da consulta e exibir os dados na página
    if ($res) {
        // Obtém todos os resultados da consulta como um array associativo
        $remedios = $res->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Define um array vazio se a consulta não retornar resultados
        $remedios = [];
    }
}
?>
