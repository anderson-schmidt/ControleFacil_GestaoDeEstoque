<?php
session_start();
require_once('database/database.php');
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

        <div id="box">
            <table>
                <tr>
                    <td>
                        <a href="/pages/cadastrar.php"><button class="botao" type="button">Cadastrar</button></a>
                    </td>
                    <td>
                        <a href="/pages/entrada.php"><button class="botao" type="button">Entrada</button></a>
                    </td>
                    <td>
                        <a href="/pages/saida.php"><button class="botao" type="button">Saída</button></a>
                    </td>
                </tr>
                <tr>

                    <td>
                        <a href="/pages/consulta.php"><button class="botao" type="button">Consulta Estoque</button></a>
                    </td>
                    <td></td>
                    <td>
                        <a href="/pages/consulta_precos.php"><button class="botao" type="button">Consulta
                                Preços</button></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>