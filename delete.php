<?php
require_once('_config.php');
require_once('_functions.php');

$userid = $_GET['id'] + 0;
runQuery("DELETE FROM users WHERE id = $userid LIMIT 1");
runQuery("UPDATE users SET id = id - 1 WHERE id > $userid");