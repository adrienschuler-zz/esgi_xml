<?php

class Chapter {

	var $book;
	var $file;

	function __construct($book_id, $chapter = null) {
		
		$this->book = new Book();
		$this->book = $this->book->read($book_id);
		$this->book = $this->book[0];
		$this->file = simplexml_load_file(XML_FILE);
	
		if ($chapter && $this->check($chapter)) {
			$this->create($chapter);
		}
	}

	function check($chapter) {
		// TODO: vérifications

		return true;
	}

	function create($chapter) {
		$date = date("Y-m-d H:i:s");
		$currentBook = $this->file->xpath("//*/book[@id='".$this->book['id']."']");
		$chap = $currentBook[0]->addChild('chapter');
		$chap->addAttribute('code', $chapter['number']);
		$chap->addAttribute('id', uniqid());
		$chap->addAttribute('status', 2);
		$chap->addAttribute('created', $date);
		$chap->addAttribute('modified', $date);
		$chap->addChild('imageURL', $chapter['image']);
		$chap->addChild('text', $chapter['text']);
		$chap->addChild('question', $chapter['question']);
		$choice = $chap->addChild('choice');

		for($i=0; $i < sizeof($chapter['choixRef']); $i++) {
			$answer = $choice->addChild('answer', $chapter['choixLib'][$i]);
			$answer->addAttribute('ref', $chapter['choixRef'][$i]);
		}
		
		$this->file->asXML(XML_FILE);

		header('Location:?p=admin');
	}

	function read($id) {
		return $this->book->read($book_id)->xpath("chapter[@id='$id']");
	}

	function update($chapter) {
		
	}

	function delete($id) {
		
	}

}
