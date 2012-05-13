<?php
# This script displays the progress of the bot
require_once('_config.php');
require_once('_functions.php');

$sql = "SELECT COUNT(*) AS count FROM users";
$result = runQuery($sql);
$row = mysql_fetch_assoc($result);
$total = $row['count'];

$reported_ids = array();


if (isset($_GET['first'])) {
	echo "<script>totalUsers = $total;</script>\n";
}

$sql = "SELECT * FROM users WHERE reported = 0 AND flag != 0 ORDER BY id";
$result = runQuery($sql);
if (mysql_num_rows($result)) {
	while ($row = mysql_fetch_assoc($result)) {
		$reported_ids[] = $row['id'];
		if ($row['flag'] > 1) {
			$class = "unit error";
			$extra = " <a href='delete.pnp?id={$row['id']}' target='_blank'>Delete</a>";
		} else {
			$class = "unit";
			$extra = " User has {$row['friends']} friend(s).";
		}

		echo "<div class=\"$class\"><span class=\"counter\">" . sprintf("%04d",$row['id']) . "/" . sprintf("%04d",$total) . "</span> <b>{$row['email']}:</b>$extra</div>\n";
		echo "<script>currentUser = {$row['id']};</script>\n";
	}
} else {

}
$reported_ids_sql = implode(',', $reported_ids);
runQuery("UPDATE users SET reported = 1 WHERE id IN ($reported_ids_sql)");
