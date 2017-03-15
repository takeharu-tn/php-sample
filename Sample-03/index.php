<?php
//Initialize
require_once("config.php");
require_once("db.php");
$db = new DB(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
$db->ExecuteSQL('SET CHARACTER SET utf8');
$max = 10;//１ページ当たりの最大表示件数

//request
$action     = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : null;
$page     = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : null;
$message_id     = isset($_GET['message_id']) ? htmlspecialchars($_GET['message_id']) : null;
$name     = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : null;
$title     = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : null;
$message     = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : null;

//controller
switch ($action) {
	//メッセージ一覧
	case 'list':
		//ページ送り（ページ数は１から数える）
		$sql = "SELECT count(*) AS total FROM message";
		$result_id = $db->ExecuteSQL($sql);
		$row = $db->FetchRow($result_id);
		$total = $row['total'];//全メッセージ数
		$page_total = ceil($total / $max);//全ページ数
		if ($page < 1) $page = 1;
		if ($page_total < $page) $page = $page_total;
		$pager = range(1, $page_total);

		//メッセージ取得
		if (0 < $total) {
			$sql = "SELECT * FROM message
                ORDER BY create_date DESC
                LIMIT ".(($page - 1) * $max) .",".$max;
			$result_id = $db->ExecuteSQL($sql);
			$message = $db->FetchAll($result_id);
			foreach ($message as $key => $value) {
				$message[$key]['name']  = htmlspecialchars($value['name']);
				$message[$key]['title'] = htmlspecialchars($value['title']);
			}
		}

		//表示
		$view = array(
				'page'    => $page,
				'total'   => $total,
				'pager'   => $pager,
				'message' => $message,
		);
		include("list.html");
		break;

		//メッセージ詳細
	case 'message':
		//メッセージ詳細
		$sql = "SELECT * FROM message WHERE message_id = ?";
		$phs = array($message_id);
		$sql_prepare = $db->mysqli_prepare($sql, $phs);
		$result_id = $db->ExecuteSQL($sql_prepare);
		$row = $db->FetchRow($result_id);

		//表示
		$view = array(
				'name'        => htmlspecialchars($row['name']),
				'title'       => htmlspecialchars($row['title']),
				'message'     => nl2br(htmlspecialchars($row['message'])),
				'create_date' => $row['create_date'],
		);
		include("message.html");
		break;

		//メッセージ入力
	case 'input':
		//バリデート
		if (0 < strlen($name) && 0 < strlen($title) && 0 < strlen($message)) {
			//DB保存
			$create_date = date("Y/m/d H:i:s");
			$sql = "INSERT message SET
                name = ?,
                title = ?,
                message = ?,
                create_date = ?";
			$phs = array(
					$name,
					$title,
					$message,
					$create_date
			);
			$sql_prepare = $db->mysqli_prepare($sql, $phs);
			$result_id = $db->ExecuteSQL($sql_prepare);
			//表示
			include("index.html");
		}
		else {
			//再入力
			//表示
			$view = array(
					'name'    => htmlspecialchars($name),
					'title'   => htmlspecialchars($title),
					'message' => htmlspecialchars($message),
			);
			include("input.html");
		}
		break;

		//トップページ
	default:
		//表示
		include("index.html");
		break;
}
?>