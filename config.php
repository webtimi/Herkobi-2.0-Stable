<?php
header("Content-type: text/html;charset = utf-8");
if(!isset($_SESSION)){
	session_start();
}

	ini_set("display_errors", 0);
	// the rest of your script...

    /* Bu bölümde ki değerleri kendi sisteminize göre giriniz */
    
    $SITE_ADRESI = "http://localhost/hkv2"; // başında http:// olacak şekilde site adınızı giriniz. Sonuna / koymayınız
    
    $localhost    = "localhost";
    $user         = "root";
    $pass         = "";
    $db           = "hkv2";     
    
    
    /* Bu bölümden aşağısını değiştirmeyiniz. */
    $PANEL_ADRESI = $SITE_ADRESI."/panel";
    $db = new PDO("mysql:dbname=$db;host=$localhost;charset=UTF-8", "$user", "$pass");
    

	//Do not change the function - Fonksiyonu değiştirmeyiniz...
	function current_url() {
    		$pageURL = 'http';
    		$pageURL .= "://";
    			if ($_SERVER["SERVER_PORT"] != "80") {
        			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    			} else {
        			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    			}
    	return $pageURL;
	}
?>
