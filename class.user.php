<?php
defined('VERSION') or die('deny access');

class UserAccountError extends Exception {};
class UserPasswordError extends Exception {};
class UserRepeatEmailError extends Exception {};
class UserRepeatUsernameError extends Exception {};

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

	}
}
