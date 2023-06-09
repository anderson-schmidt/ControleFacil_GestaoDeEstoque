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
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/style_entrada.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Controle Fácil – Gestão de Estoque</title>
    <script>
        document.getElementById
    </script>
</head>

<body>
    <?php 
    if ($_SESSION['erro_msg'] != '') {
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
        <form action="/pages/controle/cad_ent.php" method="POST">
            <div id="box">
                <table>
                    <tr>
                        <td class="td_txt">
                            Nome do Medicamento:
                        </td>
                        <td class="td_input">
                            <input type="hidden" name="id_controle" value="<?php echo $ctrl ?  $ctrl['id'] : ''; ?>"></input>
                            <select type="text" placeholder="Insira um nome de medicamento" name="remedio"
                                class="txt_cons">
                            <?php
                                $sql = 'select id, nome from medicamentos';
                                foreach( $con->query($sql) as $row) {
                            ?>
                            <option <?php echo $row['id'] == $ctrl['id_med'] ? 'selected' : '' ?> value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?> </option>

                            <?php

                                }
                            ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Data de Entrada:
                        </td>
                        <td class="td_input">
                            <input type="date" name="dt_entrada" class="form_dt" value="<?php echo date("Y-m-d"); ?>">
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
                            Data de vencimento:
                        </td>
                        <td class="td_input">
                            <input type="date" name="dt_venc" class="form_dt" value="<?php echo $ctrl ? $ctrl['dt_vencimento'] : '' ?>">
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
                    <tr>
                    </tr>
                    <tr>
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
