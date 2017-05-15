<?php
session_start();

include("conexao.php");

if($_REQUEST["metodo"] == "VerificarLogin") {

    $arrayRetorno = array();

    $cpf = $_REQUEST['cpf'];
    $senha = $_REQUEST['senha'];

    if (isset($cpf) && isset($senha)) {
        try {
            //$list = array('cpf'=>$cpf, 'senha'=>$senha);
            //$json_req = json_encode($list);
            $conn = conectar();

            $stmt = $conn->prepare("SELECT cpf,senha FROM users WHERE cpf = ? AND senha = ?");
            $stmt->bindValue(1, $cpf);
            $stmt->bindValue(2, $senha);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {

                $_SESSION["dados_usuario"] = array(
                                                    "cpf" => $resultado->cpf
                                                  );

                $arrayRetorno[0]["valido"] = 1;
                $arrayRetorno[0]["mensagem"] = "Usuário logado com cpf: " . $resultado->cpf;
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

        //echo json_encode($arrayRetorno);
        echo "<input type='text'  value='romero'/>";
        die();
    }
}

?>