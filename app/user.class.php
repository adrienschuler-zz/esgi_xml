<?php

class User {
	
	var $id;
	var $login;
	var $password;
	var $file;


	function __construct() {
		$this->file = simplexml_load_file(XML_USERS);
	}

	function check_registration($user) {
		
		if ($user['password'] === $user['confirmation']) {
			
		}

	}

	function check_login($user) {
		$login = $user['login'];
		$password = sha1($user['password']);

		$user = $this->file->xpath("/user[@login='$login' and @password='$password']");
		
	}

	function create($user) {
		$date = date('Y-m-d H:i:s');
		$this->login = $user['login'];
		$this->password = sha1($user['password']);

	}

	function login($user) {
		
	}

}