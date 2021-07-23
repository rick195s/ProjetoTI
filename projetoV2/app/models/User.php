<?php

class User extends Model
{
	public $id;
	public $username;
	public $password;
	public $privileges;


	public function tableName()
	{
		return "users";
	}

	public function create($data){
		return null;
	}


	public function validateLogin()
	{

		$user = $this->findUser();

		if ($user != null) {

			$username = $this->username;
			$password = $user->password;

			// Verificar se a password que foi fornecida no login é válida para a hash da password
			// guardada na base de dados

			if (password_verify($this->password, $password)) {
				$_SESSION["username"] = $username;

				/* No array para cada utilizador colocamos uma entrada designada por "priv" --> privilégios
				que contém o nível de privilégios de cada utilizador.
				Se o login for efetuado com sucesso colocamos o valor dessa entrada numa variável global
				$_SESSION["priv"]
				*/
				$_SESSION["priv"] = $user->privileges;

				return true;
			} else {
				App::$app->view->addError("auth", "Utilizador ou Password incorretos");
				return false;
			}
		} else {
			App::$app->view->addError("auth", "Utilizador não encontrado");
			return false;
		}
	}

	// Procurar pelo utilizador
	public function findUser()
	{

		// Adicionar os parâmetros fornecidos pelo request ao objeto this ( USER )
		$this->loadData(App::$app->request->getBody());
		$user = $this->select(["username" => $this->username]);

		if (isset($user[0])) {
			return $user[0];
		}

		return null;
	}

}
