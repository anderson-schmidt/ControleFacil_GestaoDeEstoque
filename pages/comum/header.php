<header>
    <?php
    // Verifica se há uma mensagem de erro na variável de sessão 'erro_msg'
    // Se houver, exibe uma div de alerta de perigo com a mensagem de erro
    if ($_SESSION['erro_msg'] != '') {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
    }
    ?>
    <?php
    // Verifica se há uma mensagem de alerta na variável de sessão 'alert_msg'
    // Se houver, exibe uma div de alerta de sucesso com a mensagem de alerta
    if ($_SESSION['alert_msg'] != '') {
        echo '<div class="alert alert-success" role="alert">';
        echo $_SESSION['alert_msg'];
        echo '</div>';
    }
    ?>
    <div class="boasVindas">
        <div class="bv">
            Bem vindo
            <?php echo $_SESSION['user'] ?>
        </div>
        <a href="/index.php"><button class="btn_sair" type="button">Sair</button></a>
    </div>
</header>
