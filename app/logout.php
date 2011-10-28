<?php 
	unset($_SESSION['user']);
	flash_message('success', '', 'Vous êtes à présent déconnecté.');
	header('Location: ?p=login'); 
?>