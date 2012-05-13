<?php
require_once('_config.php');
require_once('_functions.php');
runQuery("UPDATE users SET flag = 0, reported = 0, friends = 0");
runQuery("TRUNCATE TABLE progress");
?>
<p>User messaging progress has been reset. If you run the app again, it will start from the beginning. You should, however, refresh the index.htm page to be safe.</p>