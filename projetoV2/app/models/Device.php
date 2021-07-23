<?php

class Device extends Model
{

	public int $id;
	public string $name;
	public $image;
	public string $state;
	public string $type;
	public string $date;


	public function create($data)
	{


		if (!isset($data["name"]) || !isset($data["type"])) {
			echo "As propriedades 'name' e 'type' são obrigatórias" . PHP_EOL;

			return null;

		} else {
			/* O nome e a imagem do objeto irá ser igual ao fornecido. O estado será igual a 1
			, ou seja default yellow. */

			$this->name = $data["name"];
			$this->filterName();
			$this->type = $data["type"];
			$this->image = "";
			$this->state = 1;


			if (!empty($data["image"])) {
				$this->image = $data["image"];
			}

			if (isset($data["state"])) {
				$this->state = intval($data["state"]);
			}
		}
	}

	// Função que irá devolver o nome da tabela na base de dados de cada dispositivo

	public function tableName()
	{
		return "devices";
	}


	// Mudar o estado de numero para string de forma a que depois na view seja possível
	// adicionar a classe pretendida

	public function changestate($state)
	{
		switch ($state) {
			case 0:
				return "green";

			case 2:
				return "red";

			case 1:
			default:
				return "yellow";
		}

	}

	// Função que irá devolver a forma como o valor irá ser apresentado
	// exemplo: ºC, %, etc

	public static function valueType($name)
	{

		switch (true) {

			case substr($name, 0, strlen("tem")) == "tem":
				return 'ºC';

			case substr($name, 0, strlen("lum")) == "lum":
			case substr($name, 0, strlen("hum")) == "hum":
				return '%';

			default:
				return '';
		}
	}

	// Função que irá devolver um dispositivo caso seja fornecido o tipo e o nome
	// e irá devolver todos os despositivos caso seja só fornecido o tipo

	public function findDevice($data = [])
	{
		if ($this->validateRequest($data)) {

			if (isset($this->type)){
				$data = (array) $this;
			}


			// Selecionar todos os dispositivos encontrados na base de dados
			$devices = $this->select($data);

			if (!empty($devices)) {

				// Alterar o estado para ser apresentado em css
				foreach ($devices as $device) {

					if (strtolower($device->name) == "camara") {
						$device->image = "public/assets/images/armazem/imagemPrincipal.jpg";
					}

					$device->state = $this->changestate($device->state);
					$device->filterName();
					$device->linkName = strtolower($device->name);
					$device->filterName(true);
				}

				return $devices;

			}
		}


		return null;
	}

	// Função que irá validar se o request feito para obter as informações do Dispositivo
	// é válido

	private function validateRequest($data = [])
	{
		// Armazenar os dados que foram recebidos pelo metodo get no dispositivo
		$this->loadData(App::$app->request->getBody());

		$type = "";

		if (isset($data["type"])) $type = $data["type"];
		if (!empty($this->type)) $type = $this->type;

		if (($_SESSION["priv"] < 1 && "atuador" == $type) || empty($type) ) {

			return false;
		}

		return true;
	}


	public function deviceType($type)
	{

		switch ($type) {
			case "sensor":
				return new Sensor();

			case "atuador":
				return new Atuador();

			case "maquina":
				return new Maquina();

			default:
				return new Device();
		}
	}

	// Função que irá substituir os espaços ' ' no nome do dipositivo por '_'

	public function filterName($inverso = false)
	{
		if ($inverso) {

			$this->name = str_replace('_', ' ', $this->name);

		} else {

			$this->name = str_replace(' ', '_', $this->name);

		}

	}

	public function save($where = [])
	{


		if (isset($this->image) && $this->image == "") {
			unset($this->image);
		}


		$alreadyExists = $this->select(["name" => $this->name, "type" => $this->type]);

		if (!empty($alreadyExists[0]->id)) {

			$where = ["name" => $this->name, "type" => $this->type];
			$this->id = $alreadyExists[0]->id;

			parent::save($where);

		} else {
			parent::save();

		}
	}


}