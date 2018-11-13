<?php

namespace core\database;

use core\SingletonTrait;
use PDO;

class connection
{
	use SingletonTrait;

	private $pdo;

	private function __construct()
	{
		$host = get_config('main.database.host');
		$dbname = get_config('main.database.name');
		$user = get_config('main.database.username');
		$pass = get_config('main.database.password');
		$this->pdo = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
	}

	public function query($sql)
	{
		$statement = $this->pdo->query($sql);
		if ($statement) {
			return $statement->fetchALL(PDO::FETCH_ASSOC);
		}
		return null;
	}
}