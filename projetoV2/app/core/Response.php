<?php

class Response
{
	// Função que irá devolver a string para cada código de erro
	public function responseCode(int $code = 200)
	{
		switch ($code) {
			case 200:
				return "Sucesso" .PHP_EOL;

			case 400:
				return "Parâmetros inválidos".PHP_EOL;

			case 401:
				return "Autentificação falhada".PHP_EOL;

			case 403:
				return "Acesso negado".PHP_EOL;

			case 404:
				return "Device não encontrado ou url inválido".PHP_EOL;

			case 413:
				return "Ficheiro demasiado grande".PHP_EOL;

			default:
				return null;
		}
	}


	/* Função que irá alterar o código de resposta quando um pedido é efetuado ao website */

	public function setResponseCode(int $code, bool $render = true)
	{
		http_response_code($code);

		if ($render) {
			return App::$app->view->renderView("minimal", $code);

		} else {
			return $this->responseCode($code);
		}

	}


	/* Função que irá redirecionar o utilizador para outro url */

	public function redirect($route)
	{

		header("Location: " . $route);
	}
}