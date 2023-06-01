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
    $qtdRes = $qtd;
    $id_ctrl  = 0;

    try {
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        $stm = $mysqli->prepare("select * from medicamento_controle
                                 where id_med = ? and lote = ?; ");
        $stm->bind_param('is',$reme, $lot );
        $stm->execute();
        $r = $stm->get_result()->fetch_assoc();
        if ($r){
            if($_POST['id_controle'] == "" ) {
                $qtdRes += $r['qtd'];
            }
           $id_ctrl  = $r['id'];
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
        
        if ($qtd != $qtdRes) {
            $stm = $mysqli->prepare("update medicamento_controle set dt_vencimento = ?,
                                            lote = ?,
                                            qtd = ?
                                    where id = ?;");
            $stm->bind_param('ssii',$dt_venc,$lot,$qtdRes, $id_ctrl);
            $stm->execute();           
        } else {
            $stm = $mysqli->prepare("insert into medicamento_controle(dt_vencimento,lote,qtd,id_med) values (?,?,?,?);");
            $stm->bind_param('ssii',$dt_venc,$lot,$qtdRes, $reme);
            $stm->execute();
            $id_ctrl = $mysqli->insert_id;
        }
        
        $stm = $mysqli->prepare("insert into bordero(dt_evento,	
                                                    id_med_ctrl,
                                                    qtd)
                                VALUES(?,?,?)");
                                
        $stm->bind_param('sii',$dt_evento, $id_ctrl, $qtd);
        $stm->execute();
        $mysqli->commit();
        $_POST['remedio'] = null;
        include('../consulta.php'); 
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $id_ctrl . $th->getMessage();
        $mysqli->rollback();
        include('../entrada.php'); 
    } finally {
        $mysqli->close();        
    }
            
    
?>