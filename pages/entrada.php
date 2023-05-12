<?php
session_start();
require('database/database.php');
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
        <form action="/pages/controle/controle.php" method="POST">
            <div id="box">
                <table>
                    <tr>
                        <td class="td_txt">
                            Nome do Medicamento:
                        </td>
                        <td class="td_input">
                            <select type="text" placeholder="Insira um nome de medicamento" name="remedio"
                                class="txt_cons">
                            <?php
                                $sql = 'select id, nome from medicamentos';
                                foreach( $con->query($sql) as $row) {
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?> </option>

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
                            <input type="date" name="dt_entrada" class="form_dt">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Número do Lote:
                        </td>
                        <td class="td_input">
                            <select type="text" placeholder="Nº do lote" name="lote" class="txt_lote"></select>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Data de vencimento:
                        </td>
                        <td class="td_input">
                            <input type="date" name="dt_venc" class="form_dt">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_txt">
                            Quantidade:
                        </td>
                        <td class="td_input">
                            <input type="text" placeholder="Quantia" name="qtd" class="txt_quantia">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                        </td>
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