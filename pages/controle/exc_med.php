<?php
require("../database/database.php");
#mysqli_report(MYSQLI_REPORT_ ERROR | MYSQLI_REPORT_STRICT);
session_start();
$_SESSION['erro_msg'] = "";
$_SESSION['alert_msg'] = "";
#error_reporting(E_ERROR | E_PARSE);
$mysqli = null;


$var_id = $_GET['id_med'];

try {
    $sql = "select id from medicamentos where id = ".$var_id;
    $res = $con->query($sql);
  /*  $res->bind_param('i',$var_id);
    $res->execute();
    $res->bind_result($id);*/
   // print_r($res);
   foreach ($res as $obj) {

        $sql = "delete from medicamentos where id = :id";
        $res = $con->prepare($sql);
        $res->bindParam(':id',$obj['id']);
        $res->execute();
        $_SESSION['alert_msg'] = "Sucesso!";
    }

} catch (Exception $th) {
    $_SESSION['erro_msg'] = $th->getMessage();
} finally {
    include('../consulta.php');
}



?>