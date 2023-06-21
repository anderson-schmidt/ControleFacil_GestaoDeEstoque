<?php
require("../database/database.php");
#mysqli_report(MYSQLI_REPORT_ ERROR | MYSQLI_REPORT_STRICT);
session_start();
$_SESSION['erro_msg'] = "";
$_SESSION['alert_msg'] = "";
#error_reporting(E_ERROR | E_PARSE);
$mysqli = null;

$var_id = $_GET['id_med'];

try {
    // Constrói a consulta SQL para selecionar o ID na tabela 'medicamento_controle'
    $sql = "select id from medicamento_controle where id = ".$var_id;
    
    // Executa a consulta e obtém todos os resultados
    $res = $con->query($sql)->fetchAll();
    
    // Itera sobre os resultados retornados
    foreach ($res as $obj) {
        // Constrói a consulta SQL para excluir o registro com o ID específico
        $sql = "delete from medicamento_controle where id = :id";
        
        // Prepara a consulta
        $res = $con->prepare($sql);
        
        // Vincula o parâmetro ID à consulta preparada
        $res->bindParam(':id', $obj['id']);
        
        // Executa a consulta preparada para excluir o registro
        $res->execute();
        
        // Define uma mensagem de alerta de sucesso na variável de sessão
        $_SESSION['alert_msg'] = "Sucesso!";
    }
} catch (Exception $th) {
    // Em caso de exceção, define a mensagem de erro na variável de sessão e exibe o erro
    $_SESSION['erro_msg'] = $th->getMessage();
    echo $th->getMessage();
    die;
} finally {
    // Inclui o arquivo '../consulta.php'
    include('../consulta.php');
}
?>
