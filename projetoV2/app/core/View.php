<?php

class View
{
    private $title = "";
	private $errors = [];

    public function renderView($layout, $view, $data=[])
    {
        /* Para mostrar uma página dentro de um layout primeiro obtemos o código que existe dentro do layout e da view 
        escolhida e no fim devolvemos o output da função str_replace em que dentro do código do layout alteramos a string
        "{{content}}" pelo código que existe dentro da view */

        /* Devido a usarmos o metodo "include" é possível aceder a informação que esteja armazenada numa variável dentro
         de cada ficheiro php chamado */

		$this->path=App::$app->router->getPath();

		// Adicionar ao obrjeto this todas os dados que estão armazenados na variável data
		if (!empty($data)){

			foreach ($data as $key=>$value){
				$this->{$key} = $value;
			}

		}

		$viewContent = $this->renderViewContent($view);

        $layoutContent = $this->layoutContent($layout);

		// A string {{content}} que está dentro do $layoutContent irá ser substituída pelo $viewContent

		return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    public function layoutContent($layout)
    {
        // Com a função ob_start conseguimos obter o que supostamente iria ser mostrado no browser que está no buffer
        ob_start();

        include_once App::$ROOT_DIR . "/views/layouts/" . $layout . ".php";

        return ob_get_clean();
    }

    public function renderViewContent($view)
    {
        // Com a função ob_start conseguimos obter o que supostamente iria ser mostrado no browser que está no buffer
        ob_start();

        include_once App::$ROOT_DIR . "/views/" . $view . ".php";

        return ob_get_clean();
    }

	// Adicionar um erro do tipo "type" ao objeto this

	public function addError($type, $string)
	{

		// Se não existir a key no array essa key irá ser criada para
		// posteriormente ser possível adicionar valores dentro dessa key
		// A key neste caso é a secção a que o erro corresponde
		// ex ( "auth", "dashboard" )

		if (!array_key_exists($type, $this->errors)) {
			$this->errors[$type] = [];
		}
		array_push($this->errors[$type], $string);

	}
}