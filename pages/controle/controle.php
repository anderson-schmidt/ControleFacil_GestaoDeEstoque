<?php
    #mysqli_report(MYSQLI_REPORT_ ERROR | MYSQLI_REPORT_STRICT);
    session_start();
    $_SESSION['erro_msg'] = "";
    #error_reporting(E_ERROR | E_PARSE);
    $mysqli = null; 
   

    $var_data = $_POST['dt_entrada'];
    $reme = $_POST['remedio'];
    $lot = $_POST['lote'];
    $dt_venc = $_POST['dt_venc'];
    $qtd = $_POST['qtd'];

    

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        $mysqli->begin_transaction();
        $stm = $mysqli->prepare("insert into medicamentos(nome) VALUES(?)");
        $stm->bind_param('s',$reme);
        $stm->execute();
        $lastId = $mysqli->insert_id;
        $stm = $mysqli->prepare("insert into medicamento_controle(dt_vencimento, lote, qtd,id_med) VALUES(?,?,?,?)");
        $stm->bind_param('ssii',$dt_venc, $lot, $qtd,$lastId);
        $stm->execute();
        $lastId = $mysqli->insert_id;
        $stm = $mysqli->prepare("insert into bordero(id_med_ctrl, qtd) VALUES(?,?)");
        $stm->bind_param('ii',$lastId, $qtd*-1);
        $stm->execute();
        $mysqli->commit();
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $th->getMessage();
        $mysqli->rollback();
        include('../entrada.php'); 
    } finally {
        $mysqli->close();
        include('../consulta.php'); 
    }
            
    
    
?>