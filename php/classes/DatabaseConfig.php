<?php
class DatabaseConfig
{
	protected $dbh;

	protected function __construct()
	{
		$dbPath = dirname(__DIR__) . "\database.sqlite";
		$this->dbh = new PDO("sqlite:{$dbPath}");

		$this->createUsersTable();
		$this->createProductsTable();
		$this->createShoppingCartTable();
	}

	private function createUsersTable()
	{
		$this->dbh->exec('CREATE TABLE IF NOT EXISTS users (
			name VARCHAR(125) NOT NULL,
			surname VARCHAR(125) NOT NULL,
			email VARCHAR(150) PRIMARY KEY,
			cpf CHAR(14) NOT NULL,
			password VARCHAR(255) NOT NULL,
			additional TEXT NOT NULL,
			status VARCHAR(7) NOT NULL DEFAULT "user"
		)');
	}

	private function createProductsTable()
	{
		$this->dbh->exec('CREATE TABLE IF NOT EXISTS products (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			name VARCHAR(125) NOT NULL,
			price DECIMAL NOT NULL,
			description TEXT NOT NULL DEFAULT "Sem descrição... :(",
			image TEXT NOT NULL,
			quantity INTEGER DEFAULT 1,
			category VARCHAR(100) NOT NULL DEFAULT "other"
		)');
	}

	private function createShoppingCartTable()
	{
		$this->dbh->exec('CREATE TABLE IF NOT EXISTS shoppingCart (
			userEmail VARCHAR(150),
			productId INTEGER,
			productQuantity INTEGER NOT NULL DEFAULT 1,
			FOREIGN KEY(userEmail) REFERENCES Users(email),
			FOREIGN KEY(productId) REFERENCES Products(id)
		)');
	}
}
?>