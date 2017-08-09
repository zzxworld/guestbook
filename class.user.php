<?php
defined('VERSION') or die('deny access');

class UserRepeatEmailError extends Exception {};
class UserRepeatUsernameError extends Exception {};
class UserInvalidAccountError extends Exception {};
class UserInvalidPasswordError extends Exception {};

class User
{
	public static function encryptPassword($text)
	{
		return md5($text);
	}

	public static function create(array $params)
	{
		$db = DB::connect();

		$total = (int) DB::query('SELECT COUNT(id) FROM users WHERE email=?', [$params['email']])
			->fetch()[0];
		if ($total > 0) {
			throw new UserRepeatEmailError();
		}

		$total = (int) DB::query('SELECT COUNT(id) FROM users WHERE username=?', [$params['username']])
			->fetch()[0];
		if ($total > 0) {
			throw new UserRepeatUsernameError();
		}

		$password = self::encryptPassword($params['password']);

		$query = $db->prepare('INSERT INTO users(email, username, password, created_at)
			VALUES(:email, :username, :password, :created_at)');
		$query->bindParam(':email', $params['email']);
		$query->bindParam(':username', $params['username']);
		$query->bindParam(':password', $password);
		$query->bindParam(':created_at', date('Y-m-d H:i:s'));
		$query->execute();
	}

	public static function login($account, $password)
	{
		$db = DB::connect();

		if (isEmail($account)) {
			$query =  $db->prepare('SELECT id, username, password FROM users
				WHERE email=:account LIMIT 1');
		} else {
			$query =  $db->prepare('SELECT id, username, password FROM users
				WHERE username=:account LIMIT 1');
		}

		$query->bindParam(':account', $account);
		$query->execute();

		$user = $query->fetch(PDO::FETCH_ASSOC);
		if (!$user) {
			throw new UserInvalidAccountError;
		}

		if ($user['password'] != self::encryptPassword($password)) {
			throw new UserInvalidPasswordError;
		}

		return $user;
	}
}
