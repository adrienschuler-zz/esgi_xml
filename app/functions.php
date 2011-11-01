<?php

function flash_message($type, $title = null, $message = null) {
	$_SESSION['flash_message'] = array(
		'type' => $type,
		'title' => $title,
		'message' => $message
	);
}

function display_messages() {
	if (isset($_SESSION['flash_message'])) {
		echo '<div class="container">';
		echo '<div class="alert-message ' . $_SESSION['flash_message']['type'] . '">';
	  	echo '<a class="close" href="#">×</a>';
		echo '<p><strong>' . $_SESSION['flash_message']['title'] . '</strong>&nbsp;' . $_SESSION['flash_message']['message'] . '</p></div></div>';
		unset($_SESSION['flash_message']);
	} else {
		echo '<div class="alert-message" style="display:none;"><a class="close" href="#">×</a></div>';
	}
}

function check_session() {
	if (isset($_GET['p']) && in_array($_GET['p'], unserialize(PUBLIC_PAGES))) {
		return;
	}
	if ( ! isset($_SESSION['user'])) {
		flash_message('warning', 'Erreur !', 'Vous devez être identifié afin d\'accéder à cette page.');
		header('Location: ?p=login');
	}
}
