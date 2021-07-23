<?php

class Controller
{

    public function view($layout, $view, $data = [])
    {
        return App::$app->view->renderView($layout, $view, $data);
    }

	public function addError($type, $string)
	{
		App::$app->view->addError($type, $string);
	}

}