<?php
#error_reporting(E_ALL);

function runQuery($query) {
	$connect = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    if (!$connect) {
		die("<div class=\"error\">" . mysql_error() . "</div>");
	}
	mysql_select_db(DB_NAME, $connect);
    $result = mysql_query($query, $connect);
	return $result;

}

function writeFile($text, $filename) {
	$fp = fopen($filename, 'w');
	fwrite($fp, $text);
	fclose($fp);
}