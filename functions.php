<?php
/*Function php;
 * Emp£Hack & System_infet
 * Beta....For bug contact me to ema.muna95@hotmail.it or admin@netcoders.org
 */

include("firewall.php");
require_once("config.php");
/*!!*/
	function c_admin() {
	if (isset($_SESSION['user']))
	{
	$user = mysql_real_escape_string($_SESSION['user']);
	$prefixx = PREFIX;
	$table = $prefixx."users";
	$sqlquery = "SELECT level FROM $table where username = '$user';";
	$level = mysql_query($sqlquery); 
	
	while ($row = mysql_fetch_row($level)) {
		if ($row['0'] == 'admin'){
			return '1';
			
		}
		else {
			return '0';
		}
	}
}
else{
return '0';
}
}

function f_id($username,$filtro){
	if($filtro == '1'){
	$user = mysql_real_escape_string($username);
}
else
{
	$user = $username;
}

	$prefixx = PREFIX;
	$table = $prefixx."users";
	$sqlquery = "SELECT id FROM $table where username = '$user';";
	$result = mysql_query($sqlquery); 
	
	while ($row = mysql_fetch_row($result)) {
		return $row['0'];
	}
}

function f_username($id){
	
	$id = (int) $id;
	$prefixx = PREFIX;
	$table = $prefixx."users";
	$sqlquery = "SELECT username FROM $table where id = '$id';";
	$result = mysql_query($sqlquery); 
	
	while ($row = mysql_fetch_row($result)) {
		return $row['0'];
	}
}
/*Funzione per printare l'html fino alla chiusura del tag head, stampa il titolo*/
function p_html() {
	$prefixx = PREFIX;
	$table = $prefixx."settings";
	$sqlquery = "SELECT title FROM $table";
	$b_name = mysql_query($sqlquery); 
	
	while ($row = mysql_fetch_row($b_name)) {
		$filtro = htmlspecialchars($row[0]);
		echo  "<!DOCTYPE html>
<html><meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\"/><head>
<title>$filtro</title><link rel=\"stylesheet\" type=\"text/css\" href=\"test.css\"></head>";

	}
 }
/*Funzione  che mostra la prima parte (688 caratteri) degli articoli con titolo e contenuto*/
function p_news() {
	$host=$_SERVER['HTTP_HOST'];
	$prefixx = PREFIX;
	$table = $prefixx."blog";
	$sqlquery = mysql_query("SELECT id, author, title, data FROM $table ORDER BY id DESC");
	
	
	  while ($row = mysql_fetch_assoc($sqlquery)) {
		$id = (int) $row['id'];
		$autore = htmlspecialchars($row['author']);
		$titolo  = htmlspecialchars($row['title']);
		$contenuto  = htmlspecialchars($row['data']);  
		$contenuto = cut_string($contenuto, '688');
		$c_num = c_comment($id);
		
		echo "<h2 class=\"title\"><a class=\"titoli\" href=\"./viewpost.php?id=$id\">$titolo</a><center><font size ='1'>    By $autore (commenti:$c_num)</font></center></h2>";
		echo "$contenuto";
		if (c_admin() == '1'){
		echo " <br/><a class='mod' href=\"./deletearticle.php?action=delete&id=".$id."\">Cancella ".$titolo."</a><br/>";}
		echo "<h2 class=\"separa\"></h2><br/><br/>";
	}
  }
  /*Funzione per inserire articoli, i parametri da passare sono i sottodetti*/
  function i_article($section, $author, $title,$data, $replyof, $last, $time, $date) 
{
	$prefixx = PREFIX;
	$table = $prefixx."blog";
	$query = "INSERT INTO ".$table." (section, author, title, data, replyof, last, time, date) VALUES ('{$section}', '{$author}', '{$title}', '{$data}', '{$replyof}', '{$last}', '{$time}', '{$date}');";
	mysql_query($query) or die("SQL Error: ".mysql_error());
	print("Articolo inserito con successo!\n");	
}
/*Taglia gli articoli lunghi per visualizzarne una anteprima*/
function cut_string($stringa, $max_char){
		
		if(strlen($stringa)>$max_char)
		{
			$stringa_tagliata=substr($stringa, 0,$max_char);
			$last_space=strrpos($stringa_tagliata," ");
			$stringa_ok=substr($stringa_tagliata, 0,$last_space);
			return $stringa_ok."<br/>[...]";
	}
		else
		{
			return $stringa;
	}
}
/*Funzione che conta il numero di commenti di un certo post, valore da passare è l'id del post*/
function c_comment($id){
	$prefixx = PREFIX;
	$table = $prefixx."comment";
	if (!isset($id)){
	$id = (int) $_GET['id'];
}
	$conta = "SELECT COUNT(a_id) as conta from $table WHERE a_id = '$id'";
    $conto = @mysql_query ($conta);
    $tot = @mysql_fetch_array ($conto);
    $c_num = $tot['conta'];
    return $c_num;
	
}

