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
    <style>
        /* Estilos para a notificação */
        .notificacao {
            position: fixed;
            top: 20px;
            left: 20px;
            display: none;
            padding: 10px 20px;
            background-color: rgba(249, 249, 249, 0.9);
            color: black;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            animation: fadeOut 1s ease-in 10s forwards;
        }

        .notificacao::before {
            content: "";
            position: absolute;
            top: 50%;
            left: -10px;
            margin-top: -7px;
            border-width: 7px;
            border-style: solid;
            border-color: transparent rgba(249, 249, 249, 0.9) transparent transparent;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
             100% {
                opacity: 0;
            }
        }
    </style>
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

    // Consulta para recuperar os dados dos medicamentos
    $sql = "SELECT m.nome, mc.lote, mc.qtd, mc.dt_vencimento
            FROM medicamentos m 
            JOIN medicamento_controle mc ON mc.id_med = m.id
            WHERE datediff(NOW(), mc.dt_vencimento) < 30;";

    $result = $con->query($sql)->fetchAll();

    // Verifica se a consulta retornou resultados
    if ($result && count($result) > 0) {
        foreach ($result as $index => $medicamento) {
            // Converte a data de vencimento para um objeto DateTime
            $dtVencimento = new DateTime($medicamento['dt_vencimento']);

            // Chama a função calcularVendaDiaria para obter os dias restantes
            $diasRestantes = calcularVendaDiaria($dtVencimento);

            // Define a mensagem da notificação
            $notificacao = "Você precisa vender " . $medicamento['qtd'] . " medicamentos do medicamento '" . $medicamento['nome'] . "' em " . $diasRestantes . " dias.";

            // Calcula o tempo de exibição para cada notificação
            $tempoExibicao = ($index + 1) * 10000 + ($index * 2000);

            // Exibe a notificação após o tempo de exibição calculado
            echo "<div class='notificacao' style='animation-delay: " . $tempoExibicao . "ms;'>" . $notificacao . "</div>";
        }
    } else {
        $notificacao = "Nenhum medicamento encontrado no banco de dados.";
        echo "<div class='notificacao'>" . $notificacao . "</div>";
    }

    function calcularVendaDiaria($dtVencimento)
    {
        // Obter a data atual
        $dataAtual = new DateTime();

        // Calcular a quantidade de dias restantes até a validade
        $diasRestantes = $dtVencimento->diff($dataAtual)->days;

        return $diasRestantes;
    }
    ?>

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

    <script>
        // Exibe as notificações após um intervalo de tempo
        setTimeout(function() {
            var notificacoes = document.querySelectorAll('.notificacao');
            for (var i = 0; i < notificacoes.length; i++) {
                setTimeout(function(index) {
                    notificacoes[index].style.display = 'block';
                    setTimeout(function() {
                        notificacoes[index].style.display = 'none';
                    }, 10000);
                }, i * 12000, i);
            }
        }, 100);
    </script>
</body>

</html>
