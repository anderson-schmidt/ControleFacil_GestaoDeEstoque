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
    <header>
        <div class="boasVindas">
            <div class="bv">
                Bem vindo
                <?php echo $_SESSION['user']; ?>
            </div>
            <a href="/index.php"><button class="btn_sair" type="button">Sair</button></a>
        </div>
    </header>
    
    <?php
    require_once('database/database.php');

    // Consulta para recuperar os dados do medicamento
    $sql1 = "select m.nome, mc.lote, mc.qtd, mc.dt_vencimento
            from medicamentos m 
            join medicamento_controle mc on mc.id_med = m.id
            where datediff(now(), mc.dt_vencimento) < 30;";

    $sql2 = "select id_med_ctrl, avg(qtd*-1) as saidamedia
            from bordero  
            where datediff(now(), dt_evento) < 30
            and qtd < 0
            group by 1";

    $result1 = $con->query($sql1)->fetch();
    $result2 = $con->query($sql2)->fetchALL();

    // Cálculo para a quantidade de medicamentos perdidos
    $perda = $result1[2] - $result2['saidamedia'];

    // Verifica se a consulta retornou resultados
    if ($result1 && count($result1) > 0) {
        print_r($result1);
        echo ($result2);
        /*  // Obtém os valores do banco de dados
        $quantidadeEstoque = $row["qtd"];
        $validade = new DateTime($row["dt_vencimento"]);

        // Chama a função para calcular a venda diária
        $vendaDiaria = calcularVendaDiaria($result1);
        
        // Calcula a quantidade total a ser vendida
        $diasRestantes = $validade->diff(new DateTime())->days;
        $quantidadeTotal = $vendaDiaria * $diasRestantes;*/

        // Exibe a notificação
        $notificacao = "Você precisa vender " . ($result1[2]) . " medicamentos em $diasRestantes dias.";
    } elseif ($result1[2] > $result2['saidamedia']) {
        $notificacao = "Você terá a perda de " . ($perda) . " medicamentos!";
    } else {
        $notificacao = "Nenhum medicamento encontrado no banco de dados.";
    }

    function calcularVendaDiaria($result1) {
        // Obter a data atual
        $dataAtual = new DateTime();
        $dataAtual->setTime(20, 06, 2023);

        // Calcular a quantidade de dias restantes até a validade
        $diasRestantes = $result1[3]->diff($dataAtual)->days;

        // Calcular a quantidade de remédios a serem vendidos por dia
        $vendaDiaria = $result1[2] / $diasRestantes;

        return $vendaDiaria;
    }
    ?>

    <div class="notificacao"><?php echo $notificacao; ?></div>
    
    <div class="flex-container">
        <div id="box">
            <table>
                <tr>
                    <td>
                        <a href="/pages/cadastrar.php"><button class="botao" type="button">Cadastrar</button></a>
                    </td>
                    <td>
                        <a href="/pages/entrada.php"><button class="botao" type="button">Entrada</button></a>
                    </td>
                    <td>
                        <a href="/pages/saida.php"><button class="botao" type="button">Saída</button></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/pages/consulta.php"><button class="botao" type="button">Consulta Estoque</button></a>
                    </td>
                    <td></td>
                    <td>
                        <a href="/pages/consulta_precos.php"><button class="botao" type="button">Consulta Preços</button></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
