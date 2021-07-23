<?php

class HistoryController extends Controller
{
	public function history(Request $request, Response $response)
	{
		// Armazenar as variáveis enviadas através do método GET e POST

		$deviceModel = new Device();

		// Pesquisar pelo dispositivo na base de dados
		$device = $deviceModel->findDevice();

		// Se o dispositivo for encontrado então podemos devolver o mesmo para a view e mostrar a mesma
		if (!empty($device[0])) {
			$history = (new History)->findHistory($device[0]);
			return $this->view("main", "history", ["device" => $device[0], "history" => $history]);
		}

		// Caso contrário é adicionado um erro à view
		$this->addError("history", "O dispositivo não foi encontrado");

		return $this->view("main", "history");


	}
}