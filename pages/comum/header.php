<header>
    <?php
    if ($_SESSION['erro_msg'] != '') {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
    } ?>
    <?php
    if ($_SESSION['alert_msg'] != '') {
        echo '<div class="alert alert-success" role="alert">';
        echo $_SESSION['alert_msg'];
        echo '</div>';
    } ?>
    <div class="boasVindas">
        <div class="bv">
            Bem vindo
            <?php echo $_SESSION['user'] ?>
        </div>
        <a href="/index.php"><button class="btn_sair" type="button">Sair</button></a>
    </div>
</header>