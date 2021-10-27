<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");

class ShoppingCartController extends DatabaseConfig
{
	public function __construct(){
		parent::__construct();
	}

	public function insertNewItem($data)
	{
		$item = $this->getItemData($data[0][0], $data[1][0]);
		
		if (!empty($item))
		{
			$newQuantity = $data[2][0] + $item['productQuantity'];
			
			return $this->updateItem($data[0][0], $data[1][0], $newQuantity);
		}
		else
		{
			$sql = 'INSERT INTO shoppingCart (userEmail, productId, productQuantity) VALUES (?, ?, ?)';
			$statement = $this->dbh->prepare($sql);

			foreach ($data as $key => $value) $statement->bindValue($key + 1, $value[0], $value[1]);

			return $statement->execute();
		}
	}

	public function deleteItem($userEmail, $productId)
	{
		$sql = 'DELETE FROM shoppingCart WHERE userEmail = ? AND productId = ?';
		$statement = $this->dbh->prepare($sql);
		
		$statement->bindValue(1, $userEmail, PDO::PARAM_STR);
		$statement->bindValue(2, $productId, PDO::PARAM_INT);

		return $statement->execute();
	}

	public function getItemData($userEmail, $productId)
	{
		$sql = 'SELECT * FROM shoppingCart WHERE userEmail = ? AND productId = ?';
		$statement = $this->dbh->prepare($sql);
		
		$statement->bindValue(1, $userEmail, PDO::PARAM_STR);
		$statement->bindValue(2, $productId, PDO::PARAM_INT);
		$statement->execute();

		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function updateItem($userEmail, $productId, $newQuantity)
	{
		$sql = 'UPDATE shoppingCart 
			SET productQuantity = IFNULL(?, productQuantity)
			WHERE userEmail = ? AND productId = ?';

		$statement = $this->dbh->prepare($sql);

		$statement->bindValue(1, $newQuantity, PDO::PARAM_INT);
		$statement->bindValue(2, $userEmail, PDO::PARAM_STR);
		$statement->bindValue(3, $productId, PDO::PARAM_INT);
		
		$result = $statement->execute();

		return $result ? $statement->rowCount() : 0;
	}

	public function getItems($userEmail)
	{
		$sql = 'SELECT ShoppingCart.productQuantity, Products.id, Products.name, Products.price, Products.image, Products.quantity FROM shoppingCart 
			INNER JOIN products ON ShoppingCart.productId = Products.id
			WHERE ShoppingCart.userEmail = ?';
		$statement = $this->dbh->prepare($sql);

		$statement->bindValue(1, $userEmail, PDO::PARAM_STR);
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>