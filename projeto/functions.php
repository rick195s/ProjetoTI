<?php

session_start();

function login($username, $password)
{
    /* Para validar a autentificação decidimos criar um array multidimensional
  com a password e os privilégios de cada utilizador
  */

    $login = [
        "Admin" => [
            "password" => "cisco",
            "priv" => 2,
        ],

        "Operador" => [
            "password" => "cisco",
            "priv" => 1,
        ],
    ];

    /* Primeiro estamos a verificar se o username e a password foram enviados
     através do método POST */

    if (isset($username) && isset($password)) {
        /* Verificar se a password existe para o utilizador fornecido como estamos a usar um
    "and" caso essa posição não exista no array o if não irá verificar a segunda condição 
    logo não dá o erro de estarmos a aceder a uma posição do array que não exista. 
    
    Com isto conseguimos também verificar se o utilizador existe ( se não existir não consegue ir 
    buscar a password ao array, logo dá false ) e verificar se a password está correta*/

        if (isset($login[$username]["password"]) && $login[$username]["password"] == $password) {
            $_SESSION["username"] = $username;

            /* No array para cada utilizador colocamos uma entrada designada por "priv" --> privilégios
      que contém o nível de privilégios de cada utilizador. 
      Se o login for efetuado com sucesso colocamos o valor dessa entrada numa variável global
      $_SESSION["priv"]
      */

            $_SESSION["priv"] = $login[$username]["priv"];

            return true;
        } else {
            return false;
        }
    }
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: index.php");
}

// Caso a variável global $_SESSION não tenha o campo username é apresentado uma mensagem de erro

function verifyAuth()
{
    if (!isset($_SESSION["username"])) {
        header("Location: 403.php");
    }
}

// O utilizador so podera alterar o valor dos sensores se estiver autenticado

function addValues()
{
    $dirname = dirDisp($_POST["tipo"], $_POST["nome"]);
    /* O que caracteriza a existência de um sensor é a existência de uma pasta para o mesmo
    na diretoria "files" e todos os ficheiros com os respetivos valores. 
    
    Como a função "file_puts_contents" não cria um diretório caso a diretoria onde o ficheiro 
    vai ser criado não existe, primeiro temos de verificar essa condição e caso seja necessário 
    criar o diretorio  */

    if (!is_dir($dirname)) {
        mkdir($dirname);
    }

    file_put_contents($dirname . "/valor.txt", $_POST["valor"]);
    file_put_contents($dirname . "/hora.txt", date("Y/m/d H:i:s"));
    file_put_contents($dirname . "/estado.txt", $_POST["estado"]);
    file_put_contents($dirname . "/nome.txt", $_POST["nome"]);

    /* Como a função file_put_contents não cria o ficheiro quando a flag "FILE_APPEND" esteja
     especificada caso o ficheiro não exista temos de reterir a flag pois dessa forma o ficheiro
     já é criado */

    if (file_exists($dirname . "/log.txt")) {
        $flags = FILE_APPEND;
    } else {
        $flags = -1;
    }

    if ($_POST["estado"] !== "" && $_POST["estado"] <= 2 && $_POST["estado"] >= 0) {
        $estado = $_POST["estado"];
    } else {
        $estado = 1;
    }

    /* Os dados que são acrescentados ao ficheiro log são separados por ';' */

    file_put_contents(
        $dirname . "/log.txt",
        date("Y/m/d;H:i:s") . ";" . $_POST["valor"] . ";" . $estado . PHP_EOL,
        $flags
    );
}

/* Para um sensor existir precisa de ter uma diretoria com o seu nome em lower case e dentro dessa
 diretoria tem de existir x ficheiros com os valores do mesmo*/

function dispExiste($dirname)
{
    $dirname = strtolower($dirname);

    if (
        file_exists($dirname . "/nome.txt") &&
        file_exists($dirname . "/valor.txt") &&
        file_exists($dirname . "/hora.txt") &&
        file_exists($dirname . "/estado.txt") &&
        file_exists($dirname . "/log.txt")
    ) {
        return true;
    } else {
        return false;
    }
}

