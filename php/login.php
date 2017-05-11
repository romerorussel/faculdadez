<?php
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    if(isset($cpf) && isset($senha)){
        echo("Os dados chegaram perfeitamente, CPF: ".$cpf);
    }
    //TODO Remover comentário e Realizar conexão com o banco de dados e verificar se o usuário existe
    //$pdo = new PDO("root","root");
    //$stmt = $pdo->prepare("SELECT ")
?>