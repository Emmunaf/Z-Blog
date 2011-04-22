<?php
require_once("functions.php");
$autorec = $_GET['autore'];
$testoc = $_GET['testo'];
p_html();
?>
<body>
<form method="post" >
Modifica Commento<br/>
<br>
Autore:<br>
<input name="autore" value="<?php print $autorec; ?>"><br/>
<br>
Testo:<br>
<textarea cols="30" rows="15" name="testo"><?php print $testoc; ?></textarea><br/>
<br>
<input value="Modifica Commento" type="submit">
</form>
</body>

<?php
$id = intval($_GET['id']);
$autore = htmlspecialchars($_POST['autore']);
$testo = htmlspecialchars($_POST['testo']);
if(isset($id) && ($autore) && ($testo))
{
e_comment($id, $autore, $testo);
}
else
{
print"Riempire tutti i campi<br/>";
}
/*&& $_GET['action'] == 'c_edit'*/
?>
