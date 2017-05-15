<?php
session_start();

include("conexao.php");

if($_REQUEST["metodo"] == "VerificarLogin") {

    $arrayRetorno = array();

    $cpf = $_REQUEST['cpf'];
    $senha = $_REQUEST['senha'];

    if (isset($cpf) && isset($senha)) {
        try {
            $conn = conectar();
            /*
            * TODO alterar a query de consulta ao banco de dados,
            * visto que o banco de dados da aplicação ainda não foi construído.
            */
            $stmt = $conn->prepare("SELECT cpf,senha FROM users WHERE cpf = ? AND senha = ?");
            $stmt->bindValue(1, $cpf);
            $stmt->bindValue(2, $senha);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {

                //Begin user session
                $_SESSION["dados_usuario"] = array(
                                                        "cpf" => $resultado->cpf,
                                                        "nome"=> $resultado->nome,
                                                        "matricula"=> $resultado->matricula;
                                                        "curso" => $resultado->curso;
                                                        "periodo"=> $resultado->periodo;

                                                  );

                $arrayRetorno[0]["valido"] = 1;
                $arrayRetorno[0]["mensagem"] = "Usuário logado com sucesso ";
                $arrayRetorno[0]["cpf"] = $resultado->cpf;
                $arrayRetorno[0]["periodo"] = $resultado->periodo;
                $arrayRetorno[0]["matricula"] = $resultado->matricula;
                $arrayRetorno[0]["curso"] = $resultado->curso;
                $arrayRetorno[0]["nome"] = $resultado->nome;
            } else {
                $arrayRetorno[0]["valido"] = 0;
                $arrayRetorno[0]["mensagem"] = "Você não possui acesso";
            }

            //Close connection
            $conn = null;

        } catch (Exception $e) {
            $arrayRetorno[0]["valido"] = 0;
            $arrayRetorno[0]["mensagem"] = 'Algo de errado aconteceu: ' . $e->getMessage();
        }

        echo json_encode($arrayRetorno);
        die();
    }
}

?>