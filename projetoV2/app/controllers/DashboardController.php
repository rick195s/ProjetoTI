<?php

class DashboardController extends Controller
{
	public function dash()
	{

		$data = [];

		// Só os utilizadores com nível de acesso 2 (máximo) é que consegue ver no dashbaord
		// os atuadores
		$sensores = new Sensor();

		$data["deviceTypes"] = ["sensores" => ["title" => "Sensores", "devices" => $sensores->findDevice(["type" => "sensor"])]];

		if (intval($_SESSION["priv"]) >= 1 ) {

			$atuadores = new Atuador();

			$data["deviceTypes"] += [
				"atuadores" => ["title" => "Atuadores", "devices" => $atuadores->findDevice(["type" => "atuador"])],

			];
		}

		return $this->view("main", "dashboard", $data);

	}

}