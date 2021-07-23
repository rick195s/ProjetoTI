<?php

class Request
{
	/* Função que irá devolver a route introduzida no url */

	public function getRouteUrl()
	{
		// Como no ficheiro .htaccess estamos a associar o argumento $1 podemos aceder a esse
		// valor através da variável global de sessão "QUERY_STRING"

		$route = $_SERVER["QUERY_STRING"] != "" ? $_SERVER["QUERY_STRING"] : "/";

		$position = strpos($route, "&");

		// Se a função strpos returnar false isso quer dizer que não existem parâmetros no URL
		// Senão é devolvido a sub string da posição 0 até à posição da primeira ocurrência do
		// caracter '&'

		if ($position === false) {
			return $route;
		}

		return substr($route, 0, $position);
	}

	/* Função que irá verificar se o método do request é um get */

	public function isGet()
	{
		return $_SERVER["REQUEST_METHOD"] == "GET";
	}

	/* Função que irá verificar se o método do request é um post */

	public function isPost()
	{
		return $_SERVER["REQUEST_METHOD"] == "POST";
	}

	/* Função que irá devolver o método do request */

	public function getMethod()
	{
		return strtolower($_SERVER["REQUEST_METHOD"]);
	}

	/* Função que irá devolver todos os dados que foram enviados no pedido GET ou pedido POST*/

	public function getBody()
	{
		$body = [];


		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}

		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}


		return $body;


	}
}