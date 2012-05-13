<?php
# Use this script to configure some aspects of the app, such as setting messages
include("_config.php");
include("_functions.php");
?>
<style>
#settings_screen b, #settings_screen a {
	color: black;
}
</style>
<div id="settings_screen">
<?php
if ($_GET['deleteid']) {
	$delsq = "DELETE FROM `messages` WHERE `id` = '{$_GET['deleteid']}' LIMIT 1;";
	$delete = runQuery($delsq);
	if ($delete) {
		echo "Message Deleted!";
	} else {
		echo "Error!";
	}
}

if ($_GET['add']) {
	?>
	<br><br>
	<form action="settings.php?add=done" method="POST">
	<b>SUBJECT:</b><br>
	<input type="text" name="subject"><br>
	<b>BODY:</b><br>
	<textarea name="body" rows="8"></textarea><br>
	<input type="submit" value="Add Message!"><br>
	</form>
	<?php
	if($_POST['subject'] & $_GET['add']) {
		$addsql = "INSERT INTO `messages` (`id` ,`subject` ,`body`) VALUES ('', '{$_POST['subject']}', '{$_POST['body']}')";
		$add = runQuery($addsql);
		if ($add) {
			echo "Message Added!";
		} else {
			echo "Error!";
		}
	}
} 


if($_GET['editid']) {
if(!$_POST['id']){

$result2 = runQuery("SELECT * FROM messages WHERE id = '{$_GET['editid']}' LIMIT 1");
while($row2 = mysql_fetch_array($result2)){$id = $row2['id'];$subject = $row2['subject'];$body = $row2['body'];}
?>
<br><br>
<form action="settings.php?editid=<?php echo $_GET['editid']?>" method="POST">
<b>SUBJECT:</b><br>
<input type="text" name="subject" value="<?php echo $subject?>"><br>
<b>BODY:</b><br>
<textarea name="body" rows="8"><?php echo $body?></textarea><br>
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="submit" value="Edit Message!"><br>
</form>
<?php
}
if($_POST['subject']){
$editsql = "UPDATE messages SET subject = '{$_POST['subject']}' , body = '{$_POST['body']}' WHERE id = '{$_POST['id']}';";
$edit = runQuery($editsql);
if($edit){echo "Message Edited!";}else{ echo "Error!";}
}


 if($_POST['subject']){?>
<form action="settings.php?editid=<?php echo $_GET['editid']?>" method="POST">
<b>SUBJECT:</b><br>
<input type="text" name="subject" value="<?php echo $_POST['subject']?>"><br>
<b>BODY:</b><br>
<textarea name="body" rows="8"><?php echo $_POST['body']?></textarea><br>
<input type="hidden" name="id" value="<?php echo $_POST['id']?>">
<input type="submit" value="Edit Message!"><br>
</form>
<?php }
}
?>
<a href="settings.php?add=message" target="_blank"><b>Add Message</b> </a><br><br>

<?php
if(!$_GET['add'] && !$_GET['editid']) {
	$result = runQuery("SELECT * FROM messages ORDER BY `id` ASC");

	while($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$subject = $row['subject'];
		$body = $row['body'];
		?>
		<div><b>SUBJECT:</b> <?php echo $subject?></div>
		<div><b>BODY:</b>
		<div style="height: 120px; overflow: auto; border: 1px solid #666;"><?php echo $body?></div>
		</div>

		<div><a href="settings.php?editid=<?php echo $id?>" target="_blank">Edit</a> | <a href="settings.php?deleteid=<?php echo $id?>" target="_blank">Delete</a></div>



		<?php
	}
}