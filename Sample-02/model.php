<?php
function dbaccess() {
	// コントローラに返すデータを初期化
	$result = array("", array());

	// パラメータの取得はコントローラでなくモデルの中でやった方がいいと思う。
	$t1 = $_POST["t1"];

	if ($t1 == "hoge") {
		$result[0] = "success";
	}
	else {
		$result[1]["msg"] = "よくわからないエラー";  // ビューに渡すデータ
		$result[0] = "failure";
	}

	return $result;
}
?>