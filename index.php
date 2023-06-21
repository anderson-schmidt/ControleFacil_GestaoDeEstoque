<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Inclui o CSS do Bootstrap -->

    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <!-- Inclui o CSS personalizado -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Inclui as fontes do Google Fonts -->

    <title>Controle Fácil – Gestão de Estoque</title>
</head>
<body>
<?php 
    // Verifica se há uma mensagem de erro na sessão
    if ($_SESSION['erro_msg'] != '') {
        echo '<div class="alert alert-danger" role="alert">';
        echo $_SESSION['erro_msg'];
        echo '</div>';
    }
?>

<div class="flex-container">
    <div id="box">
        <form action="/pages/login/login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Login</label>
                <input class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Senha</label>
                <input type="password" class="form-control" name="pass" id="pass" required>
            </div>
            <div class="d-grid gap-3 col-7 mx-auto">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- Inclui o JavaScript do Bootstrap -->
</body>
</html>
