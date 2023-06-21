<?php
session_start(); // Inicia a sessão para acessar variáveis de sessão
require_once('database/database.php'); // Inclui o arquivo de configuração e conexão com o banco de dados
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
    // Exibe uma mensagem de erro, se houver, utilizando a variável de sessão 'erro_msg'
    if ($_SESSION['erro_msg'] != '') {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
    }
    ?>
    <header>
        <div class="boasVindas">
            <div class="bv">
                Bem vindo
                <?php echo $_SESSION['user'] ?> <!-- Exibe o nome do usuário obtido da variável de sessão 'user' -->
            </div>
            <a href="/index.php"><button class="btn_sair" type="button">Sair</button></a> <!-- Botão para sair da página -->
        </div>
    </header>
    <div class="flex-container">
        <form action="/pages/controle/controle.php" method="POST"> <!-- Formulário para cadastrar um medicamento, que envia os dados para 'controle.php' -->
            <div id="box">
                <table>
                    <tr>
                        <td class="td_txt">
                            Nome do Medicamento:
                        </td>
                        <td class="td_input">
                            <input type="text" placeholder="Insira um nome de medicamento" name="remedio"
                                class="txt_cons"> <!-- Campo de entrada para o nome do medicamento -->
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
                            <input type='submit' value="Cadastrar" class="btn_confirm"> <!-- Botão para enviar o formulário -->
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <footer>
        <div class="rodape">
            <a href="/pages/telaPrincipal.php"><button class="back_btn">Voltar</button></a> <!-- Botão para voltar à página principal -->
        </div>
    </footer>
</body>

</html>
