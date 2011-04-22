<?php
/*viewpost.php
 * Emp£HacK & System-infet
 * Beta...for bug contact me to ema.muna95@hotmail.it
 * File che consente la lettura dei post
 */
require_once("functions.php");
require_once("config.php");
session_start();
session_regenerate_id(TRUE);

p_html();
pm_html();

if (isset($_GET['id'])) {
	$prefixx = PREFIX;
	$table = $prefixx."blog";
	$id = intval($_GET['id']);
	$sqlquery = mysql_query("SELECT * FROM $table WHERE id = '$id'");
	while($row = mysql_fetch_assoc($sqlquery)) {
		
		$autore = htmlspecialchars($row['author']);
		$titolo  = htmlspecialchars($row['title']);
		$contenuto  = $row['data'];
		
		echo "<h2 class=\"title\">$titolo</h2>
		$contenuto
		<div class='p_author'>By $autore</div>";
		
		
	/*controllo il numero di commenti e se è diverso da zero scrivo i commenti con la funzione p_comment*/
		$c_num = c_comment($id);
		if(!$c_num == 0){
		p_comment($id);
		}
		else
		{
			echo "<a href=\"./insertcomment.php?id=$id\">Inserisci Commento</a></br></br>";
		}
		echo"</aside></div>";
		
	}
}
echo '</body></html>';

?>