/* Esta função tem a responsabilidade de returnar uma string com o diretorio do tipo de dispositivo */

function dirType($tipo)
{
    switch ($tipo) {
        case "sensor":
            return __DIR__ . "/api/files/sensores/";
            break;
        case "atuador":
            return __DIR__ . "/api/files/atuadores/";
            break;
        case "maquina":
            return __DIR__ . "/api/files/maquinas/";
            break;
        default:
            return null;
            break;
    }
}
/* Esta função tem a responsabilidade de returnar uma string com o diretorio do dispositivo */

function dirDisp($tipo, $nome)
{
    $dirType = dirType($tipo);

    if ($dirType != null) {
        return $dirType . str_replace(" ", "", strtolower($nome));
    } else {
        return null;
    }
}

/* Esta função irá devolver um array com o historico, estado, nome e imagem do dispositivo
 indicado */

function getDisp($tipo, $nome)
{
    if ($tipo != "" && $nome != "") {
        $dirname = dirDisp($tipo, $nome);

        /* Verificamos se o dispositivo existe e caso não exista  */
        if (dispExiste($dirname)) {
            //     $dispositivo["nome"] = trim(file_get_contents($dirname . "/nome.txt"));
            //     $dispositivo["valor"] = file_get_contents($dirname . "/valor.txt");
            //     $dispositivo["estado"] = changeState(file_get_contents($dirname . "/estado.txt"));
            //     /* A função file() lê o ficheiro e cada linha do ficheiro é guardado
            //      numa posição do array */

            //     $log = file($dirname . "/log.txt");
            //     for ($i = 0; $i < count($log); $i++) {
            //         $historicos[$i] = explode(";", $log[$i]);
            //         if (!isset($historicos[$i][3])) {
            //             $historicos[$i][3] = 1;
            //         }
            //     }

            //     $dispositivo["historico"] = $historicos;
            //     $dispositivo["imagem"] =
            //         "./images/" . $tipo . "/" . str_replace(" ", "", strtolower($dispositivo["nome"])) . ".png";

            return file_get_contents($dirname . "/valor.txt");
        } else {
            return null;
        }
    } else {
        return null;
    }
}

/* Esta função irá devolver um array com todos os dispositivos encontrados na diretoria indicada
 (sensores, atuadores ou maquinas) */

function getDisps($tipo)
{
    if ($tipo != "") {
        $dirname = dirType($tipo);

        /* Primeiro temos de verificar se a diretoria dos sensores ou atuadores existe e só depois podemos
         dar scan a essa pasta para verificar quantos sensores ou atuadores existem */

        if (is_dir($dirname)) {
            $dirs = array_values(array_diff(scandir($dirname), ["..", "."]));

            if (!empty($dirs)) {
                for ($i = 0; $i < count($dirs); $i++) {
                    if (dispExiste(dirDisp($tipo, $dirs[$i]))) {
                        $dispositivos[$i]["nome"] = trim(file_get_contents($dirname . $dirs[$i] . "/nome.txt"));
                        $dispositivos[$i]["valor"] = file_get_contents($dirname . $dirs[$i] . "/valor.txt");
                        $dispositivos[$i]["hora"] = file_get_contents($dirname . $dirs[$i] . "/hora.txt");
                        $dispositivos[$i]["estado"] = changeState(
                            file_get_contents($dirname . $dirs[$i] . "/estado.txt")
                        );
                        $dispositivos[$i]["imagem"] =
                            "./images/" .
                            $tipo .
                            "/" .
                            str_replace(" ", "", strtolower($dispositivos[$i]["nome"])) .
                            ".png";
                    }
                }

                return $dispositivos;
            } else {
                return null;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

/* Como cada sensor irá ter um estado decidimos criar classes de css alterando a cor de cada card 
consoante cada estado do sensor e para cada valor do estado associamos uma cor
0 --> green, 1 --> yellow, 2 --> red  */

function changeState($value)
{
    switch ($value) {
        case 0:
            return "green";
            break;
        case 1:
            return "yellow";
            break;
        case 2:
            return "red";
            break;

        default:
            return "yellow";
            break;
    }
}

?>