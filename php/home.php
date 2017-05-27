<?php session_start();
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="../frameworks/jquery.js"></script>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js "></script>

 </head>
<body class="panel-home">
    <div class="container-fluid">
        <div class="row" style="margin-top:75px;">
            <div class="col-md-10">
                <div class="dropdown">
                    <button id="dLabel" class="btn btn-primary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['usuario']['nome']." ".$_SESSION['usuario']['periodo']."º período"." ".$_SESSION['usuario']['curso']; ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                       <li><a href="../webcontent/schoolHistory.html">Histórico Escolar</a></li>
                        <li><a href="../webcontent/disciplines.html">Disciplinas</a></li>
                        <li><a href="../webcontent/support.html">Suporte</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2"><span class   ="ola-aluno">Olá <?php echo $_SESSION['usuario']['nome'] ?></span></div>
        </div>

        <div class="row" style="margin-top:75px;">
            <div class="col-md-12">
                <table class="table table-condensed" id="tabela-disciplinas-aluno">
                    <thead>
                        <tr>
                            <th>Professor</th>
                            <th>Disciplina</th>
                            <th>Horários de Aula</th>
                            <th>Complexidade</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/js.js"></script>
    <script src="../frameworks/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>

