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

		$time = date('Y-m-d H:i:s');
		$query = $db->prepare('UPDATE users SET logined_at=:time WHERE id=:id LIMIT 1');
		$query->bindParam(':time', $time);
		$query->bindParam(':id', $user['id'], PDO::PARAM_INT);
		$query->execute();

		return $user;
	}

	public static function find($id)
	{
		return DB::query('SELECT * FROM users WHERE id=? LIMIT 1', [$id])
			->fetch(PDO::FETCH_ASSOC);
	}

	public static function findAdmin()
	{
		return DB::query('SELECT * FROM users ORDER BY id ASC LIMIT 1')
			->fetch(PDO::FETCH_ASSOC);
	}

        public static function listOf(array $params = [])
        {
                $db = DB::connect();

                $page = (int) arrayFind($params, 'page', 1);
		$limit = (int) arrayFind($params, 'limit', 20);
                $total = (int) $db->query('SELECT COUNT(id) FROM users')->fetch()[0];
                $pagination = pagination($total, $limit, $page);
                $query = $db->prepare('SELECT * FROM users ORDER BY id DESC LIMIT :offset, :limit');
                $query->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);
                $query->bindParam(':limit', $pagination['limit'], PDO::PARAM_INT);
                $query->execute();

                return [
                        'items' => $query->fetchAll(PDO::FETCH_ASSOC),
                        'pagination' => $pagination,
                ];
        }

	public static function updatePermission(array $permissions, $id)
	{
		$db = DB::connect();

		$db->exec('DELETE FROM user_permissions WHERE user_id='.intval($id));
		$query = $db->prepare('INSERT INTO user_permissions(user_id, code) VALUES(:user_id, :code)');
		foreach ($permissions as $code) {
			$query->bindParam(':user_id', $id, PDO::PARAM_INT);
			$query->bindParam(':code', $code);
			$query->execute();
		}
	}
}
