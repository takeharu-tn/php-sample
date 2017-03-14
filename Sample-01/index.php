<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHPテスト</title>
</head>
<body>

		<p>PHPで作ったサンプル①</p>

		<p>
		<?php
		$result[0] = 85;
		$result[1] = 92;
		$result[2] = 68;

		for ($i = 0; $i < 3; $i++){
			print $result[$i].'<br />';
		}
		?>
</p>

</body>
</html>