<?php
session_start();
require('database/database.php');
$host = $_SERVER['HTTP_HOST'];
$protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
$URL_BASE = $protocol . '://' . $host;
$remedios = [];

// Configurações de paginação
$porPagina = 10; // Quantidade de resultados por página

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remedio'])) {
    $desc = $_POST['remedio'];

    $sql = "SELECT produto, pd_sem_impostos FROM remedios";

    if (!empty($desc)) {
        $sql .= " WHERE produto like '%" . $desc . "%'";
    }

    $res = $con->query($sql);

    // Total de resultados
    $totalResultados = $res->rowCount();

    // Total de páginas
    $totalPaginas = ceil($totalResultados / $porPagina);

    // Página atual
    $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Limitar resultados por página
    $inicio = ($paginaAtual - 1) * $porPagina;
    $sql .= " LIMIT $inicio, $porPagina";

    $res = $con->query($sql);

    // Aqui você pode processar o resultado da consulta e exibir os dados na página
    if ($res) {
        $remedios = $res->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_BASE; ?>/css/style_consulta_precos.css">
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
        <form action="" method="POST">
            <table class="tabela_cons">
                <tr>
                    <td>
                        Nome do medicamento:
                        <input type="text" placeholder="insira um nome de medicamento" name="remedio" class="txt_cons">
                    </td>
                    <td>
                        <button type="submit" class="btn_sbmt"><img src="/assets/lupa.png" class="lupa"></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="resultado">
        <?php if (count($remedios) > 0): ?>
            <table class="tbl_cons">
                <thead class="cabeca">
                    <tr>
                        <td class="td_nome">
                            Nome
                        </td>
                        <td>
                            Valor
                        </td>
                    </tr>
                </thead>
                <tbody class="corpo">
                    <?php foreach ($remedios as $obj): ?>
                        <tr>
                            <td>
                                <?php echo $obj['produto']; ?>
                            </td>
                            <td>
                                <?php echo $obj['pd_sem_impostos']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php
                // Definir quantas páginas serão exibidas antes e depois da página atual
                $quantidadePaginasVisiveis = 10;

                // Calcular a primeira e última página exibidas
                $primeiraPagina = max(1, $paginaAtual - $quantidadePaginasVisiveis);
                $ultimaPagina = min($totalPaginas, $paginaAtual + $quantidadePaginasVisiveis);

                if ($primeiraPagina > 1) {
                    // Exibir link para a primeira página
                    echo '<a href="?pagina=1&remedio=">1</a>';

                    if ($primeiraPagina > 2) {
                        // Exibir "..." se houver páginas ocultas entre a primeira página e a primeira página visível
                        echo '<span>...</span>';
                    }
                }

                // Exibir as páginas visíveis
                for ($i = $primeiraPagina; $i <= $ultimaPagina; $i++) {
                    echo '<a href="?pagina=' . $i . '" class="' . (($paginaAtual == $i) ? 'active' : '') . '">' . $i . '</a>';
                }

                if ($ultimaPagina < $totalPaginas) {
                    if ($ultimaPagina < $totalPaginas - 1) {
                        // Exibir "..." se houver páginas ocultas entre a última página visível e a última página
                        echo '<span>...</span>';
                    }

                    // Exibir link para a última página
                    echo '<a href="?pagina=' . $totalPaginas . '">' . $totalPaginas . '</a>';
                }
                ?>
            </div>

        <?php else: ?>
            <p>Nenhum resultado encontrado.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="rodape">
            <a href="telaPrincipal.php"><button class="back_btn">Voltar</button></a>
        </div>
    </footer>
</body>

</html>