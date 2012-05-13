<?php
# Script built by Nucleocide

ignore_user_abort(TRUE);	# Script will run even when browser closes connection
set_time_limit(0);			# Script will never timeout
require_once('_config.php');
require_once('_functions.php');
require_once('_user.class.php');

runQuery("UPDATE state SET value = 0 WHERE name = 'halt' LIMIT 1");

$sql = "SELECT id FROM users WHERE flag = 0";
$result = runQuery($sql);
while ($row = mysql_fetch_assoc($result)) {
	$sql = "SELECT value FROM state WHERE name = 'halt' LIMIT 1";
	$resulthalt = runQuery($sql);
	$rowhalt = mysql_fetch_assoc($resulthalt);
	if ($rowhalt['value'] == 1) {
		break;
	}
	$id = $row['id'];
	$user = new User($id);
	if ($user->login()) {
		$friends = array();
		$ids = array();
		$total_friends = $user->getTotalFriends();
		$total_pages = ceil($total_friends / FPP);
		for ($i = 0; $i < $total_pages; $i++) {
			$page = $i * FPP;
			$friends[] = $user->gatherFriends($page);
		}
		foreach ($friends as $i => $value) {
			foreach($friends[$i] as $g => $val) {
				$ids[]=$val;
			}
		}
		foreach($ids AS $id) {
			$resultMessage = runQuery("SELECT * FROM messages ORDER BY RAND() LIMIT 1");
			$message = mysql_fetch_assoc($resultMessage);
			$user->sendMessage($id, $message['subject'], $message['body']);
		}
		runQuery("UPDATE users SET flag = 1, friends = $total_friends WHERE id = '{$user->getId()}' LIMIT 1");
	} else {
		runQuery("UPDATE users SET flag = 2 WHERE id = '{$user->getId()}' LIMIT 1");
	}
	$user->logout();
	unset($user);
}