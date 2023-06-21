<?php
session_start();

// Inicia a sessão e define uma variável para mensagens de erro
$_SESSION['erro_msg'] = "";

// Define a variável para conexão com o banco de dados como nula
$mysqli = null;

// Obtém os valores dos campos do formulário
$var_data = $_POST['dt_entrada'];
$reme = $_POST['remedio'];
$lot = $_POST['lote'];
$dt_venc = $_POST['dt_venc'];
$qtd = $_POST['qtd'];

try {
    // Estabelece a conexão com o banco de dados
    $mysqli = new mysqli("banco", "user", "user", "controlefacil");
    
    // Inicia uma transação no banco de dados
    $mysqli->begin_transaction();
    
    // Insere um novo medicamento na tabela 'medicamentos'
    $stm = $mysqli->prepare("insert into medicamentos(nome) VALUES(?)");
    $stm->bind_param('s', $reme);
    $stm->execute();
    
    // Confirma a transação no banco de dados
    $mysqli->commit();
} catch (\Throwable $th) {
    // Em caso de erro, captura a exceção e define a mensagem de erro na sessão
    $_SESSION['erro_msg'] = $th->getMessage();
    
    // Desfaz a transação no banco de dados
    $mysqli->rollback();
    
    // Inclui o arquivo '../entrada.php'
    include('../entrada.php');
} finally {
    // Fecha a conexão com o banco de dados
    $mysqli->close();
    
    // Inclui o arquivo '../telaPrincipal.php'
    include('../telaPrincipal.php');
}
?>
