<?php
/**
 * データベース（MySQL）アクセスのクラス
* (参考) http://www.bnote.net/php/php/09_db_class.shtml
*/
class DB {
	//////////////////////////////////////////////////
	//プロパティ
	//////////////////////////////////////////////////
	private $link_id;    //リンクID（MySQL接続ハンドル）
	private $result_id;    //結果セットID

	//////////////////////////////////////////////////
	//コンストラクタ
	//////////////////////////////////////////////////
	function __construct($server, $user, $password, $database) {
		$this->link_id = mysqli_connect($server, $user, $password, $database);
		if ($this->link_id) {
			if ($database != "") {
				$db = mysqli_select_db($this->link_id, $database);
				if (!$db) {
					mysql_close($this->link_id);
					return false;
				}
				return $this->link_id;
			}
		}
		return false;
	}

	//////////////////////////////////////////////////
	//メソッド
	//////////////////////////////////////////////////
	//SQLの実行
	function ExecuteSQL($sql) {
		if ($sql != "") {
			$this->result_id = mysqli_query($this->link_id, $sql);
			return $this->result_id;
		}
	}

	//結果セットID取得
	protected function GetResultID($result_id) {
		if (!$result_id) {
			return $this->result_id;
		}
		return $result_id;
	}

	//１行取得
	function FetchRow($result_id = 0) {
		$result_id = $this->GetResultID($result_id);
		if ($result_id) {
			$row = mysqli_fetch_array($result_id);
			return $row;
		}
		else {
			return false;
		}
	}

	//全行取得
	function FetchAll($result_id = 0) {
		$result_id = $this->GetResultID($result_id);
		if ($result_id) {
			while ($row = mysql_fetch_array($result_id)) {
				$rows[] = $row;
			}
			return $rows;
		}
		else {
			return false;
		}
	}

	/**
	 * SQLインジェクション対策　MySQLプリペアードステートメント関数
	 * (参考) http://www.php.net/manual/ja/function.mysql-query.php#70686
	 * @param  string $query
	 * @param  array  $phs //プレースホルダの配列
	 * @return string
	 */
	function mysql_prepare($query, $phs = array()) {
		$phs = array_map(create_function('$ph',
				'return "\'".mysql_real_escape_string($ph)."\'";'), $phs);

		$curpos = 0;
		$curph  = count($phs)-1;
		for ($i = strlen($query) - 1; $i > 0; $i--) {
			if ($query[$i] !== '?') {
				continue;
			}
			if ($curph < 0 || !isset($phs[$curph])) {
				$query = substr_replace($query, 'NULL', $i, 1);
			} else {
				$query = substr_replace($query, $phs[$curph], $i, 1);
			}
			$curph--;
		}
		unset($curpos, $curph, $phs);

		return $query;
	}
}
?>