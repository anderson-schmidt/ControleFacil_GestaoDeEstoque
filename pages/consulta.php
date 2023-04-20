<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style_consulta.css">
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
                <?php  echo $_SESSION['user'] = $_POST['email']; ?>
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
                    Lote:
                    <input type="text" placeholder="Insira o lote" name="lote" class="txt_lote">
                </td>
                <td>
                    <!--<input type="submit" value="Enviar" name="data" class="btn_enviar">-->
                    <a href=""><img src="/assets/lupa.png" class="lupa"></a>
                </td>
            </tr>
        </table>
    </div>
    <div class="resultado">
        <table class="tbl_cons">
            <tr>
                <td class="td_nome">
                    Nome
                </td>
                <td>
                    Data de entrada
                </td>
                <td>
                    Data de Validade
                </td>
                <td class="td_lote">
                    Lote
                </td>
                <td>
                    Quantidade
                </td>
            <tr>
            <tr>
                <td>
                  
                </td>
            </tr>
        </table>
    </div>
    <footer>
        <div class="rodape">
            <input type="button" class="back_btn" value="Voltar" onclick="history.go(-1)">
        </div>
    </footer>
</body>

</html>