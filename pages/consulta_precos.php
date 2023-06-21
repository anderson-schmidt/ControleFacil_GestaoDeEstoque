<?php
session_start(); // Inicia a sessão para acessar variáveis de sessão
require('database/database.php'); // Inclui o arquivo de configuração e conexão com o banco de dados
$host = $_SERVER['HTTP_HOST']; // Obtém o host do servidor
$protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http'; // Obtém o protocolo utilizado (HTTP ou HTTPS)
$URL_BASE = $protocol . '://' . $host; // Define a URL base usando o protocolo e o host obtidos
$remedios = []; // Array vazio para armazenar os medicamentos

// Configurações de paginação
$porPagina = 10; // Quantidade de resultados por página

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remedio'])) {
    $desc = $_POST['remedio']; // Obtém o nome do medicamento a ser consultado a partir do formulário enviado

    $sql = "SELECT produto, pd_sem_impostos FROM remedios"; // Consulta SQL para obter os medicamentos e seus preços

    if (!empty($desc)) {
        $sql .= " WHERE produto like '%" . $desc . "%'"; // Adiciona uma condição WHERE à consulta se um nome de medicamento foi fornecido
    }

    $res = $con->query($sql); // Executa a consulta SQL

    // Total de resultados
    $totalResultados = $res->rowCount();

    // Total de páginas
    $totalPaginas = ceil($totalResultados / $porPagina);

    // Página atual
    $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Limitar resultados por página
    $inicio = ($paginaAtual - 1) * $porPagina;
    $sql .= " LIMIT $inicio, $porPagina";

    $res = $con->query($sql); // Executa a consulta SQL com a limitação de resultados por página

    // Aqui você pode processar o resultado da consulta e exibir os dados na página
    if ($res) {
        $remedios = $res->fetchAll(PDO::FETCH_ASSOC); // Armazena os medicamentos em um array
    }
}
?>
