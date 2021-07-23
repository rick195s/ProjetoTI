<?php

class Database
{

	public PDO $pdo;

	/**
	 * Database constructor.
	 */
	public function __construct($config)
	{

		$dns = $config["DB_DNS"] ?? "";
		$user = $config["DB_USER"] ?? "";
		$password = $config["DB_PASSWORD"] ?? "";

		$this->pdo = new PDO($dns, $user, $password);

		/* Ao especificar estes atributos se ocorrer algum problema na conexão à base de dados esses erros
		iram ser apresentados */
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}



	public function tableName()
	{
		return "migrations";
	}

	public function applyMigrations()
	{
		// Para termos acesso às migrações já feitas anteriormente temos de criar uma tabela na
		// base de dados com essas informações

		$this->createMigrationsTable();

		// Para não serem feitas migrações já executadas primeiro temos de armazenar as migrações
		// que á foram executadas anteriormente

		$appliedMigrations = $this->getAppliedMigrations();

		$newMigrations = [];

		// Para posteriormente fazermos as migrações das tabelas temos de pesquisar na diretoria
		// "migrations" por migrações que possam ser feitas

		$files=scandir(App::$ROOT_DIR.'/migrations');


		$toApplyMigrations = array_diff($files,$appliedMigrations);

		foreach ($toApplyMigrations as $migration){
			if ($migration == '.' || $migration == '..'){
				continue;
			}

			require_once App::$ROOT_DIR.'/migrations/'.$migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);

			$instance = new $className();

			$instance->up();
			echo "Migração concluída ".$className .PHP_EOL;

			$newMigrations[] = $migration;
		}

		if (!empty($newMigrations)) {
			$this->saveMigrations($newMigrations);

		}else{
			echo "Todas as migrações foram executadas";
		}

	}

	/* Função que irá criar na base de dados uma tabela onde iram ser registadas as
	migrações executadas */

	public function createMigrationsTable()
	{
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations 
		(id INT AUTO_INCREMENT PRIMARY KEY,
		migration VARCHAR(255),
    	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    	) ENGINE=INNODB;");
	}
	// Função que irá devolver todas as migrações que estão armazendas na tabela
	// da base de dados

	public function getAppliedMigrations()
	{
		$statement = $this->pdo->prepare("SELECT migration FROM migrations");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}

	// Função que irá registar as migrações que são feitas


	public function saveMigrations(array $migrations)
	{
		$str =implode(",", array_map(fn($m) => "('$m')", $migrations));

		$statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");

		$statement->execute();
	}
}