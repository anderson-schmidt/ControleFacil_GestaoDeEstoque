<?php
session_start(); // Inicia a sessão para acessar variáveis de sessão
require('database/database.php'); // Inclui o arquivo de configuração e conexão com o banco de dados
$host = $_SERVER['HTTP_HOST']; // Obtém o host do servidor
$protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http'; // Obtém o protocolo utilizado (HTTP ou HTTPS)
$URL_BASE = $protocol . '://' . $host; // Define a URL base usando o protocolo e o host obtidos
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_BASE; ?>/css/style_consulta.css"> <!--// Inclui o arquivo CSS usando a URL base-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Controle Fácil – Gestão de Estoque</title>
</head>

<body>
    <?php include('comum/header.php'); ?> <!-- Inclui o cabeçalho comum a todas as páginas-->
    <div class="cons">
        <table class="tabela_cons">
            <tr>
                <form action="/pages/consulta.php" method='POST'> <!-- Formulário para consultar medicamentos, que envia os dados para 'consulta.php'-->
                    <td>
                        Nome do medicamento:
                        <input type="text" placeholder="insira um nome de medicamento" name="remedio" class="txt_cons"> <!-- Campo de entrada para o nome do medicamento a ser consultado-->
                    </td>
                    <td>
                        <button type="submit" class="btn_sbmt"><img src="/assets/lupa.png" class="lupa"></button> <!--Botão de envio do formulário com uma imagem de lupa-->
                    </td>
                </form>
            </tr>
        </table>
    </div>
    <form action="/pages/controle/cad_ent.php" method="POST"> <!-- Formulário para cadastrar uma entrada de medicamento, que envia os dados para 'cad_ent.php'-->
        <div class="resultado">
            <table class="tbl_cons">
                <thead class="cabeca">
                    <tr>
                        <td class="td_nome">
                            Nome
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
                        <td>
                            Ação
                        </td>
                    </tr>
                </thead>
                <tbody class="corpo">
                    <tr>
                        <?php
                        $sql = "SELECT m.id, m.nome, mc.dt_vencimento, mc.lote, mc.qtd, mc.id as id_ctrl  FROM  medicamentos m
                         join medicamento_controle mc on mc.id_med = m.id"; // Consulta SQL para obter os medicamentos e suas informações de controle
                        $desc = $_POST['remedio']; // Obtém o nome do medicamento a ser consultado a partir do formulário enviado
                        if (isset($desc) && $desc != "") {
                            $sql .= " WHERE m.nome = '" . $desc . "'"; // Adiciona uma condição WHERE à consulta se um nome de medicamento foi fornecido
                        }
                        $res = $con->query($sql); // Executa a consulta SQL

                        foreach ($res as $obj) {
                            ?>
                        <tr class="tb_items">
                            <td>
                                <?php echo $obj['nome']; ?> <!-- Exibe o nome do medicamento-->
                            </td>
                            <td>
                                <?php echo $obj['dt_vencimento']; ?> 
                                <!-- Exibe a data de validade-->
                            </td>
                            <td>
                                <?php echo $obj['lote']; ?> <!-- Exibe o lote-->
                            </td>
                            <td>
                                <?php echo $obj['qtd']; ?> <!-- Exibe a quantidade-->
                            </td>
                            <td>
                                <a href="/pages/entrada.php?id_alt=<?php echo $obj['id_ctrl'];// Cria um link para a página de alteração com o ID de controle do medicamento ?>">alterar</a><br /> 
                                <a href="/pages/controle/exc_med.php?id_med=<?php echo $obj['id_ctrl']; // Cria um link para a página de exclusão com o ID de controle do medicamento?>">excluir</a> 
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </form>
    <footer>
        <div class="rodape">
            <a href="/pages/telaPrincipal.php"><button class="back_btn">Voltar</button></a> <!-- Botão para voltar à página principal-->
        </div>
    </footer>
</body>

</html>
