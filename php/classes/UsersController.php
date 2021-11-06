<?php
require(dirname(__DIR__) . "/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/functions/getName.php");

class UsersController extends DatabaseConfig
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insertNewUser($data)
	{
		$sql = 'INSERT INTO users (name, surname, email, cpf, password, additional, status) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$statement = $this->dbh->prepare($sql);

		foreach ($data as $key => $value) $statement->bindValue($key + 1, $value, PDO::PARAM_STR);

		return $statement->execute();
	}

	public function deleteUser($email)
	{
		$sqls = 
		[
			'DELETE FROM shoppingCart WHERE userEmail = :email',
			'DELETE FROM users WHERE email = :email'
		];
		$result = true;

		foreach ($sqls as $sql)
		{
			$statement = $this->dbh->prepare($sql);
		
			$statement->bindValue(':email', $email, PDO::PARAM_STR);

			$result = $result && $statement->execute();
		}

		return $statement->execute();
	}

	public function getUserData($email)
	{
		$sql = 'SELECT name, surname, email, cpf, additional FROM users WHERE email = ?';
		$statement = $this->dbh->prepare($sql);

		$statement->bindValue(1, $email, PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function validateUser($email, $password)
	{
		$sql = 'SELECT name, surname, password, status FROM users WHERE email = ?';
		$statement = $this->dbh->prepare($sql);

		$statement->bindValue(1, $email, PDO::PARAM_STR);
		$statement->execute();

		$data = $statement->fetch(PDO::FETCH_ASSOC);
		$success = password_verify($password, $data['password']);

		if ($success) return array('fullname' => getName($data['name'], $data['surname']), 'status' => $data['status']);
		else return false;
	}

	public function updateUser($email, $data)
	{
		$sql = 'UPDATE users 
			SET name = ?, 
			surname = ?, 
			email = ?, 
			password = IFNULL(?, password), 
			additional = ?,
			status = ? 
			WHERE email = ?';

		$statement = $this->dbh->prepare($sql);

		foreach ($data as $key => $value) $statement->bindValue($key + 1, $value, PDO::PARAM_STR);

		$statement->bindValue(count($data) + 1, $email, PDO::PARAM_STR);
		
		$result = $statement->execute();

		return $result ? $statement->rowCount() : 0;
	}

	public function updateUserForAdmin($email, $data)
	{
		$sql = 'UPDATE users 
			SET email = ?, 
			cpf = IFNULL(?, cpf),
			password = IFNULL(?, password),
			status = ? 
			WHERE email = ?';

		$statement = $this->dbh->prepare($sql);

		foreach ($data as $key => $value) $statement->bindValue($key + 1, $value, PDO::PARAM_STR);

		$statement->bindValue(count($data) + 1, $email, PDO::PARAM_STR);
		
		$result = $statement->execute();

		return $result ? $statement->rowCount() : 0;
	}
}
?>