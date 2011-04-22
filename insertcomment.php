<?php
session_start();
session_regenerate_id(TRUE);
include("functions.php");
p_html();
pm_html();
?>
<form method="post">
<div style="text-align: center;"><big><span style="font-weight: bold;">Inserisci
Commento</span></big><br>
<br>
eMail: <input name="email"><br>
<br>
Autore: <input name="autore"><br>
<br>

Titolo: <input name="titolo"><br>
<br>
Testo:<br>
&nbsp;<textarea cols="30" rows="15" name="testo"></textarea><br>
<br>
<img alt="" src="captcha.php"> <br>
<br>
Inserire Codice Captcha:<br>
<br>
<input name="cap"><br>
<br>
<input value="Inserisci Commento" type="submit"> </div>
<br>
<br>
</form>
</body>
</html>
<?php
	$code = htmlspecialchars($_POST['cap']);
	$a_id = intval($_GET['id']);
	$mail = mysql_real_escape_string($_POST['email']);
	$author = mysql_real_escape_string($_POST['autore']);
	$title = mysql_real_escape_string($_POST['titolo']);
	$data = $_POST['testo'];
	$data = str_replace("'", '"', $data);
	$replyof = "-1";
	$last = "0";
	$time = (date("G:i:s"));
	$date = (date("d-m-y"));
	$captcha = file_get_contents("cap.php");
if(isset($a_id) && ($mail) && ($author) && ($title) && ($data) && ($code === $captcha))
{
i_comment($a_id, $author, $title, $data, $time, $mail, $date);
}
?>
