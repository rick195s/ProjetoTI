<?php

abstract class Model
{

	/* Todas as classes que herdarem de Device iram ter que implementar uma função
	 tableName em que irá devolver o nome da tabela na base de dados  */

	abstract public function tableName();

	abstract public function create($object);


	public function loadData($data)
	{

		if (!empty($data)){
			foreach ($data as $key => $value) {
				if (property_exists($this, $key)) {
					$this->{$key} = $value;
				}
			}

		}

	}

	// Função que irá executer uma pesquisa à base de dados onde irá devolver
	// um elemento pedido

	public function select($data = [], $nameDisp = null)
	{
		// Elimina entradas no array inválidas ( null )
		$data = array_filter($data);

		// Armazenar o nome da tabela onde irá ser efetuada a pesquisa
		$table = $this->tableName();

		$sql = "SELECT * FROM $table WHERE ";

		if (!empty($data)) {

			$values = array_keys($data);
			// Adicionar na string query todos os valores recebidos separados por "AND"
			$sql .= implode(" AND ", array_map(fn($value) => "$value = :$value", $values));

		}

		$statement = $this->queryDb($sql, $data);

		if (empty($statement)){
			return null;

		}

		$results = $statement->fetchAll(PDO::FETCH_CLASS, static::class);

		// Se o dispositivo for um sensor então o valor do mesmo é alterado de forma a
		// ser apresnetado o tipo de valor, ou seja, percentagem, graus,etc

		foreach ($results as $result) {
			// Se $nameDisp for null então é enviado o valor de $result->name
			if (isset($result->name) || !empty($nameDisp)){
				$result->value .= Device::valueType(strtolower( $nameDisp ?? $result->name));
			}
		}

		return $results;

		}

	// Preparar uma query de sql para depois ser executada
	private function prepare($sql)
	{
		return App::$app->db->pdo->prepare($sql);
	}

	// Criar um dado obejeto na base de dados
	public function createObj($tableName, $objectArray){

		$sql = "INSERT INTO $tableName ";

		$values = array_keys($objectArray);

		$sql .= "(" .implode(", ", array_map(fn($value) => "$value", $values)) .")";

		$sql .= " VALUES ( ".implode(", ", array_map(fn($value) => ":$value", $values)). " )";

		$this->queryDb($sql,$objectArray);

	}

	protected function update($table, $objectArray, $where){

		$sql = "UPDATE ".$table. " SET ";

		$sql .= implode(", ", array_map(fn($value) => "$value = :$value", array_keys($objectArray)));
		$sql .= " WHERE " . implode(" AND ", array_map(fn($value) => "$value = :$value", array_keys($where)));

		$this->queryDb($sql,array_merge($objectArray,$where));
	}

	// Função que irá guardar o dispositivo ou histórico na base de dados
	public function save($where=[])
	{

		$tableName = $this->tableName();
		$this->date = date("Y-m-d H:i:s");

		$objectArray = (array) $this;


		if (!empty($where)){
			$this->update($tableName,$objectArray, $where);

		}else{
			$this->createobj($tableName,$objectArray);
			if (property_exists($this,"id")){
				$this->id = App::$app->db->pdo->lastInsertId();

			}
		}
	}

	private function queryDb($sql,$data)
	{

		$statement = $this->prepare($sql);

		foreach ($data as $key => $value) {
			$statement->bindValue(":$key", $value);
		}


		try {
			$statement->execute();

		} catch (Exception $exception) {
			App::$app->view->addError("database", $exception->getMessage());
			return null;
		}

		return $statement;
	}


}