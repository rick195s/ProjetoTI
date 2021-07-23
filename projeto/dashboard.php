<?php

include "functions.php";

verifyAuth();
if (array_key_exists("btn-logout", $_POST)) {
    logout();
}

/* Para apresentar todos os sensores criamos um array com todas as diretorias existentes 
na diretoria pai "files" depois do array ser criado verificamos se dentro de cada uma dessas
diretorias os ficheiros com os valores de cada sensor existem para depois esses
valores serem apresentados no dashboard em cada sensor.

Se pelo menos um desses ficheiros não existir dentro da diretoria do sensor esse sensor 
não é apresentado*/

/* Como ficamos na duvida se o dashboard tinha de pedir os dados à api e só depois mostrar ou se tinha de ir 
buscar os dados logo aos ficheiros criamos as duas formas 
if ($_SESSION["priv"] == 2) {
    $sensores = json_decode(file_get_contents("http://localhost/projeto/api/api.php?tipo=sensor"));
    $atuadores = json_decode(file_get_contents("http://localhost/projeto/api/api.php?tipo=atuador"));
}

$maquinas = json_decode(file_get_contents("http://localhost/projeto/api/api.php?tipo=maquina"));
*/
$sensores = getDisps("sensor");
$atuadores = getDisps("atuador");
$maquinas = getDisps("maquina");
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Faz refresh da pagina a cada 5 segundos -->
    <meta http-equiv="refresh" content="5">

    <link rel="shortcut icon" href="./images/logoSF.png">
    <title>Smart Factory - Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css">

</head>

<body>

    <header>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Smart Factory</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>

            <a class="nav-link" style="color:white;"><?php echo $_SESSION["username"]; ?>&nbsp;</a>

            <form method="post">
                <button class="btn btn-outline-light" name="btn-logout" type="submit">Logout</button>
            </form>
        </nav>
    </header>

    <!--Sala -->
    <div class="container-fluid" id="dashboard-container">

        <?php if ($_SESSION["priv"] == 2) { ?>
        <div class="container text-center" style="padding-top:1%">
            <h2>Sensores</h2>
        </div>
        <hr>

        <form method="post" action="python/upload_image.py">
            <input type="submit" />
        </form>

        <div class="container">
            <div class="row d-flex justify-content-center text-center">

                <?php if (isset($sensores)) {
                    foreach ($sensores as $sensor) {
                        echo '
                <div class="col-md-3 m-3 d-flex justify-content-center text-center">
                    <div class="card card-' .
                            $sensor["estado"] .
                            '">
                    <h6 style="padding-top:10%">' .
                            $sensor["nome"] .
                            '</h6>
                        <span class="circle circle-' .
                            $sensor["estado"] .
                            '"></span>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <img src="' .
                            $sensor["imagem"] .
                            '" width="100" height="100" alt="' .
                            $sensor["nome"] .
                            '">
                        </div>
                        
                        <h6>' .
                            $sensor["valor"] .
                            '</h6>
                        <h6>' .
                            $sensor["hora"] .
                            '</h6>  
                        <div class="card-footer">
                            <a class="mb-5" href="./history.php?nome=' .
                            str_replace(" ", "", strtolower($sensor["nome"])) .
                            '&tipo=sensor">Histórico</a>
                        </div>
                    </div>
               </div>';
                    }
                } else {
                    echo "sem sensores";
                } ?>

            </div>
        </div>

        <div>
            <hr>
            <div class=" text-center">
                <h2>Atuadores</h2>
            </div>
        </div>
        <hr>

        <div>

            <div class="row d-flex justify-content-center text-center">

                <?php if (isset($atuadores)) {
                    foreach ($atuadores as $atuador) {
                        echo '
                    <div class="col-md-3 m-3 d-flex justify-content-center text-center">
                        <div class="card card-' .
                            $atuador["estado"] .

                            '"> 
                        <h6 style="padding-top:10%">' .
                            $atuador["nome"] .
                            '</h6>
                            <span class="circle circle-' .
                            $atuador["estado"] .
                            '"></span>
                            <div class="card-body d-flex justify-content-center align-items-center">
                            <img src="' .
                            $atuador["imagem"] .
                            '" width="100" height="100" alt="' .
                            $atuador["nome"] .
                            '">
                            </div>
							
                          
                            <div class="card-footer">
								<a class="mb-5" href="./history.php?nome=' .
                            str_replace(" ", "", strtolower($atuador["nome"])) .
                            '&tipo=atuador">Histórico</a>
							</div>
                        </div>
                   </div>';
                   
                    }
                } else {
                    echo "sem atuadores";
                } ?>

            </div>
        </div>
        <hr>

        <?php } ?>
        <div class="text-center" style="padding-top:1%">
            <h2>Máquinas</h2>
        </div>

        <hr>

        <div>
            <div class="row d-flex justify-content-center text-center">

                <?php if (isset($maquinas)) {
                    foreach ($maquinas as $maquina) {
                        echo '
                    <div class="col-md-3 m-3 d-flex justify-content-center text-center">
                        <div class="card card-' .
                            $maquina["estado"] .
                            '">
                        <h6 style="padding-top:10%">' .
                            $maquina["nome"] .
                            '</h6>
                            <span class="circle circle-' .
                            $maquina["estado"] .
                            '"></span>
                            <div class="card-body d-flex justify-content-center align-items-center">
                            <img src="' .
                            $maquina["imagem"] .
                            '" width="100" height="100" alt="' .
                            $maquina["nome"] .
                            '">
                            </div>
							
                        
                            <div class="card-footer">
								<a class="mb-5" href="./history.php?nome=' .
                            str_replace(" ", "", strtolower($maquina["nome"])) .
                            '&tipo=maquina">Histórico</a>
							</div>
                        </div>
                   </div>';
                    }
                } else {
                    echo "sem maquinas";
                } ?>

            </div>
        </div>

        <img src="webcam.jpg">
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>