<?php
require_once("functions.php");
p_html();
pm_html();
?>

<center>
<h2>Registrati</h2>
<br>
<form method="post">
UserName: <input name="user"><br>
<br>
Password: <input name="pass" type="password"><br>
<br>
Password: <input name="cpass" type="password"><br>
<br>
Email: <input name="email"><br>
<br>
Sito Web: <input name="sito">
<br>
<br>
<img alt="" src="captcha.php"> <br>
<br>
Inserire Codice Captcha:<br>
<br>
<input name="cap"><br>
<br>
<input value="Registrati" type="submit"> </form>
</center></body>
</html>
<?php
$code = htmlspecialchars($_POST['cap']);
$username = $_POST['user'];
$password = MD5($_POST['pass']);
$cpass = MD5(htmlspecialchars($_POST['cpass']));
$email = htmlspecialchars($_POST['email']);
$captcha = file_get_contents("cap.php");
if(!isset($_POST['sito'])){
	$sito = "";
}
else{
$sito = mysql_real_escape_string($_POST['sito']);}
if(isset($username) && ($password) && ($cpass) && ($email) && ($password === $cpass) && ($code === $captcha))
{
register($username, $password, $email, $sito);
}
else
{
print"Riempire tutti i campi<br>";
}
