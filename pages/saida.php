<?php
session_start();
require('database/database.php');

// Obtém o valor do parâmetro "id_alt" da URL
$id_med_ctrl = $_GET['id_alt'];

// Consulta o banco de dados para obter os detalhes do medicamento de controle com base no ID fornecido
$sql = "SELECT * FROM medicamento_controle m WHERE id = :id";
$stm = $con->prepare($sql);
$stm->bindParam(":id", $id_med_ctrl);
$stm->execute();
$ctrl = $stm->fetch();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/style_entrada.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Controle Fácil – Gestão de Estoque</title>
</head>

<body>
<?php
    // Inicia a sessão
    session_start();
    $_SESSION['erro_msg'] = "";
    $mysqli = null; // Variável para a conexão com o banco de dados
   
    // Obtém os valores dos campos do formulário enviados via POST
    $reme = $_POST['remedio'];
    $lot = $_POST['lote'];
    $dt_venc = $_POST['dt_venc'];
    $dt_evento = $_POST['dt_entrada'];
    $qtd = $_POST['qtd'];
    $qtdRes = 0;
    $id_ctrl  = 0;

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        
        // Consulta o banco de dados para verificar se o medicamento de controle já existe com o mesmo ID e lote
        $stm = $mysqli->prepare("SELECT * FROM medicamento_controle WHERE id_med = ? AND lote = ?");
        $stm->bind_param('is', $reme, $lot);
        $stm->execute();
        $r = $stm->get_result()->fetch_assoc();
        
        if ($r) {
            // O medicamento de controle já existe no banco de dados, atualiza a quantidade disponível no estoque
            if ($_POST['id_controle'] == "") {
                $qtdRes = max(0, $r['qtd'] - $qtd); // Subtrai a quantidade informada do estoque
            }
            $id_ctrl  = $r['id'];
        } else {
            $qtdRes = $qtd; // Define o valor original fornecido pelo usuário
        }
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $th->getMessage();
        die; // Interrompe a execução caso ocorra um erro
    } finally {
        $mysqli->close(); // Fecha a conexão com o banco de dados
    }

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        $mysqli->begin_transaction();
        
        if ($qtdRes != $r['qtd']) {
            // Atualiza os detalhes do medicamento de controle no banco de dados
            $stm = $mysqli->prepare("UPDATE medicamento_controle SET dt_vencimento = ?, lote = ?, qtd = ? WHERE id = ?");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $id_ctrl);
            $stm->execute();           
        } else {
            // Insere um novo medicamento de controle no banco de dados
            $stm = $mysqli->prepare("INSERT INTO medicamento_controle (dt_vencimento, lote, qtd, id_med) VALUES (?,?,?,?)");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $reme);
            $stm->execute();
            $id_ctrl = $mysqli->insert_id; // Obtém o ID do medicamento de controle recém-inserido
        }
        
        // Registra a entrada no borderô
        $stm = $mysqli->prepare("INSERT INTO bordero (dt_evento, id_med_ctrl, qtd) VALUES (?,?,?)");
        $stm->bind_param('sii', $dt_evento, $id_ctrl, $qtd);
        $stm->execute();
        
        $mysqli->commit(); // Confirma a transação
        $_POST['remedio'] = null;
        include('../consulta.php'); // Inclui o arquivo de consulta após a conclusão bem-sucedida
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $id_ctrl . $th->getMessage();
        $mysqli->rollback(); // Desfaz a transação em caso de erro
        include('../saida.php'); // Inclui o arquivo de saída em caso de erro
    } finally {
        $mysqli->close(); // Fecha a conexão com o banco de dados
    }
?>

<!-- O restante do código HTML -->
<header>
    <!-- Cabeçalho -->
</header>
<div class="flex-container">
    <!-- Formulário -->
</div>
<footer>
    <!-- Rodapé -->
</footer>
</body>

</html>
