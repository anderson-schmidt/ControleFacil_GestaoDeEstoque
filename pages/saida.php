<?php
session_start();
require('database/database.php');

$id_med_ctrl = $_GET['id_alt'];

$sql = "SELECT * FROM  medicamento_controle m
        WHERE id = :id";
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
    #mysqli_report(MYSQLI_REPORT_ ERROR | MYSQLI_REPORT_STRICT);
    session_start();
    $_SESSION['erro_msg'] = "";
    #error_reporting(E_ERROR | E_PARSE);
    $mysqli = null; 
   
    $reme = $_POST['remedio'];
    $lot = $_POST['lote'];
    $dt_venc = $_POST['dt_venc'];
    $dt_evento = $_POST['dt_entrada'];
    $qtd = $_POST['qtd'];
    $qtdRes = 0;
    $id_ctrl  = 0;

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        $stm = $mysqli->prepare("select * from medicamento_controle
                                 where id_med = ? and lote = ?; ");
        $stm->bind_param('is', $reme, $lot);
        $stm->execute();
        $r = $stm->get_result()->fetch_assoc();
        if ($r) {
            if ($_POST['id_controle'] == "") {
                $qtdRes = max(0, $r['qtd'] - $qtd); // Subtrai a quantidade informada do estoque
            }
            $id_ctrl  = $r['id'];
        } else {
            $qtdRes = $qtd; // Define o valor original fornecido pelo usuário
        }
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $th->getMessage();
        #include('../entrada.php'); 
        die;
    } finally {
        $mysqli->close();
    }

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        $mysqli->begin_transaction();
        
        if ($qtdRes != $r['qtd']) {
            $stm = $mysqli->prepare("update medicamento_controle set dt_vencimento = ?,
                                            lote = ?,
                                            qtd = ?
                                    where id = ?;");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $id_ctrl);
            $stm->execute();           
        } else {
            $stm = $mysqli->prepare("insert into medicamento_controle(dt_vencimento, lote, qtd, id_med) values (?,?,?,?);");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $reme);
            $stm->execute();
            $id_ctrl = $mysqli->insert_id;
        }
        
        $stm = $mysqli->prepare("insert into bordero(dt_evento, id_med_ctrl, qtd) VALUES(?,?,?)");
        $stm->bind_param('sii', $dt_evento, $id_ctrl, $qtd);
        $stm->execute();
        $mysqli->commit();
        $_POST['remedio'] = null;
        include('../consulta.php'); 
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $id_ctrl . $th->getMessage();
        $mysqli->rollback();
        include('../saida.php'); 
    } finally {
        $mysqli->close();        
    }
?>
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
                            Data de Saída:
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