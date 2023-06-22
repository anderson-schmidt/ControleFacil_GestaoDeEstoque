<?php
session_start();
require('database/database.php');

// Obtém o valor do parâmetro "id_alt" da URL
$id_med_ctrl = $_GET['id_alt'];

$sql = "SELECT * FROM medicamento_controle WHERE id = :id";
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
    if (!empty($_SESSION['erro_msg'])) {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
     } ?>
    <header>
        <div class="boasVindas">
            <div class="bv">
                Bem vindo
                <?php echo $_SESSION['user'] ?>
            </div>
            <a href="/index.php"><button class="btn_sair" type="button">Sair</button></a>
        </div>
    </header>
    <div class="flex-container">
        <form action="/pages/controle/cad_said.php" method="POST">
            <div id="box">
                <table>
                    <tr>
                        <td class="td_txt">
                            Nome do Medicamento:
                        </td>
                        <td class="td_input">
                            <input type="hidden" name="id_controle" value="<?php echo $ctrl ?  $ctrl['id'] : ''; ?>"></input>
                            <select name="remedio" class="txt_cons">
                                <?php
                                $sql = 'SELECT id, nome FROM medicamentos';
                                $stmt = $con->prepare($sql);
                                $stmt->execute();
                                $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($medicamentos as $med) {
                                    $selected = ($med['id'] == $ctrl['id_med']) ? 'selected' : '';
                                    echo "<option value='{$med['id']}' $selected>{$med['nome']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Data de Saída:
                        </td>
                        <td class="td_input">
                            <input type="date" name="dt_saida" class="form_dt" value="<?php echo date("Y-m-d"); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Número do Lote:
                        </td>
                        <td class="td_input">
                            <input type="text" placeholder="Nº do lote" name="lote" class="txt_lote" value="<?php echo $ctrl ? $ctrl['lote'] : '' ?>"></input>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Quantidade:
                        </td>
                        <td class="td_input">
                            <input type="text" placeholder="Quantia" name="qtd" class="txt_quantia" value="<?php echo $ctrl ? $ctrl['qtd'] : '' ?>">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <input type='submit' value="Cadastrar" class="btn_confirm">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <footer>
        <div class="rodape">
            <a href="/pages/telaPrincipal.php"><button class="back_btn">Voltar</button></a>
        </div>
    </footer>
</body>

</html>
