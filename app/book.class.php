<?php

class Book {
	
	var $file;
	var $chapters = array();
	

	function __construct($book = null) {
		$this->file = simplexml_load_file(XML_FILE);
		
		if ($book && $this->check($book)) {
			$this->create($book);
		}
	}

	function check($book) {
		// TODO: vérifications

		return true;
	}

	function create($book) {
		$date = date("Y-m-d H:i:s");

		$livre = $this->file->addChild('book');
		$livre->addAttribute('id', uniqid());
		$livre->addAttribute('title', $book['title']);
		$livre->addAttribute('status', 2);
		$livre->addAttribute('created', $date);
		$livre->addAttribute('modified', $date);

		$intro = $livre->addChild('intro');
		//$intro->addChild('imageURL', $book['image']);
		$intro->addChild('text', $book['intro']);
		
		$this->file->asXML(XML_FILE);

		header('Location:?p=admin');
	}

	function read($id) {
		return $this->file->xpath("book[@id='$id']");
	}

	function update($book) {
		
	}

	function delete($id) {
		
	}

	function addChapter($chap){
		$this->chapters[] = $chap;
	}


}
