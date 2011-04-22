<?php
session_start();
session_regenerate_id(TRUE);
require_once("functions.php");

if(!isset($_GET['action'])){
	
p_html();
pm_html();
if(isset($_GET['id'])){
	
	$id = (int) $_GET['id'];
	p_profile($id);
	if(c_admin() == '1'){
		$user = f_username($id);
		echo "<br/><a href='profile.php?action=ban&user=$user'>Banna utente!</a>";
	}
	
		print "</html>";
}
}

else{
	$azione = $_GET['action'];
	if($azione =='ban'){
		
		if(isset($_GET['user'])){
		$user = $_GET['user'];
		b_user($user);
	}
	
	}
}



?>
