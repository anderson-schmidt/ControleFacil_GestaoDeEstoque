<?php
session_start();
require('database/database.php');
    $host = $_SERVER['HTTP_HOST'];
    $protocol=$_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    $URL_BASE =  $protocol.'://'.$host
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo $URL_BASE; ?>/css/style_consulta.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Controle Fácil – Gestão de Estoque</title>
</head>

<body>
    <?php include('comum/header.php'); ?>
    <div class="cons">
        <table class="tabela_cons">
            <tr>
                <form action="/pages/consulta.php" method='POST'>
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
                        <button type="submit" class="btn_sbmt"><img src="/assets/lupa.png" class="lupa"></button>
                    </td>
                </form>
            </tr>
        </table>
    </div>
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
                         join medicamento_controle mc on mc.id_med = m.id";
                    $desc = $_POST['remedio'];
                    if (isset($desc) && $desc != "") {
                        $sql .= " WHERE m.nome = '" . $desc . "'";
                    }
                    $res = $con->query($sql);


                        foreach ($res as $obj) {
                            ?>
                        <tr class="tb_items">
                            <td>
                                <?php echo $obj['nome']; ?>
                            </td>
                            <td>
                                <?php echo $obj['dt_vencimento']; ?>
                            </td>
                            <td>
                                <?php echo $obj['lote']; ?>
                            </td>
                            <td>
                                <?php echo $obj['qtd']; ?>
                            </td>
                            <td>
                            <a href="/pages/entrada.php?id_alt=<?php echo $obj['id_ctrl'];?>">alterar</a><br/>
                                <a href="/pages/controle/exc_med.php?id_med=<?php echo $obj['id_ctrl'];?>">excluir</a>
                            </td>
                        </tr>
                        <?php
                        }


                    ?>
            </tbody>
        </table>
    </div>
    <footer>
        <div class="rodape">
            <a href="/pages/telaPrincipal.php"><button class="back_btn">Voltar</button></a>
        </div>
    </footer>
</body>

</html>