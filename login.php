<?php
require_once("config.php");
require_once("functions.php");
echo '<body>';
session_start();
session_regenerate_id(TRUE);
$prefixx = PREFIX;
$table = $prefixx."users";

if (!isset($_SESSION['user']))
{
if (isset($_POST['username']) && isset($_POST['password'])){
	
	if(strstr($_POST['username'],"'") === TRUE) {
		print "Attento il tuo username contiene caratteri speciali come il singolo apice: '";
	}
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$user = mysql_real_escape_string($user);
	$pass = md5($pass);
	$sql="SELECT * FROM $table WHERE username='$user' and password='$pass'";
	$result=mysql_query($sql);
	
	if(mysql_num_rows($result)) {
	/*Prendo l'ip usato dall'utente e lo memorizzo*/
	$ip = $_SERVER['REMOTE_ADDR'];
	$id_p = f_id($user,'1');
	$query = "UPDATE ".$table." SET u_ip = '{$ip}' WHERE id = '$id_p';";
	mysql_query($query) or die("SQL Error: ".mysql_error());
	/*Fine inserimento ip*/
	/*Controllo se l'utente non è bannato per user-id e se è vero memorizzo le sessioni*/
	if(c_ban($user) == '0'){
	$_SESSION['user'] = $user;
	$_SESSION['password'] = $password;
	$host=$_SERVER['HTTP_HOST'];
	echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
}
/*Se è bannato faccio comparire un alert e reindirizzo alla index*/
elseif(c_ban($user) =='1') {?>
<script>alert('Utente bannato!')</script>
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
}
	}
	else {?>
	<script>alert('Wrong Username or Password')</script>
	<?php
	echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
	
	}
	
	
}

else{
	
echo '
<div class="rounded_STYLE">
  <div class="tl"></div><div class="tr"></div>Login:
<form method="POST" action="login.php">
<input type="text" name="username" value="username" size ="9"><br />
<input type="password" name="password" value="passw" size="9"><br />
<input type="submit" value="Log-in">
</form><br/>
 <div class="bl"></div><div class="br"></div>
</div><br/>
<a class ="linkz" href="./register.php">Register</a><br />
<a class ="linkz" href="./index.php">Home!</a><br />



';	
	
}
}
else{
	$user = $_SESSION['user'];
	$id_p = f_id($user,'0');
	$user = htmlspecialchars($user);
	echo "Benvenuto $user!<br/>
	<a class='logout' href='./logout.php'>Esci</a>
	<a class ='linkz' href='./profile.php?id=$id_p'>Profilo</a><br/>
	<a class ='linkz' href='./index.php'>Home!</a><br/>	";
	if (c_admin() == '1'){
	echo "
	<a class ='linkz' href='./insertpost.php'>Inser New Post</a><br/>
	<a class ='linkz' href='./userlist.php'>User list</a><br/>
	<a class ='linkz' href='./deletearticle.php'>Delete Article</a><br/>
	
	";
		/*<a href='./logout.php'>Admin Panel</a><br>*/
	}
}


?>
