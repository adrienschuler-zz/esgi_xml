<?php

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('APP', ROOT . 'app' . DS);
define('XML_FILE', ROOT . 'xml/books.xml');

require APP . 'user.class.php';
require APP . 'book.class.php';
require APP . 'chapter.class.php';


require APP . 'index.php';
