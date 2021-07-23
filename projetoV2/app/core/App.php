<?php

/* App class. Usada para criar a aplicação e todas as propriedades e funções da mesma */

class App
{
	public Router $router;
	public Request $request;
	public static string $ROOT_DIR;
	public Response $response;
	public static App $app;
	public View $view;
	public Database $db;


	/* Ao istânciar esta classe  teremos de fornecer a path para a diretória main do projeto.
	 * Forma de na aplicação ser possível aceder a uma path global.*/

	public function __construct($rootPath)
	{
		$config = $this->init_config();

		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
		$this->db = new Database($config['db']);
		$this->request = new Request();
		$this->view = new View();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
	}

	/* Função que irá iniciar a aplicação  */
	public function run()
	{
		echo $this->router->resolve();
	}

	public function isAuth()
	{
		return isset($_SESSION["username"]);
	}

	// Filtragem dos dados presentes no ficheiro env para serem enviados posteriormente para a App

	private function init_config()
	{

		$path = dirname(__DIR__) . "/.env";


		if (file_exists($path)) {

			$file = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
			$config = [
				"db" => [],
			];

			for ($i = 0; $i < count($file); $i++) {

				$config["db"][$i] = explode("=", $file[$i], 2);
				$config["db"][$config["db"][$i][0]] = $config["db"][$i][1];
				unset($config["db"][$i]);

			}

			return $config;

		} else {
			echo "Ficheiro nao encontrado";
			return null;
		}
	}

}