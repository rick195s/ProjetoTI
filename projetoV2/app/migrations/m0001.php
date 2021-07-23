<?php


class m0001
{
	public function up(){

		echo "A aplicar migração ". self::class . PHP_EOL ;

		$db = App::$app->db;

		// obter todas as queries que iram ser executadas
		$historyTable = $this->historyTable();
		$dispositivesTable = $this->devicesTable();
		$usersTable = $this->usersTable();

		$SQL = array($dispositivesTable, $historyTable, $usersTable);

		try {

			foreach($SQL as $query){
				$db->pdo->exec($query);
			}

		}catch (Exception $exception){
			die("Erro ao executer a migração ". self::class . PHP_EOL. " erro: ". $exception->getMessage());
		}


	}


	public function devicesTable(){

		$query = "CREATE TABLE IF NOT EXISTS devices(
    	id INT AUTO_INCREMENT PRIMARY KEY,
    	name VARCHAR(255) NOT NULL,
    	image VARCHAR(255) NULL, 
    	value VARCHAR(255) NULL, 
    	state INT NOT NULL, 
    	type VARCHAR(255) NOT NULL, 
    	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;";

		return $query;
	}

	public function historyTable(){

		$query = "CREATE TABLE IF NOT EXISTS history(
    	id INT AUTO_INCREMENT PRIMARY KEY,
    	device_id INT NOT NULL,
    	value VARCHAR(255) NULL, 
    	state INT NOT NULL,
    	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;";

		return $query;
	}

	public function usersTable(){

		$query = "CREATE TABLE IF NOT EXISTS users(
    	id INT AUTO_INCREMENT PRIMARY KEY,
    	username VARCHAR(255) NOT NULL,
    	password VARCHAR(255) NOT NULL,    	
    	privileges INT NOT NULL    	
		) ENGINE=INNODB;";

		return $query;
	}


	public function down()
	{
		echo "A eliminar dados da migração " .PHP_EOL;
		$db = App::$app->db;
		$SQL = "DROP TABLE users, dispositives, history;";
		$db->pdo->exec($SQL);
	}
}