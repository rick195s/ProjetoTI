<?php

// Para conseguir aceder às funções de login é necessário incluir a página de php onde a função se encontra
include "functions.php";

$login_error = false;

/* Como só queremos que a função de login seja chamada quando o utilizador seleciona o butão de login
primeiro verificamos se o botão existe no array $_POST.

Se for o caso a função login é chamada e é verificado se os parâmetros estão corretos, nesse caso
o utilizador é redirecionado para o dashboard senão a variavél login_error é colocada a true para 
depois ser apresentada uma mensagem de erro ao utilizador na página de login
*/

if (array_key_exists("btn-login", $_POST)) {
    if (login($_POST["username"], $_POST["password"])) {
        header("Location: dashboard.php");
    } else {
        $login_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logoSF.png">
    <title>Smart Factory</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">

</head>

<body>

    <!--
        Ao implementar uma imagem como background deparamonos com o facto da class container ter margens já
        atribuídas, logo não conseguiamos colocar a imagem a ocupar o ecrã todo mas após alguma pesquisa 
        descobrimos que existe uma class container-fluid que não tem essas margens  
    -->

    <div class="container-fluid" id="login-container">

        <!--
          Para informar o utilizador quando insere os dados de autentificação errados decidimos implementar
         código de php que verifica se uma variavél é true e depois adiciona o código html à página
        -->

        <?php if ($login_error) { ?>
        <div class="alert alert-danger bg-danger" role="alert">

            <lord-icon alt="danger" class="icon-danger" src="https://cdn.lordicon.com//tdrtiskw.json" trigger="loop"
                colors="primary:#ffffff,secondary:#ffffff">
            </lord-icon>
            <h4 class="alert-heading">Autentificação falhada!</h4>
            <p>Por favor insira os dados de Autentificação corretos</p>
        </div>
        <?php } ?>


        <div class="row text-center" id="login-row">

            <div class="shadow-lg col-md-5 col-10" id="login-box">
                <form method="post" class="mx-auto form-login">

                    <img class="mb-4" src="./images/logoSF.png" alt="" width="72" height="72" />

                    <h1 class="h3 mb-3 font-weight-normal ">LOGIN</h1>

                    <label for="username" class="sr-only">Username</label>
                    <input type="text" id="username" class="form-control" name="username" value=""
                        placeholder="Username" required autofocus />

                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" class="form-control" name="password" value=""
                        placeholder="Password" required />
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" id="rememberMe" value="lsRememberMe"> Remember me
                        </label>
                    </div>
                    <button onclick="lsRememberMe()" class="btn btn-lg btn-primary" name="btn-login"
                        type="submit">Entrar</button>
                </form>

            </div>

        </div>

    </div>

    <script src="scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="https://cdn.lordicon.com//libs/frhvbuzj/lord-icon-2.0.2.js"></script>
</body>

</html>