function p_comment($id)
{
	$id = (int) $id;
	print "<br/><br/>Commenti:<br/><br/>";/*da continuare*/
			$prefixx = PREFIX;
			$table = $prefixx."comment";
			$sqlquery = mysql_query("SELECT * FROM $table WHERE a_id = '$id'");
		while($row = mysql_fetch_assoc($sqlquery)) {
			$autore = htmlspecialchars($row['author']);
			$titolo  = htmlspecialchars($row['title']);
			$contenuto  = htmlspecialchars($row['data']);
			$id2 = (int) $row['id'];
			$c_edit = "<a class='c_edit' href=\"editcomment.php?id=".$id2."&autore=".$autore."&testo=".$contenuto."\">Modifica Commento</a><br/>";
			echo "<span class='c_title'>Title: $titolo</span><br/>";/*Printo il titolo*/
			echo "<span class='c_author'>Author: $autore</span><br/><div class='accapo'>$contenuto<h2 class=\"separa\">";
			if (c_admin() == '1'){
				echo $c_edit;/*stampo il link per e3ditare commenti*/
			}
			echo "</h2><br/></div>";/*con <h2 class=\"separa\"></h2><br/> creo spazio*/
			
		}
		echo "<a href=\"insertcomment.php?id=".$id."\">Inserisci Commento</a><br/><br/>";
	}
/*Funzione per inserire i commenti*/
 function i_comment($a_id, $author, $title, $data, $time, $mail, $date) 
{
	$prefixx = PREFIX;
	$table = $prefixx."comment";
	$query = "INSERT INTO ".$table." (a_id, author, title, data, time, mail, date) VALUES ('{$a_id}', '{$author}', '{$title}', '{$data}', '{$time}', '{$mail}', '{$date}');";
	mysql_query($query) or die("SQL Error: ".mysql_error());
	print("Commento inserito con successo!\n");	
	echo "<meta http-equiv=\"refresh\" content=\"0;url=viewpost.php?id=$a_id\">";
}
/*Funzione per verere i titoli degli articoli per poi eliminarli*/
 function l_article()
{
	p_html();
	pm_html();
	echo "Lista titoli degli articoli da eliminare:<br/>";
	$host = $_SERVER['HTTP_HOST'];
	$prefixx = PREFIX;
	$table = $prefixx."blog";
	$sqlquery = mysql_query("SELECT id, author, title, data FROM $table ORDER BY id DESC");
	while ($row = mysql_fetch_assoc($sqlquery)) 
	{
	$id = (int) $row['id'];
	$autore = htmlspecialchars($row['author']);
	$titolo  = htmlspecialchars($row['title']);
	$contenuto  = $row['data']; 
	$c_num = c_comment($id);
	echo " <a href=\"deletearticle.php?action=delete&id=".$id."\">Cancella ".$titolo."</a> (Commenti: $c_num)<br/>";
	}
	echo "</body></html>";
}

/*Funzione per eliminare gli articoli*/
	function d_article($getid)
	{
	$getid = (int) $getid;
	$prefixx = PREFIX;
	$table = $prefixx."blog";
	$query = "DELETE FROM ".$table." WHERE id = '".$getid."';";
	$result = mysql_query($query) or die(mysql_error());
	echo "<center>Articolo cancellato con successo<br/></center>/";	
	}
	
	function l_comment()
	{
	$prefixx = PREFIX;
	$table = $prefixx."comment";
	$query = "SELECT * FROM ".$table.";";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) 
	{
	$id = (int) $row['id'];
	$autore = htmlspecialchars($row['author']);
	$testo  = htmlspecialchars($row['data']); 
	print"Autore: ".$autore."<br/>\n";
	print"Testo: ".$testo."<br/>\n";
	echo"<a href=\"editcomment.php?id=".$id."&autore=".$autore."&testo=".$testo."\">Modifica Commento</a><br/>\n";
	}	
	}
	/*Funzione per modificare commenti!*/
	function e_comment($id, $autore, $testo)
	{
		
	$prefixx = PREFIX;
	$table = $prefixx."comment";
	$query = "UPDATE ".$table." SET author = '{$autore}', data = '{$testo}' WHERE id = '$id';";
	$result = mysql_query($query) or die(mysql_error());
	print"Commento Modificato con Successo!";
	echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
	}
	/*Funzione per modificare il proprio profilo*/
	function e_profile($id, $email, $password, $website){
		$id = (int) $id;
		$prefixx = PREFIX;
		$table = $prefixx."users";
		$password = md5($password);
		$query = "UPDATE ".$table." SET email = '{$email}', password = '{$password}', web_site = '{$website}' WHERE id = '$id';";
		$result = mysql_query($query) or die(mysql_error());
		echo "Dati cambiati con successo!";
	}
	/*Funzione per mostrare il profile degli utenti*/
	function p_profile($id){
		
		$id = (int) $id;
		$prefixx = PREFIX;
		$table = $prefixx."users";
		$sqlquery = mysql_query("SELECT * FROM $table WHERE id = '$id'");
		while($row = mysql_fetch_assoc($sqlquery)) {
		
		$user = htmlspecialchars($row['username']);
		$email  = htmlspecialchars($row['email']);
		$level  = htmlspecialchars($row['level']);
		print "Username: $user<br/>";
		print "Email: $email</br>";
		print "Level: $level</br>";
		
		
	}
}
	
	/*Funzione per stampare la userlist!*/	
	function userlist()
	{
	$prefixx = PREFIX;
	$table = $prefixx."users";
	$query = "SELECT * FROM ".$table.";";
	$result = mysql_query($query) or die(mysql_error());
	print"<center><table style=\"text-align: left;\" border=\"1\"
cellpadding=\"0\" cellspacing=\"0\">
<tbody>";

	while ($row = mysql_fetch_array($result)) 
	{
	$id = (int) $row['id'];
	$user = htmlspecialchars($row['username']);
	$level  = htmlspecialchars($row['level']); 
	$email  = $row['email']; 
	$website = $row['web_site']; 
print"	
<tr>
<td width='23%' style=\"vertical-align: top;\">UserName: <a class='linkz' href='profile.php?id=".$row['id']."'>$user</a><br/>
</td>
<td width='12%' style=\"vertical-align: top;\">Level: $level<br/>
</td>
<td width='23%' style=\"vertical-align: top;\">Email: $email<br/>
</td>
<td width='20%' style=\"vertical-align: top;\">Web Site: $website<br/>
</td>
</tr>";

	}
print"
</tbody>
</table></center><br/>";
	}

