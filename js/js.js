/*
* Author: Romero Russel
* Date: 26/05/2017
*/

//Role responsible for validating login
$('document').ready(function(){
    $("#btn-login").click(function() {

        try {
            var cpf = $('#cpf').val();
            var senha = $('#senha').val();
            var regex = /^\d{11}$/;

            if (!regex.test(cpf)) {
                throw("Por favor digite o seu CPF corretamente com 11 dígitos e apenas números.");
            }
            if (!(senha.length > 3 && senha.length <= 9)) {
                throw("A sua senha deve conter mais de 3 e até 9 dígitos, tente novamente.");
            }
            if (regex.test(cpf) && senha.length <= 9) {

                $.ajax({
                    type: "POST",
                    url: "php/services.php",
                    data: "metodo=CheckLogin&cpf=" + cpf + "&senha=" + senha,
                    beforeSend: function()
                    {
                        // $("#div_load_geral_tabela").show();
                    },
                    success: function(retorno)
                    {
                        try
                        {
                            var arRetorno = JSON.parse(retorno);
                            if(arRetorno[0].valido == 1)
                            {
                                alert(arRetorno[0].mensagem);
                                window.location = "php/home.php";
                            }
                            else
                            {
                                console.log(retorno);
                                console.log(arRetorno);
                                alert(retorno);
                            }
                        }
                        catch(erro)
                        {
                            alert("Não foi possível logar no sistema.");
                            console.log(retorno);
                            console.log(arRetorno);
                        }
                    },
                    error: function(request, status, errorThrown)
                    {
                        //$("#div_load_geral_tabela").hide();
                        console.log(request);
                        console.log(status);
                        console.log(errorThrown);
                    }
                });
            } else {
                return false;
            }
        }
        catch(e){
            alert(e);
        }
    });
});

//Role responsible for setting up front page table
$('home.php').ready(function() {

    $('#tabela-disciplinas-aluno').DataTable( {
        "ajax": '../php/services.php?metodo=LoadStudentData',
        "language": {
            "lengthMenu": "",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    } );
} );
//Function responsible for sending database support message
$('document').ready(function(){
    $("#btn-suporte").click(function(){

        try{
           var msg = $("#suporte-mensagem").val();

            $.ajax({
                type: "POST",
                url: "../php/services.php",
                data: "metodo=SendMessageSupport&msg="+msg,
                beforeSend: function () {

                },
                success: function(retorno) {
                    try{

                        var arRetorno = JSON.parse(retorno);

                        if(arRetorno['valido'] == 1)
                        {
                            alert(arRetorno['mensagem']);
                            window.location = "../php/home.php";
                        }
                        else
                        {
                            console.log(retorno);
                            console.log(arRetorno);
                            alert(retorno);
                        }

                    }catch(erro){
                        console.log(erro);
                    }
                },
                error: function(request, status, errorThrown)
                {
                    console.log(request);
                    console.log(status);
                    console.log(errorThrown);
                }

            });

        }catch (e) {
            console.log(e);
        }

    });
});

//Role responsible for setting up school history and chart charts with percentage of course completed
$('schoolHistory.html').ready(function() {

    $('#tabela-historico-aluno').DataTable( {
        "ajax": '../php/services.php?metodo=LoadStudentHistory',
        "language": {
            "lengthMenu": "",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    } );
        $.ajax({
            type: "POST",
            url: "../php/services.php",
            data: "metodo=CarregarPercentualCurso",

            beforeSend: function () {

            },
            success: function(retorno) {
                    var arRetorno = JSON.parse(retorno);

                    if(arRetorno['valido'] == 1)
                    {

                        var periodo = arRetorno['periodo'];
                        var qtdTotalPeriodo =  arRetorno['qtd_periodo'];

                        //GOOGLE CHARTS
                        google.charts.load("current", {packages:["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Task', 'Percentual completo do curso'],
                                ['Períodos Concluidos/Corrente',    periodo],
                                ['Percentual não concluído',    qtdTotalPeriodo]

                            ]);

                            var options = {
                                title: 'Percentual completo do curso',
                                is3D: true,
                                backgroundColor: 'transparent',
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                            chart.draw(data, options);
                        }
                    }
                    else
                    {
                        console.log(retorno);
                        console.log(arRetorno);
                        alert(retorno);
                    }
            },
            error: function(request, status, errorThrown)
            {
                console.log(request);
                console.log(status);
                console.log(errorThrown);
            }
        });

} );

//Return home page
$('.voltar').click(function(){
    window.location = "../php/home.php";
});

//Directs the user to the support screen
$('.suporte').click(function(){
    window.location = "../webcontent/support.html";
});
//Responsible for setting up table of subjects
$('disciplines.html').ready(function() {
    $('#tabela-disciplinas-curso').DataTable( {
        "ajax": '../php/services.php?metodo=LoadCourseSubjects',
        "language": {
            "lengthMenu": "",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    } );
} );


