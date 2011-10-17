<?php

class Book {
	
	var $id;
	var $title;
	var $author;
	var $intro;
	var $image;
	var $created;
	var $modified;
	var $chapters;


	function __construct($book) {
		if ($this->check($book)) {
			$this->add($book);
			$this->save();
		}
	}

	function check($book) {
		// TODO: vérifications

		return true;
	}

	function add($book) {
		$date = date("Y-m-d H:i:s");
		$this->created = $date;
		$this->modified = $date;
		$this->title = $book['title'];
		$this->intro = $book['intro'];
		$this->id = uniqid();
		//$this->image = 
		//$this->author = $_SESSION['user']['full_name'];
		//$_SESSION['books'][$this->id] = $this;
	}

	function save() {
		//$file = simplexml_load_file(XML_FILE);

		$livre = new SimpleXMLElement('<livre></livre>');
		$livre->addAttribute('id', $this->id);
		$livre->addAttribute('titre', $this->title);
		$livre->addChild('created', $this->created);
		$livre->addChild('modified', $this->modified);

		$intro = $livre->addChild('intro');
		$intro->addChild('imageURL', $this->image);
		$intro->addChild('text', $this->intro);
		
		$livre->asXML(XML_FILE);
	}

	function edit() {
		
	}

	function delete($id) {
		
	}


}