<?php
try {
    // Variável global para armazenar a conexão com o banco de dados
    global $con;

    // Criação de uma nova instância da classe PDO para estabelecer a conexão
    // A string de conexão especifica o host como "banco", o nome do banco de dados como "controlefacil",
    // e o nome de usuário e senha como "user"
    $con = new PDO("mysql:host=banco;dbname=controlefacil", "user", "user");

    // Definindo o modo de erro para lançar exceções em caso de erros
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    // Em caso de exceção durante a conexão, imprime o objeto de exceção para depuração
    print_r($e);
    // Exibe uma mensagem de erro indicando que houve um problema na conexão
    echo 'Erro conexão';
    // Encerra a execução do programa
    die();
}
?>
