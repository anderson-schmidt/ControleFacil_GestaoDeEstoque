<?php
session_start();

require_once('../database/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remedio'])) {
    $desc = $_POST['remedio'];

    $sql = "SELECT produto, pd_sem_impostos AS remedio FROM remedios";

    if (!empty($desc)) {
        $sql .= " WHERE produto = '" . $desc . "'";
    }

    $res = $con->query($sql);

    // Aqui você pode processar o resultado da consulta e exibir os dados na página
    if ($res) {
       $remedios = $res->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $remedios = [];
    }
}
?>

