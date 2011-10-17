<?php  
	$book = new Book();
	$book = $book->read($_GET['id']);
	print_r($book);
?>