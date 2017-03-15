<?php
// コントローラ
// ユーザが最初にアクセスするphp。
// index.phpという名前にしてもよい。

require_once("model.php");

session_start();

function redirect($pagename) {
	if (headers_sent()) {
		exit("Error: redirect: Already header has sent!");
	}

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/$pagename");
	exit;
}

// action は必ず GET で渡す。
// POST を一切使いたくない画面もあるから。
if (array_key_exists("action", $_GET))
	$action = $_GET["action"];
	else
		$action = "";

		switch ($action) {
			case "":
				require_once("view.php");       // 初期表示
				break;

			case "dbaccess":
				$result   = dbaccess();

				$nextpage = $result[0];
				$_SESSION["data"] = $result[1]; // ビューに渡すデータ

				switch ($nextpage) {
					case "success":
						redirect("success.php");    // 成功画面表示
						break;

					case "failure":
						redirect("failure.php");    // 失敗画面表示
						break;
				}
				break;

			default:
				echo "action の値が変です: [{$action}]";
				break;
		}

?>
