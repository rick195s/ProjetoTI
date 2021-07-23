<?php


/* Como é necessário incluir ou requerir cada ficheiro de todas classes e modelos o php tem uma
 função já defenida em que facilita esse processo */

spl_autoload_register(function ($model_name) {
	if (file_exists("./app/core/" . $model_name . ".php")) {
		require_once "./app/core/" . $model_name . ".php";
	} elseif (file_exists("./app/models/" . $model_name . ".php")) {
		require_once "./app/models/" . $model_name . ".php";
	} elseif (file_exists("./app/controllers/" . $model_name . ".php")) {
		require_once "./app/controllers/" . $model_name . ".php";
	} else {
		echo "Ficheiro não existe";
	}
});


// Criação de uma variável do tipo "App"

$app = new App(__DIR__ );

$app->db->applyMigrations();

