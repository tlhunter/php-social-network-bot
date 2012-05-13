<?php
# This script displays per-user progress, in the right column
require_once('_config.php');
require_once('_functions.php');

$reported_progress_ids = array();

$sql = "SELECT * FROM progress ORDER BY id";
$result = runQuery($sql);
if (mysql_num_rows($result)) {
	while ($row = mysql_fetch_assoc($result)) {
		$reported_progress_ids[] = $row['id'];
		$created = date("H:i:s", strtotime($row['created']));
		echo "<div class=\"subunit level{$row['level']}\"><b>$created:</b> {$row['content']}</div>\n";
	}
} else {
	$created = date("H:i:s");
	echo "<div class=\"subunit level0\"><b>$created:</b> Nothing to report this iteration.</div>\n";
}
$reported_progress_ids_sql = implode(',', $reported_progress_ids);
runQuery("DELETE FROM progress WHERE id IN ($reported_progress_ids_sql)");