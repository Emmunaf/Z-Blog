<?php
include("functions.php");
session_start();
session_regenerate_id(TRUE);
if (isset($_SESSION['user']))
{
	
	if (c_admin() == '1'){
p_html();
pm_html();
?>
<form method="post">
<div style="text-align: center;"><big><span style="font-weight: bold;">Insert
Article</span></big><br>
<br>
Section: <input name="sezione"><br>
<br>
Author: <input name="autore"><br>
<br>
Title: <input name="titolo"><br>
<br>
Text:<br>
&nbsp;<textarea name="testo" cols="140" rows="20" style="width: 857px; height: 311px;"></textarea><br>
<br>
<input value="Insert Article" type="submit">
</div>
<br>
<br>
</form>
</body>
</html>
<?php
/*rimosso htmlspecial*/
	$section = mysql_real_escape_string($_POST['sezione']);
	$author = mysql_real_escape_string($_POST['autore']);
	$title = mysql_real_escape_string($_POST['titolo']);
	$data = $_POST['testo'];
	$data = str_replace("'", '"', $data);
	$replyof = "-1";
	$last = "0";
	$time = (date("G:i:s"));
	$date = (date("d-m-y"));
if(isset($section) && ($author) && ($title) && ($data))
{
i_article($section, $author, $title,$data, $replyof, $last, $time, $date);
}
}else {
		error2();
	}
}
else {
	error1();
}
?>
