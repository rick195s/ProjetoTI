<?php

/* Neste ficheiro iremos ter todas as routes para o nosso projeto, ou seja,
 todas os url que o utilizador poderá pesquisar na barra de pesquisa neste website
 
 Por exemplo se o utilizador pesquisar http://localhost/auth ele irá ser redirecionado para a route
 destinada ao tratamento do código, neste caso seria Route::set("auth" ,fucntion()) */

/* Para garantir que o utilizador não consegue aceder */

$app->router->get("/", false, [new AuthController(), "auth"]);

$app->router->get("auth", false,[new AuthController(), "auth"]);

$app->router->post("auth", false,[new AuthController(), "login"]);

$app->router->post("auth/logout", true,[new AuthController(), "logout"]);

$app->router->get("dashboard", true,[new DashboardController(), "dash"]);

$app->router->get("history", true, [new HistoryController(), "history"]);

$app->router->get("api/findDisp", true, [new ApiController(), "findDisp"]);

$app->router->get("api/findHist", true, [new ApiController(), "findHist"]);

$app->router->post("api/auth", false,[new ApiController(), "login"]);

$app->router->post("api/updateDisp", true, [new ApiController(), "updateDisp"]);

$app->router->post("api/uploadImage", true, [new ApiController(), "uploadImage"]);
/*
$app->router->post("api/deleteDisp", true, [new ApiController(), "deleteDisp"]);
*/
