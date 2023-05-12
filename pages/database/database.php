<?php
try {
    global $con;
 $con = new PDO("mysql:host=banco;dbname=controlefacil", "user", "user");
 $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    print_r($e);
    echo 'Erro conexão';
    die();
}

?>