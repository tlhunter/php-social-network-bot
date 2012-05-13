<?php
require_once('_config.php');
require_once('_functions.php');

class User {
	private $email;
	private $password;
	private $userid;
	private $cookiefile;

	function __construct($userid) {
		$this->userid = $userid;
		$this->cookiefile = dirname(__FILE__) . "/cookies/{$this->userid}.txt";
		$this->progress("INITIALIZE", 1);
		$sql = "SELECT * FROM users WHERE id = {$this->userid} LIMIT 1";
		$result = runQuery($sql);
		#echo "init: {$this->userid}<br />\n";
		if (mysql_num_rows($result)) {
			$row = mysql_fetch_assoc($result);
			$this->email = $row['email'];
			$this->password = $row['password'];
			return true;
		} else {
			return false;
		}
	}

	function login() {
		$this->progress("LOGIN {$this->email}", 1);
		$data = array(
			'email' => $this->email,
			'pass' => $this->password,
			'login' => 'Log In'
		);
		$output = $this->downloadUrl('http://m.socialnetwork.tld/login.php', 'http://m.socialnetwork.tld/login.php?http', $data);
		#writeFile($output, "cache/login-{$this->userid}.txt");
		if (empty($output)) {
			$this->progress("Empty Login Results", 1);
			return false;
		} else if (preg_match('/your account is temporarily unavailable/', $output)) {
			$this->progress("Account Is Locked", 1);
			return false;
		} else if (preg_match('/Incorrect email\/password combination\./', $output)) {
			$this->progress("Invalid Credentials", 1);
			return false;
		} else if (preg_match('/Need a Facebook account/', $output)) {
			$this->progress("Did Not Login Properly", 1);
			writeFile($output, "cache/login-{$this->userid}.txt");
			return false;
		} else {
			$this->progress("We have logged in fine", 1);
			return true;
		}
	}

	function sendMessage($id, $subject, $body) {
		$this->progress("MAIL $id SUB $subject", 0);
		$output = $this->downloadUrl('http://m.socialnetwork.tld/inbox/?compose&ids='.$id.'&refid=5', 'http://m.socialnetwork.tld/friends.php?a');
		preg_match('/\<input type="hidden" name="post_form_id" value="(.*)" \/\>/', $output, $matches);
		$post_id = substr($matches[1], 0, 32);
		preg_match('/name="xx_dtsg" value="(.*)"/', $output, $matches);
		$dtsg = substr($matches[1], 0, 5);

		$data = array(
			'xx_dtsg' => $dtsg,
			'post_form_id' => $post_id,
			'ids[]' => $id,
			'subject' => $subject,
			'body' => $body,
			'send' => 'Send'
		);
		$output = $this->downloadUrl('http://touch.socialnetwork.tld/message_send.php', 'http://m.socialnetwork.tld/inbox/?compose&ids=706890690', $data);
		# check file for status and return T or F
		return $output;
	}

	function getTotalFriends() {
		echo "Getting total friend count..\t\t";
		$output = $this->downloadUrl('http://m.socialnetwork.tld/friends.php?a', 'http://m.socialnetwork.tld/');
		#writeFile($output, "cache/getTotalFriends-{$this->userid}.txt");
		if (empty($output)) {
			$this->progress("Empty Friend Count Check", 1);
			return FALSE;
		} else {
			#$output = preg_replace('/\<\/a\>/i', "</a>\r\n", $output);
			preg_match('/1 - ([0-9]?)+ of (([0-9]?)+) friends/', $output, $matches);
			#print_r($matches);
			$total = floatval($matches[2]);
			$this->progress("Found $total total friends", 1);
			return $total;
		}
	}

	function gatherFriends($page) {
		$this->progress("Gather page $page");
		$output = $this->downloadUrl('http://m.socialnetwork.tld/friends.php?a&f='.$page, 'http://m.socialnetwork.tld/');
		$output = preg_replace('/\<\/a\>/i', "</a>\r\n", $output);
		preg_match_all('/inbox\/\?([0-9A-Za-z]+)&amp;compose&amp;ids=([0-9]+)/', $output, $matches);
		#echo "Done!<br />\n";
		return $matches[2];
	}

	function logout() {
		$this->downloadUrl("http://m.socialnetwork.tld/logout.php", "http://m.socialnetwork.tld/home.php");
		unlink($this->cookiefile);
		$this->progress("User has been logged out", 1);
	}

	function getId() {
		return $this->userid;
	}

	function downloadUrl($url, $referer, $data = FALSE) {
		$user_agent = "BlackBerry8330/4.3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/105";
		$cr = curl_init($url);
		curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cr, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($cr, CURLOPT_REFERER, $referer);
		curl_setopt($cr, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($cr, CURLOPT_COOKIEJAR, $this->cookiefile);
		if (!empty($data)) {
			curl_setopt($cr, CURLOPT_POST, true);
			curl_setopt($cr, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($cr, CURLOPT_POSTFIELDS, $data);
		}
		$output = curl_exec($cr);
		curl_close($cr);
		return $output;
	}

	function progress($message, $level = 0) {
		$message = "<em>" . $this->userid . "</em> $message";
		runQuery("INSERT INTO progress SET content = '$message', level = $level");
	}
	
}