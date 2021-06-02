<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$OUR_PERCENTAGE = 0.0279;
	$OUR_COMISSION = 3.99;
    $arrStates = array(
        "AL" => "Alabama",
        "AK" => "Alaska",
        "AZ" => "Arizona",
        "AR" => "Arkansas",
        "CA" => "California",
        "CO" => "Colorado",
        "CT" => "Connecticut",
        "DE" => "Delaware",
        "FL" => "Florida",
        "GA" => "Georgia",
        "HI" => "Hawaii",
        "ID" => "Idaho",
        "IL" => "Illinois",
        "IN" => "Indiana",
        "IA" => "Iowa",
        "KS" => "Kansas",
        "KY" => "Kentucky",
        "LA" => "Louisiana",
        "ME" => "Maine",
        "MD" => "Maryland",
        "MA" => "Massachusetts",
        "MI" => "Michigan",
        "MN" => "Minnesota",
        "MS" => "Mississippi",
        "MO" => "Missouri",
        "MT" => "Montana",
        "NE" => "Nebraska",
        "NV" => "Nevada",
        "NH" => "New Hampshire",
        "NJ" => "New Jersey",
        "NM" => "New Mexico",
        "NY" => "New York",
        "NC" => "North Carolina",
        "ND" => "North Dakota",
        "OH" => "Ohio",
        "OK" => "Oklahoma",
        "OR" => "Oregon",
        "PA" => "Pennsylvania",
        "RI" => "Rhode Island",
        "SC" => "South Carolina",
        "SD" => "South Dakota",
        "TN" => "Tennessee",
        "TX" => "Texas",
        "UT" => "Utah",
        "VT" => "Vermont",
        "VA" => "Virginia",
        "WA" => "Washington",
        "WV" => "West Virginia",
        "WI" => "Wisconsin",
        "WY" => "Wyoming");
    function appgetPostValue($val, $def = "") {
        return isset($_POST[$val]) ? $_POST[$val] : $def;
    }
    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'Well is Well is Goodness';
        $secret_iv = 'The Meek shall inherit the earth';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 1 ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else  {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    function filterByValue ($array, $index, $value, $wholeRecord = 0){
        $newarray = array();
        if(is_array($array) && count($array)>0)
        {
            foreach ($array as $key=>$cur_value) {
                $KeyValue = $cur_value[$index];
                $pos = stripos($KeyValue, $value);
                if ($pos !== false){
                    $newarray[] = ($wholeRecord ? $array[$key] : $KeyValue);
                }
            }
        }
        return $newarray;
    }
    function getFilesByVendorAndProductId($prodID,$vendorID){
            $arrFiles   = array();
            $dir        = dirname(__FILE__) ."/images/Vendor" .$vendorID ."/";
            foreach (glob("{$dir}*.{jpg,jpeg,gif,ico,png}", GLOB_BRACE) as $file) {
                $pos = strrpos($file, "/");
                $fileNew = "";
                if($pos !== FALSE){
                    $fileNew = substr($file, $pos+1);
                }
                if (fnmatch("*$prodID*", $fileNew)) {
                    //echo "some form of .." .$file ."<br />";
                    $arrFiles[] = $fileNew;
                    //echo "some form of .." .$arrFiles[0] ."<br />";
                }
            }
        return $arrFiles;
    }
    function getVendorLogo($vendorID){
        $dir        = realpath("images/Vendor" .$vendorID);
        $dir        = $dir .(is_localhost() === TRUE ? "\\" : "/") ."logo";
        $fileNew    = "images/no-image.jpg";
        foreach (glob("{$dir}*.{jpg,jpeg,gif,ico,png}", GLOB_BRACE) as $file) {
            $pos = strrpos($file, (is_localhost() === TRUE ? "\\" : "/"));
            $fileNew = $file;
            if($pos !== FALSE){
                $fileNew = "images/Vendor" .$vendorID ."/" .substr($file, $pos+1);
            }
            break;
        }
        return $fileNew;
    }
    function getVendorFirstImage($vendorID, $prodId){
        $dir        = realpath("images/Vendor" .$vendorID);
        $dir        = $dir .(is_localhost() === TRUE ? "\\" : "/") .$prodId;
        $fileNew    = "images/no-image.jpg";
        foreach (glob("{$dir}*.{jpg,jpeg,gif,ico,png}", GLOB_BRACE) as $file) {
            $pos = strrpos($file, (is_localhost() === TRUE ? "\\" : "/"));
            $fileNew = $file;
            if($pos !== FALSE){
                $fileNew = "images/Vendor" .$vendorID ."/" .substr($file, $pos+1);
            }
            break;
        }
        return $fileNew;
    }
    function is_ajax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    function is_localhost(){
        $whitelist = array("127.0.0.1", "::1");
		if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return FALSE;
        } else{
            return TRUE;
        }
    }
    function is_vowel($search){
        return strpos("aeiou", strtolower($search));
    }
	function getSqlInClauseFromString($str)
	{
        return "in ('" . str_replace(",", "','", $str) . "') ";
	}
?>