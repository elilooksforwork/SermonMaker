<?php
    // With ajax calls
    if (session_status()==1) {
        session_start();
    }
    header('Content-Type: application/json');
    require_once('classes/CdbCUT.php');
	require_once('classes/global.php');
    if (/*!empty($_POST['token']) &&*/!empty($_REQUEST['action'])) {
        switch ($_REQUEST['action']) {
            case 'getBibleVerses':
                getBibleVerses($_REQUEST['Ttag']);
                break;
            case 'getPhrases':
                getPhrases($_REQUEST['Tword']);
                break;
            case 'getWords':
                getWords($_REQUEST['Tword'], $_REQUEST['TsearchType']);
                break;
            case 'getWordClues':
                getWordClues(htmlspecialchars(urldecode($_REQUEST['sWord'])));
                break;
            case 'getWordCombinations':
                getWordCombinations(htmlspecialchars(urldecode($_REQUEST['sWord'])), $_REQUEST['iLength']);
                break;
			case 'saveCrossword':
				if (!empty($_REQUEST['Tpuzzle'])) {
					saveCrossword($_REQUEST['Tiid'],$_REQUEST['Tpuzzle']);
				} else{
				    $emptyJSON = '[{"RC" : "-1" "Field" : "", "Message" : "Empty Crossword!"}]';
					echo($emptyJSON);
				}
                break;
			case 'saveCrossword13':
				if (!empty($_REQUEST['Tpuzzle'])) {
					saveCrossword13($_REQUEST['Tiid'],$_REQUEST['Tpuzzle']);
				} else{
				    $emptyJSON = '[{"RC" : "-1","Field" : "", "Message" : "Empty Crossword!"}]';
					echo($emptyJSON);
				}
                break;
			case 'saveChain':
				if (!empty($_REQUEST['Tchain'])) {
					saveChain($_REQUEST['Tiid'],$_REQUEST['Tchain']);
				} else{
				    $emptyJSON = '[{"RC" : "-1" "Field" : "", "Message" : "Empty Crossword!"}]';
					echo($emptyJSON);
				}
                break;
			case 'saveKaraoke':
				if (!empty($_REQUEST['Tlyrics'])) {
					saveKaraoke($_REQUEST['Tsong'],$_REQUEST['Tlyrics']);
				} else{
				    $emptyJSON = '[{"RC" : "-1" "Field" : "", "Message" : "Empty Crossword!"}]';
					echo($emptyJSON);
				}
                break;
			case 'setSystemColor':
				if (!empty($_REQUEST['TColor'])) {
					$emptyJSON = '[{"RC" : "0", "Field" : "", "Message" : "' . $_REQUEST['TColor'] . ' was set"}]';
					$_SESSION["sysColor"] = trim($_REQUEST['TColor']," \n\r\t");
				} else{
				    $emptyJSON = '[{"RC" : "-1" ,"Field" : "", "Message" : "No Color!"}]';
				}
				echo($emptyJSON);
                break;
		}
    } else{
        echo "[{'ERROR': 'Illegal'}]";
    }
	function getPhrases($sWord){
		$pos = strrpos($sWord, " ");
		if ($pos === false) { 
			$sUrl		= "https://api.rhymezone.com/words?max=100&k=rz_sl&sp=**" .$sWord ."**";
		} else{
			$s = str_replace(' ','+', $sWord);
			$sUrl		= "https://api.rhymezone.com/words?max=100&k=rz_sl&sl=" .$s;
		}
		$sResponse	= file_get_contents($sUrl);
		echo($sResponse);
		//https://api.rhymezone.com/words?max=100&k=rz_sl&sp=**play**
		//https://api.rhymezone.com/words?max=100&k=rz_sl&sl=play+time
	}
    function getBibleVerses($tag){
        $emptyJSON  = '[{"id" : "NO DATA", "Verse" :"", "Tags" : ""}]';
        $query      = "CALL spgetbibleverses('" .$tag. "');";
        if(!empty($tag)){
            $db         = new CdbCUT("EliTest");
            $jsonData   = $db->getJSON($query);
            if($jsonData){
                echo $jsonData;
            } else{
                echo $emptyJSON;
            }
        } else {
            echo $emptyJSON;
        }
    }
    function getWords($word, $searchType){
        $emptyJSON  = '[{"word" : "NO DATA", "definition" :""}]';
        $query      = "CALL spfDictionary('" .$word. "'," .$searchType.");";
		//echo($query);
        if(!empty($word)){
            $db         = new CdbCUT("EliTest");
            $jsonData   = $db->getJSON($query);
            if($jsonData){
                echo $jsonData;
            } else{
                echo $emptyJSON;
            }
        } else {
            echo $emptyJSON;
        }
    }
    function getWordClues($word){
        $emptyJSON  = '[{"word" : "NO DATA", "definition" :""}]';
        $sWord      = substr($word, 0, -1);;
        $query      = "select LCASE(word) as word, definition from dictionary where word " . rtrim(getSqlInClauseFromString(strtolower($sWord))) .";";
		//echo($query);
        $db         = new CdbCUT("EliTest");
        $jsonData   = $db->getJSON($query);
        if($jsonData){
            echo $jsonData;
        } else{
            echo $emptyJSON;
        }
    }
    function getWordCombinations($word, $len){
        $emptyJSON  = '[{"word" : "NO DATA", definition:""}]';
        $sWord      = rtrim($word);
        $low        = strlen($sWord);
        if($low == 0){
            echo $emptyJSON;
            return;
        }
        $CID = "";
        for($i = 0; $i < $low; $i++){
            $char = substr($sWord,$i,1);
            if($i==0){
                if($char == " "){
                    $CID =  $CID ."^([A-Z])";
                } else{
                    $CID =  $CID ."^" .$char;
                }
            } else{
                if($char == " "){
                    $CID =  $CID ."([A-Z])";
                } else{
                    $CID =  $CID ."([" .$char ."])";
                }
            }
        }    
        $query      = 'select word, definition from dictionary where word regexp("' .$CID. '") ' .($len > 0 ? " AND LENGTH(word) <= " . $len  : "") . ";";
        $db         = new CdbCUT("EliTest");
        $jsonData   = $db->getJSON($query);
		//echo($query);
        if($jsonData){
            echo $jsonData;
        } else{
            echo $emptyJSON;
        }
    }
    function saveChain($iid, $chain){
        $emptyJSON = '[{"RC" : "-1","Field" : "", "Message" : "Unspecific Error!"}]';
        $query      = "CALL spChainReaction(?,?);";
		$db			= new CdbCUT("EliTest");
		$jsonData	= $db->getBindedRows($query, "ds", array($iid,$chain));
        if($jsonData){
            echo json_encode($jsonData);
        } else{
	        $emptyJSON = '[{"RC" : "-1", "Field" : "", "ERROR" : "' .$stmt->error .'"}]';
			echo $emptyJSON;
         }
    }
    function saveCrossword($iid, $puzzle){
        $emptyJSON = '[{"RC" : "-1","Field" : "", "Message" : "Unspecific Error!"}]';
        $query      = "CALL spCrossword(?,?);";
		$db			= new CdbCUT("EliTest");
		$jsonData	= $db->getBindedRows($query, "ds", array($iid,$puzzle));
        if($jsonData){
            echo json_encode($jsonData);
        } else{
	        $emptyJSON = '[{"RC" : "-1", "Field" : "", "ERROR" : "' .$stmt->error .'"}]';
			echo $emptyJSON;
         }
    }
    function saveCrossword13($iid, $puzzle){
        $emptyJSON = '[{"RC" : "-1","Field" : "", "Message" : "Unspecific Error!"}]';
        $query      = "CALL spCrossword13(?,?);";
		$db			= new CdbCUT("EliTest");
		$jsonData	= $db->getBindedRows($query, "ds", array($iid,$puzzle));
        if($jsonData){
            echo json_encode($jsonData);
        } else{
	        $emptyJSON = '[{"RC" : "-1", "Field" : "", "ERROR" : "' .$stmt->error .'"}]';
			echo $emptyJSON;
         }
    }
    function saveKaraoke($song, $lyrics){
        $emptyJSON = '[{"RC" : "-1","Field" : "", "Message" : "Unspecific Error!"}]';
        $query      = "CALL spkaraoke(?,?);";
		$db			= new CdbCUT("EliTest");
		$jsonData	= $db->getBindedRows($query, "ss", array($song,$lyrics));
        if($jsonData){
            echo json_encode($jsonData);
        } else{
	        $emptyJSON = '[{"RC" : "-1", "Field" : "", "ERROR" : "' .$stmt->error .'"}]';
			echo $emptyJSON;
        }
    }
?>