function register($username, $password, $email, $sito)
{
	$prefixx = PREFIX;
	$table = $prefixx."users";
	$username = mysql_real_escape_string($username);
	$sqlquery = "SELECT username FROM  ".$table." WHERE username = '$username';";
	$sqlquery2 = "SELECT username FROM  ".$table." WHERE email = '$email';";
	$result = mysql_query($sqlquery);
	$result2 = mysql_query($sqlquery2);
	$num = mysql_num_rows ($result);
	$num2 = mysql_num_rows ($result2);
	if($num == '0')
	{ 
		if($num2 == '0'){
	$query = "INSERT INTO ".$table." (username, password, level, text, background, email, web_site) VALUES ('{$username}', '{$password}', 'user', '#FFFFFF', '#000000', '{$email}', '{$sito}');";
	mysql_query($query) or die("SQL Error: ".mysql_error());
	echo"<script>alert('Utente registrato!')</script>";
	echo"<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
}
else{
	echo"<script>alert('Email già registrata!')</script>";
	echo"<meta http-equiv=\"refresh\" content=\"0;url=register.php\">";
}
	}
	else 
	{
	echo"<script>alert('Nome utente già registrato!')</script>";
	echo"<meta http-equiv=\"refresh\" content=\"0;url=register.php\">";
	}
}
	/*funzioni per fine html e per menu html*/
	function pe_html(){
		echo '<p><a href="http://jigsaw.w3.org/css-validator/check/referer">
		<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valido!" /></a></p>';
	}
	function pm_html(){
		echo '<body>';
		echo'<div id="main">
		<aside id="left_menu">
		<center>Menu</center><br/>';
		include("login.php");
		echo'<br/><br/>...</aside>';
		echo '<aside id="center_blog">';
	}
	/*Fine funzioni html*/
	function change_password($nuovapass)
        {
        session_start();
        session_regenerate_id(TRUE);
        $username = $_SESSION['user'];
        $prefixx = PREFIX;
        $table = $prefixx."users";
        $query = "UPDATE ".$table." SET password = '{$nuovapass}' WHERE username = '$username';";
        mysql_query($query) or die("MySQL error: ".mysql_error());
        echo"<script>alert('Password cambiata!')</script>";
		echo"<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
        }
	/*Funzioni per errori _!!Da tenere alla fine del file !!_*/
	
	function error1(){
		die("Logga prima di accedere a questa pagina!");
	}
	function error2(){
		die("Non hai i permessi per accedere a questa pagina!");
	}

	/*Fine funzioni per errori*/
	function b_user($user){
		if(c_admin() == '1'){
		$prefixx = PREFIX;
        $table = $prefixx."ban_ip";
		$query = "INSERT INTO $table (user_id) VALUES ('{$user}');";
		mysql_query($query) or die("MySQL error: ".mysql_error());
		print "Utente Bannato!";
		echo"<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
	}
	else {
		die("Non hai i permessi necessari per eseguire l'azione!");
	}
}
	
	function c_ban($user){
		$prefixx = PREFIX;
        $table = $prefixx."ban_ip";
        $user = mysql_real_escape_string($user);
		$query = "SELECT * FROM $table WHERE user_id='$user';";
		$result=mysql_query($query);

		if(mysql_num_rows($result)) {
		return '1';
		}
	else {
		return '0';
		}
	}
?>
