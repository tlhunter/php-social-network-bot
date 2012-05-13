<?php
require_once('_config.php');
require_once('_functions.php');

runQuery("UPDATE state SET value = 1 WHERE name = 'halt' LIMIT 1");