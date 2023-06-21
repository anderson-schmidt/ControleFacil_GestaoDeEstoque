<?php
    #mysqli_report(MYSQLI_REPORT_ ERROR | MYSQLI_REPORT_STRICT);
    session_start();
    $_SESSION['erro_msg'] = "";
    #error_reporting(E_ERROR | E_PARSE);
    $mysqli = null; 

    // Recupera os valores dos campos de formulário
    $reme = $_POST['remedio'];
    $lot = $_POST['lote'];
    $dt_venc = $_POST['dt_venc'];
    $dt_evento = $_POST['dt_entrada'];
    $qtd = $_POST['qtd'];
    $qtdRes = 0;
    $id_ctrl  = 0;

    try {
        // Estabelece uma conexão com o banco de dados
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");

        // Prepara uma consulta para selecionar registros na tabela 'medicamento_controle'
        $stm = $mysqli->prepare("select * from medicamento_controle
                                 where id_med = ? and lote = ?; ");
        // Faz a ligação dos parâmetros da consulta preparada
        $stm->bind_param('is', $reme, $lot);
        // Executa a consulta preparada
        $stm->execute();
        // Obtém o resultado da consulta e o armazena em um array associativo
        $r = $stm->get_result()->fetch_assoc();
        if ($r) {
            if ($_POST['id_controle'] == "") {
                // Subtrai a quantidade informada do estoque, garantindo que o resultado não seja negativo
                $qtdRes = max(0, $r['qtd'] - $qtd);
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
        // Fecha a conexão com o banco de dados
        $mysqli->close();
    }

    try {
        // Estabelece uma nova conexão com o banco de dados
        $mysqli = new mysqli("banco", "user", "user", "controlefacil");
        // Inicia uma transação
        $mysqli->begin_transaction();
        
        if ($qtdRes != $r['qtd']) {
            // Atualiza o registro na tabela 'medicamento_controle' se a quantidade reservada for diferente da quantidade existente
            $stm = $mysqli->prepare("update medicamento_controle set dt_vencimento = ?,
                                            lote = ?,
                                            qtd = ?
                                    where id = ?;");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $id_ctrl);
            $stm->execute();           
        } else {
            // Insere um novo registro na tabela 'medicamento_controle' se a quantidade reservada for igual à quantidade existente
            $stm = $mysqli->prepare("insert into medicamento_controle(dt_vencimento, lote, qtd, id_med) values (?,?,?,?);");
            $stm->bind_param('ssii', $dt_venc, $lot, $qtdRes, $reme);
            $stm->execute();
            // Obtém o ID do registro recém-inserido
            $id_ctrl = $mysqli->insert_id;
        }
        
        // Insere um novo registro na tabela 'bordero'
        $stm = $mysqli->prepare("insert into bordero(dt_evento, id_med_ctrl, qtd) VALUES(?,?,?)");
        $stm->bind_param('sii', $dt_evento, $id_ctrl, $qtd);
        $stm->execute();
        // Confirma a transação
        $mysqli->commit();
        $_POST['remedio'] = null;
        include('../consulta.php'); 
    } catch (\Throwable $th) {
        $_SESSION['erro_msg'] = $id_ctrl . $th->getMessage();
        // Desfaz a transação em caso de exceção
        $mysqli->rollback();
        include('../saida.php'); 
    } finally {
        // Fecha a conexão com o banco de dados
        $mysqli->close();        
    }           
?>
