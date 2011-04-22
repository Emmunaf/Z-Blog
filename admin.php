<?php
session_start();
session_regenerate_id(TRUE);
$user = $_SESSION['user'];
$data = date ("d-m-Y");
$ora = date ("H:i:s");
print"Benvenuto $user oggi &egrave; ".$data." e sono le ore ".$ora."<br/><br/>";
print"
	<a href='./insertpost.php'>New Post</a><br>
	<a href='./userlist.php'>User list</a><br>
	<a href='./deletearticle.php'>Delete Article</a><br>
	<a href='./listcomment.php'>Edit Comment</a><br>
	<a href='./listcomment.php'>Delete Comment</a><br>
	<a href='./userlist.php'>User List</a><br>
	<a href='./logout.php'>Esci/a><br>
	";
