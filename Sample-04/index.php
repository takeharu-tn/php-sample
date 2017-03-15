<?php
# No. 01
$mysqli = new mysqli( "localhost" , "testuser" , "testpassword" , "oop_test" );
# No. 02
if( $mysqli->connect_errno ) {
	echo 'データベースアクセスエラー';
	exit;
}

# No. 03
$query = "INSERT INTO message (name, title, message, create_date) VALUES (\"ユーザー\", \"テスト\", \"メモメモ\", NOW() )";
# No. 04
if( $mysqli->query( $query ) ) {
	echo 'INSERT成功';
}
else {
	echo 'INSERT失敗';
}
$mysqli->close();
?>
解説
# No. 01