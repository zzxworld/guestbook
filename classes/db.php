<?php
defined('VERSION') or die('deny access');

class DB
{
	protected static $connection = null;

	public static function connect()
	{
		if (!self::$connection) {
			$dsn = 'mysql:host='.Config::get('DB_HOST').';dbname='.Config::get('DB_NAME').';charset='.Config::get('DB_CHARSET');
			self::$connection = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASS'), [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			]);
		}
		return self::$connection;
	}

	public static function query($sql, array $arguments = [])
	{
		self::connect();
		$query = self::$connection->prepare($sql);
		$query->execute($arguments);
		return $query;
	}
}
