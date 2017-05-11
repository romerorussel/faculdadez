function validaLogin(){
        try {
            var form = document.getElementById("form-login");
            var cpf = form.cpf.value;
            var senha = form.senha.value;
            var regex = /^\d{11}$/;

            if (!regex.test(cpf)) {
                throw("Por favor digite o seu CPF corretamente com 11 dígitos e apenas números.");
            }
            if(!(senha.length > 3 && senha.length <= 9)) {
                throw("A sua senha deve conter mais de 3 e até 9 dígitos, tente novamente.");
            }
            if(regex.test(cpf) && senha.length <= 9){
                document.formulario_login.submit();
            }else{
               return false;
            }
        }catch(e){
            alert(e);
        }

    }