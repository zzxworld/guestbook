<?php
defined('VERSION') or die('deny access');

class Comment
{
	protected static $cacheUsers = [];

	public static function find($id)
	{
		$query = DB::query('SELECT * FROM comments WHERE id=? LIMIT 1', [$id]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}


	public static function create(array $data)
	{
		$db = DB::connect();

		$data['ip'] = ip2long($data['ip']);

		$query = $db->prepare('INSERT INTO comments(user_id, ip, content, created_at) VALUES(:user_id, :ip, :content, :created_at)');
		$query->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
		$query->bindParam(':ip', $data['ip'], PDO::PARAM_INT);
		$query->bindParam(':content', $data['content'], PDO::PARAM_STR);
		$query->bindParam(':created_at', $data['created_at'], PDO::PARAM_STR);
		$query->execute();
	}

	public static function update($id, array $data)
	{
		$db = DB::connect();

		$query = $db->prepare('UPDATE comments SET content=:content, updated_at=:updated_at WHERE id=:id');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
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

	public static function formatUser($userId)
	{
		if (!isset(self::$cacheUsers[$userId])) {
			$user = User::find($userId);
			if ($user) {
				self::$cacheUsers[$userId] = $user;
			} else {
				self::$cacheUsers[$userId] = ['username' => '无名氏'];
			}
		}
		return self::$cacheUsers[$userId]['username'];
	}

    public static function formatDateToReadable($strTime)
    {
        $time = time() - strtotime($strTime);

        $days = floor($time/86400);
        if ($days > 0) {
            return $days.'天前';
        }

        $hours = floor($time/3600);
        if ($hours > 0) {
            return $hours.'小时前';
        }

        $minutes = floor($time/60);
        if ($minutes > 0) {
            return $minutes.'分钟前';
        }

        return '刚刚';
    }

	public static function formatIP($intIP)
	{
		return long2ip($intIP);
	}


	public static function denyPublicBy($ip)
	{
		$ip = ip2long($ip);
		$comment = DB::query('SELECT created_at FROM comments WHERE ip=? ORDER BY id DESC LIMIT 1', [$ip])
			->fetch(PDO::FETCH_ASSOC);
		if (!$comment) {
            		return false;
        	}
        	return (time() - strtotime($comment['created_at'])) < Config::get('PUBLIC_FREQ');
	}
}
