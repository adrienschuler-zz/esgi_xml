<?php

$book = new Book();
$book = $book->read($_GET['id']);
$file = 'tmp/' . $book['title'] . '_' . $book['id'] . '.xml';
$book->asXML($file);

header("Location: $file");