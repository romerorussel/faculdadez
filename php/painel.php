<?php
/**
 * Created by PhpStorm.
 * User: Romero
 * Date: 14/05/2017
 * Time: 17:00
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" type="text/css" href="../frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/css.css">
 </head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">MENU</div>
            <div class="col-md-6">NOME ALUNO</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="table-condensed">
                    <tr>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Periodo</th>
                        <th>CPF</th>
                    </tr>
                    <tr>
                        <td>Romero</td>
                        <td>Sistemas da Informação</td>
                        <td>Quinto Período</td>
                        <td><?php echo $_SESSION["dados_usuario"]["cpf"]; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-8">Disciplinas do período corrente</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <footer>FOOTER</footer>
            </div>
        </div>
    </div>
    <script src="../frameworks/jquery.js"></script>
    <script src="../frameworks/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>

