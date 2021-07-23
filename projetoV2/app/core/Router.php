<?php

class Router
{
    /* O parâmetro "validRoutes" irá conter todas as routes validas para o método POST e o método GET  */

    protected array $validRoutes = [];

    public Request $request;

    public Response $response;

    /* Um obejto Router irá ter funções para o método "get" e "post" que iram ser chamados no ficheiro Routes.php
     quando o utilizador navegar pelo website */

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /* O parâmetro "route" irá conter a string com o valor da route chamada no url, o parâmetro restrict irá
    conter o valor true se a route for de acesso restrito e o parâmetro "callback" irá conter a função
    associada ao valor da variável route */

    public function get($route = null, bool $restrict=true ,$callback = null)
    {
		$this->validRoutes["get"][$route]["restrict"] = $restrict;
		$this->validRoutes["get"][$route]["callback"] = $callback;
    }

    public function post($route = null, bool $restrict=true, $callback = null)
    {
		$this->validRoutes["post"][$route]["restrict"] = $restrict;
		$this->validRoutes["post"][$route]["callback"] = $callback;
    }

    public function resolve()
    {
        $routeUrl = $this->request->getRouteUrl();
        $method = $this->request->getMethod();
		$callback = $this->validRoutes[$method][$routeUrl]["callback"] ?? false;
		$restrict = $this->validRoutes[$method][$routeUrl]["restrict"] ?? false;
		// Se o url corresponder ao url da api então iram ser feitas algumas alterações nas respostas
		$api = $this->isApi();
		// Se o utilizador estiver com sessão iniciada e tentar aceder a uma das páginas de login irá ser redirecionado
		// para o dashboard


		if (App::$app->isAuth() && ($routeUrl == "auth" || $routeUrl == "/")){
			$this->response->redirect("dashboard");
		}

		// Se a variável restrict estiver com o valor true quer dizer que a route não pode ser acedida sem o utilizador
		// estar com sessão iniciada

		if ($restrict && !App::$app->isAuth()) {

			// Se o pedido for restrito e o utilizador não estiver logado, para a api é necessário fazer login do utilizador
			// de forma diferente, pois o utilizador já não irá ter interface gráfica para o fazer

			return $this->response->setResponseCode(403, !$api);
		}

		// Se a variável callback for igual a false quer dizer que não existe nenhuma rota em Routes.php que corresponda ao
        // método $method nem ao url inserido
		if ($callback == false) {

			// Como a route não foi encontrada o mais apropriado é enviar um status code 404 (Page not found)
            return $this->response->setResponseCode(404, !$api);

        }

		if (!isset($_SESSION["priv"]) ){
			$_SESSION["priv"] = 0;
		}

		// Se a variável callback for uma string e não uma função então quer dizer que a variável tem o nome de uma view
        if (is_string($callback)) {
            return App::$app->view->renderView("main", $callback);

        }

        // Se for uma função então é usado uma função do php que serve para tratar a função que está armazenada na variável
        // como uma função e executar o seu contéudo
		return call_user_func($callback, $this->request, $this->response);

    }


	public function getPath()
	{
		$route=App::$app->request->getRouteUrl();

		$path="";

		if ($route != "/"){
			for ($i = 1; $i<count(explode("/",$route));$i++){
				$path=$path."../";
			}

		}
		return $path;
	}

	public function isApi(){

		$request = new Request();
		$url = $request->getRouteUrl();

		if (substr($url, 0, strlen("api/")) == "api/" ){
			return true;
		}

		return false;

	}
}