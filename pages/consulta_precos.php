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
    <link rel="stylesheet" type="text/css" href="../css/style_consulta_precos.css">
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

    <div class="cons">
        <table class="tabela_cons">
            <tr>
                <td>
                    Nome do medicamento:
                    <input type="text" placeholder="insira um nome de medicamento" name="remedio" class="txt_cons">
                </td>
                <td>
                    <!--<input type="submit" value="Enviar" name="data" class="btn_enviar">-->
                    <button type="submit" class="btn_sbmt"><img src="/assets/lupa.png" class="lupa"></button>
                </td>
            </tr>
        </table>
    </div>
    <div class="resultado">
    </div>
    <footer>
        <div class="rodape">
        <a href="telaPrincipal.php"><button class="back_btn">Voltar</button></a>
        </div>
    </footer>
</body>

</html>