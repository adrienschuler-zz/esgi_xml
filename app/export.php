<?php

$book = new Book();
$book = $book->read($_GET['id']);
$file = 'xml/tmp/' . $book[0]['id'] . '.xml';
$book[0]->asXML($file);

header("Location: $file");