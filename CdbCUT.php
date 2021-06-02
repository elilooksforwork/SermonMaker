<?php
class CdbCUT {
    // variables
    var $sDbUser;
    var $sDbPass;
    var $sDbName;
    var $sDbHost;
    public $vLink;

    // constructor
    public function __construct($dbName) {
		$whitelist = array("127.0.0.1", "::1");
		/*if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
			$this->sDbUser 	= 'CUTDB';
			$this->sDbPass 	= '';
			$this->sDbName 	= 'CUTDB';
			$this->sDbHost	= "CUTDB.db.13120395.d95.hostedresource.net";
		} else{*/
			$this->sDbUser	= 'root';
			$this->sDbPass 	= '123456';
			$this->sDbName 	= is_null($dbName) ? 'elitest' : $dbName;
			$this->sDbHost	= "localhost:3306";
		//}
		$mysqli = mysqli_init();
		if (!$mysqli) {
			die('mysqli_init failed');
		}
		if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
			die('Setting MYSQLI_INIT_COMMAND failed');
		}

		if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
			die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
		}
		
		$this->vLink = @new mysqli($this->sDbHost, $this->sDbUser, $this->sDbPass, $this->sDbName);
		if (!$this->vLink) {
			die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
		}
		if ($this->vLink->connect_errno) {
            // Let's try this:
            echo "Sorry, this website is experiencing problems.";
            echo "Error: Failed to make a MariaDB connection, here is why: \n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            exit;
        }
    }

    // return one value result
    function getOne($query, $index = 0) {
        if (! $query)
            return false;

		$result =  $this->vLink->query($query);

        $arr_res = array();
        if ($result && mysqli_num_rows($result))
            $arr_res = mysqli_fetch_array($result);
        if (count($arr_res))
            return $arr_res[$index];
        else
            return false;
    }

    // executing sql
    function execSQL($query, $error_checking = true) {
        if(!$query)
            return false;
		$result =  $this->vLink->query($query);
        if (!$result)
            $this->error(mysqli_errno($this->vLink) ." : " .mysqli_error($this->vLink), false, $query);
        return $result;
    }

	function getArrayRows($query) {
        $arr = array();
		$res = $this->execSQL($query);
		if (!$res){
			$this->error(mysqli_errno($this->vLink) ." : " .mysqli_error($this->vLink), false, $query);
		} else {
			while($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$arr[]=$row;
			}
		}
		$res->close();
		return $arr;
	}
    // return table of records as result in pairs
    function getArray($query, $sFieldKey, $sFieldValue, $arr_type = MYSQLI_BOTH ) {
        if (!$query)
            return array();
        $res = $this->execSQL($query);
        $arr_res = array();
        if ($res) {
			while ($row = mysqli_fetch_array($res, $arr_type)) {
                $arr_res[$row[$sFieldKey]] = $row[$sFieldValue];
            }
            mysqli_free_result($res);
        }
        return $arr_res;
    }

    // return table of records as result
    function getAll($query, $arr_type = MYSQLI_BOTH) {
        if (! $query)
            return array();

        $res = $this->execSQL($query);
        $arr_res = array();
        if ($res) {
            while ($row = mysqli_fetch_array($res, $arr_type)){
                $arr_res[] = $row;
			}
            mysqli_free_result($res);
        }
        return $arr_res;
    }
	function getJSON($query) {
        $arr = array();
		$res = $this->execSQL($query, MYSQLI_USE_RESULT);
		while($row = $res->fetch_array(MYSQLI_ASSOC)) {
			$arr[]=$row;
		}
		$res->close();
		return json_encode($arr);
	}
    function getRow($query, $arr_type = MYSQLI_BOTH) {
        if(!$query)
            return array();

		$res = $this->execSQL($query);

		$arr = array();

		if($res && mysqli_num_rows($res)) {
            $arr_res = mysqli_fetch_array($res, $arr_type);
        }
        mysqli_free_result($res);
        return $arr_res;
    }
	function getBindedRows($query, $types, $arrParams){
        if(!$query)
            return array();
		$arr = array();
		$stmt = $this->vLink->prepare($query);
		$stmt->bind_param($types, ...$arrParams);
		$stmt->execute();
		$res = $stmt->get_result();
		if (!$res){
			$this->error(mysqli_errno($this->vLink) ." : " .mysqli_error($this->vLink), false, $query);
		} else {
			while($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$arr[]=$row;
			}
		}
		$stmt->close();
        return $arr;
	}
    // escape
    function escape($s) {
        return mysqli_real_escape_string($s);
    }

    // get last id
    function lastId() {
        return mysqli_insert_id($this->vLink);
    }

    // display errors
    function error($text, $isForceErrorChecking = false, $sSqlQuery = '') {
        echo $text; exit;
    }
}

?>