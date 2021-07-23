<?php


class ApiController
{
	public static function findDisp(Request $request, Response $response)
	{
		// Procurar pelo dispositivo na base de dados
		$result = (new Device)->findDevice();


		// Caso seja encotrado um dispositivo, o valor desse mesmo dispositivo é devolvido

		if (isset($result[0])) {
			// Se o dispositivo for um atuador então é devolvido o seu estado atual
			// pois o atuador não tem um valor

			if ($result[0]->type == "atuador") {
				return json_encode($result[0]->state);

			} else {
				return json_encode($result[0]->value);

			}
		}

		// Caso o dispositivo não seja encontrado é alterado o código de resposta
		return $response->setResponseCode(404, false);
	}

	public static function findHist(Request $request, Response $response)
	{

		// Procurar pelo dispositivo na base de dados
		$result = (new Device())->findDevice();

		if (isset($result[0])) {
			$history = (new History)->findHistory($result[0]);
			return json_encode($history);
		}

		// Caso o dispositivo não seja encontrado é alterado o código de resposta
		return $response->setResponseCode(404, false);
	}

	public function updateDisp(Request $request, Response $response)
	{
		// Só o admin pode atualizar um dispositivo
		if ($_SESSION["priv"] < 2){
			return $response->setResponseCode( 403,false);
		}

		// Criar um obejto do tipo fornecido
		$device = (new Device)->deviceType($_POST["type"] ?? "");
		$device->create($request->getBody());

		// Caso ocorra algum erro durante a execução o response code é alterado
		if (empty($device->name)) {

			return $response->setResponseCode(400, false);
		}


		$device->save();
		$history = new History();
		$history->create( (array) $device);
		$history->save();

		return $response->setResponseCode(200, false);
	}

	// Login mais especifico para a api em que só é devolvido uma mensagem para cada tipo de
	// response code

	public function login(Request $request, Response $response)
	{

		$auth = (new AuthController)->login($request, $response);

		if ($auth === true) {
			return $response->setResponseCode(200, false);

		}

		return $response->setResponseCode(403, false);
	}

	public function uploadImage(Request $request, Response $response){

		// Só o operador e o admin têm acesso a enviar imagem para o dashboard
		if ($_SESSION["priv"] < 1){
			return $response->setResponseCode( 403,false);
		}

		if (isset($_FILES["image"])){
			$file = $_FILES['image'];


			$array = explode('.', $file['name']);
			$extension = end($array);

			// Os ficheiros que não tenham a extensão png ou jpg
			// são negados
			if ($extension != "jpg" && $extension != "png"){
				echo "Extensão de imagem inválida".PHP_EOL;

				return $response->setResponseCode(413,false);
			}

			// Os ficheiros enviados atraves da api não poderam ser maiores
			// do que 1MB
			if (filesize($file["tmp_name"]) > 1024000){

				return $response->setResponseCode(413,false);
			}

			move_uploaded_file($file["tmp_name"], "assets/images/foto_armazem.jpg");

			return $response->setResponseCode(200,false);

		}

	}


}