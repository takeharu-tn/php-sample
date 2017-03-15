<?php
if (!isset($msg))
	$msg = "";
	?>
<html>
<body>
失敗です！<br>
原因：<?php echo $msg;?><br>
<input type="button" value="戻る" onclick="history.back();"><br>
</body>
</html>