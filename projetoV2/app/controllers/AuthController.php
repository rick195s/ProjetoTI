<?php

class AuthController extends Controller
{

	// Função que irá proceder do login do utilizador

	public function login(Request $request, Response $response)
    {
        $userModel = new User();

        // Como o login só pode ser executado se o request method for do tipo
		// "POST" primeiro verificamos essa condição

        if ($request->isPost()) {
        	// Adicionar ao objeto this todos os valores que foram enviados através
			// do método recebido

            $userModel->loadData($request->getBody());

            // Validação do login
            if (!$userModel->validateLogin()) {

				// É renderizado a view "login" onde enviamos os erros que foram adicionados

				return $this->view("minimal", "login");

            } else {
            	// Se o login for true então o utilizador é redirecionado para o
				// dashboard

				$response->redirect("dashboard");
				return true;
            }
        } else {
        	// Se o método for direferente de POST então o utilizador é redirecionado
			// para a route "/"
			 $response->redirect("/");
        }
    }

    // Função que irá fazer o logout do utilizador

    public function logout()
    {
        session_unset();
        session_destroy();

        App::$app->response->redirect("../auth");
    }


    /* Esta função ao ser chamada irá denderizar a página de login */

    public function auth()
    {

        return $this->view("minimal", "login");
    }
}