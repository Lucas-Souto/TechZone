<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");

class ProductsController extends DatabaseConfig
{
	public function __construct(){
		parent::__construct();
	}

	public function insertNewProduct($data)
	{
		$sql = 'INSERT INTO products (name, price, description, image, quantity, category) VALUES (?, ?, ?, ?, ?, ?)';
		$statement = $this->dbh->prepare($sql);

		foreach ($data as $key => $value) $statement->bindValue($key + 1, $value[0], $value[1]);

		return $statement->execute();
	}

	public function deleteProduct($id)
	{
		$sql = 'DELETE FROM products WHERE id = ?';
		$statement = $this->dbh->prepare($sql);
		
		$statement->bindValue(1, $id, PDO::PARAM_STR);

		$result = $statement->execute();

		return $result ? $statement->rowCount() : 0;
	}

	public function getProductData($id)
	{
		$sql = 'SELECT * FROM products WHERE id = ?';
		$statement = $this->dbh->prepare($sql);

		$statement->bindValue(1, $id, PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function updateProduct($id, $data)
	{
		$sql = 'UPDATE products 
			SET name = IFNULL(?, name), 
			price = IFNULL(?, price), 
			description = IFNULL(?, description),
			image = IFNULL(?, image),
			quantity = IFNULL(?, quantity),
			category = IFNULL(?, category)
			WHERE id = ?';

		$statement = $this->dbh->prepare($sql);

		foreach ($data as $key => $value) $statement->bindValue($key + 1, $value[0], $value[1]);

		$statement->bindValue(count($data) + 1, $id, PDO::PARAM_STR);
		
		$result = $statement->execute();

		return $result ? $statement->rowCount() : 0;
	}

	public function getProducts()
	{
		$sql = 'SELECT * FROM products';
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>