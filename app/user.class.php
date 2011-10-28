<?php

class User {
	
	var $id;
	var $login;
	var $password;
	var $file;


	function __construct() {
		$this->file = simplexml_load_file(XML_USERS);
	}

	function register($user) {
		if ( ! empty($user['login'])) {
			if (strlen($user['password']) >= 4) {
				if ($user['password'] === $user['confirmation']) {
					if ($this->search($user['login'], sha1($user['password']))) {
						flash_message('warning', 'Erreur !', 'Cet identifiant est déjà utilisé.');
						header('Location: ?p=register');
					} else {
						$this->create($user);
					}
				} else {
					flash_message('warning', 'Erreur !', 'La confirmation du mot de passe est incorrecte.');
					header('Location: ?p=register');
				}
			} else {
				flash_message('warning', 'Erreur !', 'Votre mot de passe doit contenir au minimum 4 caractères.');
				header('Location: ?p=register');
			}
		} else {
			flash_message('warning', 'Erreur !', 'Veuillez saisir un identifiant.');
			header('Location: ?p=register');
		}
	}

	function create($user) {
		$date = date('Y-m-d H:i:s');
		$login = $user['login'];
		$password = sha1($user['password']);

		$user = $this->file->addChild('user');
		$user->addAttribute('id', uniqid());
		$user->addAttribute('login', $login);
		$user->addAttribute('password', $password);
		$user->addAttribute('is_admin', '0');
		$user->addAttribute('created', $date);
		$user->addAttribute('modified', $date);

		$this->file->asXML(XML_USERS);

		flash_message('success', 'Inscription effectuée !', 'Vous pouvez dès à présent vous connecter.');
		header('Location: ?p=login');
	}

	function login($user) {
		$login = $user['login'];
		$password = sha1($user['password']);

		if ($this->search($login, $password)) {
			$_SESSION['user']['login'] = $login;
			flash_message('success', "Bonjour $login !", 'Vous êtes à présent connecté.');
			header('Location: ?p=admin');
		} else {
			flash_message('warning', 'Erreur !', 'Combinaison identifiant/mot de passe introuvable.');			
			header('Location: ?p=login');
		}
		
	}

	function search($login, $password) {
		return $this->file->xpath("user[@login='$login' and @password='$password']");
	}

}