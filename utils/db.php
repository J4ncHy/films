<?php
class DB{

    function __construct($user="root",$server="localhost", $password="", $database="filmi", $port=3306){
        $this -> error = "";
		$this -> errno = 0;
		$this -> conn = mysqli_connect($server, $user, $password, $database, $port);//Baza::$serverPort);
		if(mysqli_connect_errno()) {
			$this->errno = mysqli_connect_errno();
			$this->error = mysqli_connect_error();
			return false;
		}
		if(!mysqli_set_charset($this->conn, "utf8mb4")) {
			$this->errno = mysqli_errno($this->conn);
			$this->error = mysqli_error($this->conn);
			return false;
		}
		return true;
	}

    function __destruct() {
		$this->errno = -1;
		mysqli_close($this->conn);
	}
    
    function ok() {
		return $this->errno == 0;
	}

    function getError() {
		$ret = $this->errno." -> ".$this->error;
		$this->errno = 0;
		$this->error = "";
		return $ret;
	}

    function getConn() {
		$this->errno = -1;
		return $this->conn;
	}

    function query($sql, $param = [], $fetchMode = MYSQLI_ASSOC) {	//fetchMode = MYSQLI_ASSOC   MYSQLI_NUM   MYSQLI_BOTH
		/*
		//escape string query:
		//$q = $db->query("select password from uporabnik where username='%s' and password='%s'", ['admin', 'admin']);
		foreach($param as $k => $v)
			$param[$k] = mysqli_real_escape_string($this->conn, $v);
		$sql = vsprintf($sql, $param);
		//var_dump($sql);
		$q = mysqli_query($this->conn, $sql);
		if(!$q) {
			$this->errno = mysqli_errno($this->conn);
			$this->error = mysqli_error($this->conn);
			return false;
		}
		print_r($q);
		*/

		//prepared statement:
		$stmt = mysqli_prepare($this->conn, $sql);
		if(!$stmt) {
			$this->errno = mysqli_errno($this->conn);
			$this->error = mysqli_error($this->conn);
			return false;
		}
		$types = "";
		foreach ($param as $k => $v) {
			switch (gettype($param[$k])) {
				case 'string':	$types .= 's'; break;
				case 'integer': $types .= 'i'; break;
				case 'double':	$types .= 'd'; break;
				case 'boolean':	$types .= 's'; break;
				default:
					$types .= 'b';
					break;
			}
		}
		//var_dump($types);
		if(count($param) > 0)
            $stmt->bind_param($types,...$param);
		if(mysqli_stmt_execute($stmt) === false) {
			$this->errno = mysqli_stmt_errno($stmt);
			$this->error = mysqli_stmt_error($stmt);
			return false;
		}

		$result = mysqli_stmt_get_result($stmt);
		if(gettype($result) == 'boolean') {
			if($result === true)
				return $result;
			if($result === false && mysqli_stmt_errno($stmt) === 0)
				return true;	//https://www.php.net/manual/en/mysqli-stmt.get-result.php#refsect1-mysqli-stmt.get-result-returnvalues
			$this->errno = mysqli_stmt_errno($stmt);
			$this->error = mysqli_stmt_error($stmt);
			mysqli_stmt_close($stmt);
			return false;
		}
		mysqli_stmt_close($stmt);

		$ret = array();
		while($row = mysqli_fetch_array($result, $fetchMode)) {
			array_push($ret, $row);
			//print_r($row);
			//var_dump($row);
		}
		mysqli_free_result($result);

		//print_r($ret);
		return $ret;
	}
}