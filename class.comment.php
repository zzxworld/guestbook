<?php
defined('VERSION') or die('deny access');

class Comment
{

	public static function find($id)
	{
		$query = DB::query('SELECT * FROM comments WHERE id=? LIMIT 1', [$id]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}


	public static function create(array $data)
	{
		$db = DB::connect();

		$query = $db->prepare('INSERT INTO comments(email, ip, username, content, created_at) VALUES(:email, :ip, :username, :content, :created_at)');
		$query->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$query->bindParam(':ip', $data['ip'], PDO::PARAM_STR);
		$query->bindParam(':username', $data['username'], PDO::PARAM_STR);
		$query->bindParam(':content', $data['content'], PDO::PARAM_STR);
		$query->bindParam(':created_at', $data['created_at'], PDO::PARAM_STR);
		$query->execute();
	}

	public static function update($id, array $data)
	{
		$db = DB::connect();

		$query = $db->prepare('UPDATE comments SET email=:email, username=:username, content=:content, updated_at=:updated_at WHERE id=:id');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$query->bindParam(':username', $data['username'], PDO::PARAM_STR);
		$query->bindParam(':content', $data['content'], PDO::PARAM_STR);
		$query->bindParam(':updated_at', $data['updated_at'], PDO::PARAM_STR);
		$query->execute();
	}

	public static function destroy($id)
	{
		DB::query('DELETE FROM comments WHERE id=? LIMIT 1', [$id]);
	}

	public static function listOf(array $params = [])
	{
		$db = DB::connect();

		$page = (int) arrayFind($params, 'page', 1);
		$total = (int) $db->query('SELECT COUNT(id) FROM comments')->fetch()[0];
		$pagination = pagination($total, Config::get('PAGINATION_LIMIT'), $page);
		$query = $db->prepare('SELECT * FROM comments ORDER BY id DESC LIMIT :offset, :limit');
		$query->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);
		$query->bindParam(':limit', $pagination['limit'], PDO::PARAM_INT);
		$query->execute();

		return [
			'items' => $query->fetchAll(PDO::FETCH_ASSOC),
			'pagination' => $pagination,
		];
	}

	public static function formatContent($text)
	{
		return nl2br($text);
	}

	public static function formatDate($strTime)
	{
		return date('Y-m-d H:i:s', strtotime($strTime));
	}

	public static function formatIP($intIP)
	{
		return long2ip($intIP);
	}


	public static function denyPublicBy(array $data)
	{
		$ip = arrayFind($data, 'ip');
		$comment = DB::query('SELECT created_at FROM comments WHERE ip=? ORDER BY id DESC LIMIT 1', [$ip])->fetch(PDO::FETCH_ASSOC);
		if ($comment) {
			return (time() - strtotime($comment['created_at'])) < Config::get('PUBLIC_FREQ');
		}
		return true;
	}
}
