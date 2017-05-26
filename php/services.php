<?php

session_start();
/**
 * Created by PhpStorm.
 * User: Romero
 * Date: 14/05/2017
 * Time: 17:00
 * File responsible for communicating with the database
 */
include("connection.php");

if($_REQUEST["metodo"] == "CheckLogin") {

    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $arrayRetorno = array();

    if (isset($cpf) && isset($senha)) {
        try {
            $conn = connect();

            $stmt = $conn->prepare("SELECT std.id_estudante,std.nome,std.cpf, std.matricula, std.periodo, std.senha,crs.curso, crs.id_curso
                                        FROM estudante std,curso crs
                                          WHERE std.cpf = ? AND std.senha = ?");
            $stmt->bindValue(1, $cpf);
            $stmt->bindValue(2, $senha);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {

                //Begin user session
                $_SESSION["usuario"] = array(
                                                        "cpf" => $resultado->cpf,
                                                        "nome"=> $resultado->nome,
                                                        "matricula"=> $resultado->matricula,
                                                        "curso" => $resultado->curso,
                                                        "periodo"=> $resultado->periodo,
                                                        "id_estudante" => $resultado->id_estudante,
                                                        "id_curso" => $resultado->id_curso
                                                  );
                //Create array to return json
                $arrayRetorno[0]["valido"] = 1;
                $arrayRetorno[0]["mensagem"] = "Usu�rio logado com sucesso ";
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

if($_REQUEST["metodo"] == "LoadStudentData") {

    $usuario_periodo = $_SESSION['usuario']['periodo'];

    $arrayRetorno = array();

    if (isset($usuario_periodo)) {
        try {

            $conn = connect();

            $stmt = $conn->prepare("SELECT nome,disciplina,horario,complexidade
                                    FROM view_dados_periodo_corrente_aluno
				                    WHERE periodo = ?");
            $stmt->bindValue(1, $usuario_periodo);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if ($stmt->rowCount() > 0) {
                $i = 0;
                foreach($resultado as $listar) {
                    //Create array to return json
                    $arrayRetorno['data'][$i][0] = (string)$listar['nome'];
                    $arrayRetorno['data'][$i][1] = (string)$listar['disciplina'];
                    $arrayRetorno['data'][$i][2] = (string)$listar['horario'];
                    $arrayRetorno['data'][$i][3] = (string)$listar['complexidade'];
                    $i++;
                }
            }
            //Close connection
            $conn = null;

        } catch (Exception $e) {
            $arrayRetorno[0]['valido'] = 0;
            $arrayRetorno[0]['mensagem'] = 'Algo de errado aconteceu: ' . $e->getMessage();
        }

        echo json_encode($arrayRetorno);
        die();
    }
}

if($_REQUEST["metodo"] == "SendMessageSupport"){

    $msg = $_POST['msg'];
    $usuario_nome = $_SESSION['usuario']['nome'];
    $data = date('Y-m-d');
    $arrayRetorno = array();


    if (isset($msg)){
        try{
            $sql = "INSERT INTO suporte_aluno (nome_aluno, mensagem_feedback, data_suporte) VALUES (?,?,?)";
            $conn = connect();

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $usuario_nome);
            $stmt->bindValue(2, $msg);
            $stmt->bindValue(3, $data);
            $stmt->execute();

            if($stmt){
                $arrayRetorno['valido'] = 1;
                $arrayRetorno['mensagem'] = 'Mensagem enviada com sucesso';
            }else{
                $arrayRetorno['valido'] = 0;
                $arrayRetorno['mensagem'] = 'Não foi possível enviar a mensagem';
            }

        }catch(Exception $e){
            echo($e->getMessage());
        }

        $conn = null;

    }
    echo json_encode($arrayRetorno);
    die();
}

if($_REQUEST["metodo"] == "LoadStudentHistory") {

    $usuario_id = $_SESSION['usuario']['id_estudante'];

    $arrayRetorno = array();

    if (isset($usuario_id)) {
        try {

            $conn = connect();

            $stmt = $conn->prepare("SELECT std.periodo, crs.qtd_periodo, dp.disciplina, he.nota1, he.nota2,he.status_aluno
                                    FROM estudante std, curso crs, disciplina dp, historico_escolar he
                                        WHERE crs.id_curso = std.id_curso
                                            AND he.id_disciplina = dp.id_disciplina
                                            AND std.id_estudante = ?");
            $stmt->bindValue(1, $usuario_id);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                $i = 0;
                foreach($resultado as $listar) {
                    //Create array to return json
                    $arrayRetorno['data'][$i][0] = (string)$listar['periodo'];
                    $arrayRetorno['data'][$i][1] = (string)$listar['disciplina'];
                    $arrayRetorno['data'][$i][2] = (string)$listar['nota1'];
                    $arrayRetorno['data'][$i][3] = (string)$listar['nota2'];
                    $arrayRetorno['data'][$i][4] = (string)$listar['status_aluno'];
                    $i++;
                }
            }
            //Close connection
            $conn = null;

        } catch (Exception $e) {
            $arrayRetorno[0]['valido'] = 0;
            $arrayRetorno[0]['mensagem'] = 'Algo de errado aconteceu: ' . $e->getMessage();
        }

        echo json_encode($arrayRetorno);
        die();
    }
}


if($_REQUEST["metodo"] == "CarregarPercentualCurso"){

    $usuario_id = $_SESSION['usuario']['id_estudante'];
    $arrayRetorno = array();


    if (isset($usuario_id)){
        try{
            $sql = "SELECT std.periodo, crs.qtd_periodo FROM estudante std, curso crs
                    WHERE std.id_curso = crs.id_curso
                        AND std.id_estudante = ?";

            $conn = connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $usuario_id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                $arrayRetorno['valido'] = 1;
                $arrayRetorno['mensagem'] = 'Sucesso';
                $arrayRetorno['periodo'] = (integer)$resultado['periodo'];
                $arrayRetorno['qtd_periodo'] = (integer)$resultado['qtd_periodo'];

            }else{
                $arrayRetorno['valido'] = 0;
                $arrayRetorno['mensagem'] = 'Algo de errado aconteceu';
            }

        }catch(Exception $e){
            echo($e->getMessage());
        }

        $conn = null;

    }
    echo json_encode($arrayRetorno);
    die();
}


if($_REQUEST["metodo"] == "LoadCourseSubjects") {

    $usuario_id_curso = $_SESSION['usuario']['id_curso'];

    $arrayRetorno = array();

    if (isset($usuario_id_curso)) {
        try {

            $conn = connect();

            $stmt = $conn->prepare("SELECT disciplina, complexidade, periodo FROM disciplina
					                WHERE id_curso = ?");
            $stmt->bindValue(1, $usuario_id_curso);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                $i = 0;
                foreach($resultado as $listar) {
                    //Create array to return json
                    $arrayRetorno['data'][$i][0] = (string)$listar['disciplina'];
                    $arrayRetorno['data'][$i][1] = (string)$listar['complexidade'];
                    $arrayRetorno['data'][$i][2] = (string)$listar['periodo'];
                    $i++;
                }
            }
            //Close connection
            $conn = null;

        } catch (Exception $e) {
            $arrayRetorno[0]['valido'] = 0;
            $arrayRetorno[0]['mensagem'] = 'Algo de errado aconteceu: ' . $e->getMessage();
        }

        echo json_encode($arrayRetorno);
        die();
    }
}

?>