<?php

class Sensor extends Device
{
    public $value;

	public function create($data)
	{

		if (!isset($data["value"])){
			echo "O parâmetro 'value' é obrigatório" . PHP_EOL;
			return null;
		}


		$this->value = $data["value"];
		parent::create($data);

	}

}