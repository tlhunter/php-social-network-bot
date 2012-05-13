<?php
#This script parses a big list of username:password credentials and adds them to the database
include("_config.php");
include("_functions.php");
?>
<p>Use the following format, separate users on a new line:<br />
email:password</p>
<?php
if (isset($_POST['str'])) {
	$str=$_POST['str'];
	$mails = explode("\n",$str);
	foreach($mails as $ml) {
		if (!empty($ml)) {
			$m = explode(":",$ml);
			$email = $m[0];
            $password = str_replace("\r", '', $m[1]); # replace line returns
			$password = str_replace('\r', '', $password); # replace literal \r string
			runQuery("INSERT INTO users (email, password) VALUES ('$email', '$password')");
		}
	}
	echo "Done!<br />";
}
?>
<form method="post" action="import.php" target="_blank">
    <textarea name="str" cols="50" rows="10"></textarea>
    <br />
    <input type="submit">
</form>