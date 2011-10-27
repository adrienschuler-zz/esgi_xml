<?php

class Book {
	
	var $file;
	var $book;
	

	function __construct($book = null) {
		$this->file = simplexml_load_file(XML_FILE);
		
		if ($book && $this->check($book)) {
			$this->create($book);
		}
	}

	function check($book) {
		$target_path = IMAGE_PATH . basename($_FILES['book']['name']['image']); 

		if(move_uploaded_file($_FILES['book']['tmp_name']['image'], $target_path)) {
			echo "The file ".  basename($_FILES['book']['name']['image']). 
			" has been uploaded";
		} else{
			echo "There was an error uploading the file, please try again!";
			if($_FILES['book']['error']['image'])
			{
				switch ($_FILES['book']['error']['image'])
				{
					case 1: // UPLOAD_ERR_INI_SIZE
						echo "Le fichier depasse la limite autorisee par le serveur (fichier php.ini) !";
						break;
					case 2: // UPLOAD_ERR_FORM_SIZE
						echo "Le fichier depasse la limite autorisee dans le formulaire HTML !";
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						echo "L'envoi du fichier a ete interrompu pendant le transfert !";
						break;
					case 4: // UPLOAD_ERR_NO_FILE
						echo "Le fichier que vous avez envoyé a une taille nulle !";
						break;
				}
			}
			return false;
		}
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
		$intro->addChild('imageURL', $_FILES['book']['name']['image']);
		$intro->addChild('text', $book['intro']);
		
		$this->file->asXML(XML_FILE);

		header('Location:?p=admin');
	}

	function read($id) {
		$book = $this->file->xpath("book[@id='$id']");
		$this->chapters = $this->file->xpath("book[@id='$id']/chapter");
		return $book[0];
	}

	function update($book) {
		
	}

	function delete($id) {
		
	}

	function getChapters() {
		return $this->chapters;
	}


}
