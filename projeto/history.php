<?php

include "functions.php";

verifyAuth();

if (array_key_exists("btn-logout", $_POST)) {
    logout();
}

if (isset($_GET["nome"]) && isset($_GET["tipo"])) {
    /*$dispositivo = json_decode(
        file_get_contents("http://127.0.0.1/projeto/api/api.php?nome=" . $_GET["nome"] . "&tipo=" . $_GET["tipo"])
    );*/

    $dispositivo = getDisp($_GET["tipo"], $_GET["nome"]);
    /* Para mostrar o estado de cada entrada do histórico com a sua respetiva cor e descrição
     optamos por percorrer o vetor substituindo cada posição com o html pretendido */

    if ($dispositivo != null) {
        for ($i = 0; $i < count($dispositivo["historico"]); $i++) {
            switch ($dispositivo["historico"][$i][3]) {
                case 0:
                    $dispositivo["historico"][$i][3] =
                        '<span class="badge badge-pill badge-success">A funcionar</span>';
                    break;
                case 1:
                    $dispositivo["historico"][$i][3] =
                        '<span class="badge badge-pill badge-warning">Com problemas</span>';
                    break;

                case 2:
                    $dispositivo["historico"][$i][3] = '<span class="badge badge-pill badge-danger">Desativo</span>';
                    break;

                default:
                    $dispositivo["historico"][$i][3] =
                        '<span class="badge badge-pill badge-warning">Com problemas</span>';
                    break;
            }
        }
    } else {
        die("Dispositivio não encontrado");
    }
} else {
    die("Para a página histórico é necessário a existência dos parâmetros GET 'nome' e 'tipo' ");
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico - <?php echo $dispositivo["nome"]; ?> </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">


</head>

<body id="history-body">

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

    <div class="container-fluid  ">

        <div class="topnav   ">
            <h2 class="m-4"><?php echo $dispositivo["nome"]; ?></h2>
        </div>
        <hr>
        <div class="row">


            <?php echo '
                    <div class="col-md-12  d-flex justify-content-center text-center">
    
                        <div class="card card-' .
                $dispositivo["estado"] .
                '">
                            <span class="circle circle-' .
                $dispositivo["estado"] .
                '"></span>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <img src="' .
                $dispositivo["imagem"] .
                '" width="100" height="100" alt="' .
                $dispositivo["nome"] .
                '">
                            </div>
                    </div>
                    </div>'; ?>


        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-4">Histórico</h2>
            </div>
        </div>
        <div class="row mb-5">

            <div class="col-md-12">
                <table class="table" id="historyTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dispositivo["historico"] as $historico) {
                            echo '<tr>
                                    <td>' .
                                $historico[0] .
                                '</td>
                                    <td>' .
                                $historico[1] .
                                '</td>
                                    <td>' .
                                $historico[2] .
                                '</td>
                                    
                                </tr>';
                        } ?>
                    </tbody>
                </table>


            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
    $(document).ready(function() {
        $('#historyTable').dataTable();
    });
    </script>
</body>

</html>