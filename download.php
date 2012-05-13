<?php
# This script downloads a list of the users whose accounts are able to be logged into
require_once('_config.php');
require_once('_functions.php');

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"users.txt\"");

$result = runQuery("SELECT * FROM users WHERE flag <= 1");
while ($row = mysql_fetch_assoc($result)) {
	echo $row['email'] . ":" . $row['password'] . "\r\n";
}