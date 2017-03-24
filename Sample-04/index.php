<?php
$mysqli = new mysqli( "localhost" , "test_username" , "test_password" , "oop_test" );
if( $mysqli->connect_errno ) {
	echo 'データベースアクセスエラー';
	exit;
}

$query = "INSERT INTO message (name, title, message, create_date) VALUES (\"ユーザー\", \"テスト\", \"メモメモ\", NOW() )";
if( $mysqli->query( $query ) ) {
	echo 'INSERT成功';
}
else {
	echo 'INSERT失敗';
}
$mysqli->close();
?>
