<?php

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('APP', ROOT . 'app' . DS);
define('TMP_PATH', ROOT . 'tmp' . DS);

define('XML_FILE', ROOT . 'xml/books.xml');
define('XML_USERS', ROOT . 'xml/users.xml');
define('IMAGE_PATH', ROOT . 'images' . DS . 'game' . DS);

define('PUBLIC_PAGES', serialize(array(
	'login',
	'register'
)));

require APP . 'functions.php';

require APP . 'user.class.php';
require APP . 'book.class.php';
require APP . 'chapter.class.php';

require APP . 'index.php';