<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') { // local machine
	define("DB_HOST", 'localhost'); # Database Hostname
	define("DB_USER", 'root'); # Database Username
	define("DB_PASS", ''); # Database Password
	define("DB_NAME", 'message-bot'); # Database Name
} else { // live server
	define("DB_HOST", 'localhost'); # Database Hostname
	define("DB_USER", 'root'); # Database Username
	define("DB_PASS", ''); # Database Password
	define("DB_NAME", 'message-bot'); # Database Name
}
define("FPP", 14); #friends per page