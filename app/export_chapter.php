<?php

$chapter = new Chapter();
$chapter = $chapter->read($_GET['id']);
$file = 'tmp/' . $chapter['id'] . '.xml';
$chapter->asXML($file);

header("Location: $file");