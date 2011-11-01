<?php

class Chapter {

	var $book;
	var $file;
	var $chapter;

	function __construct($book_id = null, $chapter = null) {
		
		$this->book = new Book();
		if ($book_id) {
			$this->book = $this->book->read($book_id);
		}
		$this->file = simplexml_load_file(XML_FILE);
		$this->chapter = $chapter;
		if ($chapter && $this->check()) {
			$this->create($this->chapter);
		}
	}

	function check() {

		$this->chapter['number']=(int)$this->chapter['number'];
		$target_path = IMAGE_PATH . basename($_FILES['chap']['name']['image']);
		//Delete old image
		$id=$_GET['id'];
		$imgToDel = $this->file->xpath("//*/chapter[@id='$id']");
		if($imgToDel[0]->imageURL!=""){
			unlink(IMAGE_PATH .$imgToDel[0]->imageURL); 
		}
		if($_FILES['chap']['name']['image']!=""){
			if(move_uploaded_file($_FILES['chap']['tmp_name']['image'], $target_path)) {
				echo "The file ".  basename($_FILES['chap']['name']['image']). 
				" has been uploaded";
			} else{
				echo "There was an error uploading the file, please try again!";
				if($_FILES['chap']['error']['image'])
				{
					switch ($_FILES['chap']['error']['image'])
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
		}
		for ($i=0; $i < sizeof($this->chapter['choixRef']); $i++) {
			$this->chapter['choixRef'][$i] = (int)$this->chapter['choixRef'][$i];
		}

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
		$chap->addChild('imageURL', $_FILES['chap']['name']['image']);
		$chap->addChild('text', $chapter['text']);
		$chap->addChild('question', $chapter['question']);
		$choice = $chap->addChild('choice');

		for($i=0; $i < sizeof($chapter['choixRef']); $i++) {
			$answer = $choice->addChild('answer', $chapter['choixLib'][$i]);
			$answer->addAttribute('ref', $chapter['choixRef'][$i]);
		}
		
		$this->file->asXML(XML_FILE);

		flash_message('success', 'Le chaptire <u>n° ' . $chapter['number'] . '</u> a bien été créé.', 'Pensez à créer les chaptires qu\'il réfère.');
		header("Location:?p=update&id=" . $this->book['id']);
	}

	function read($id) {
		$chapter = $this->file->xpath("//*/chapter[@id='$id']");
		return $chapter[0];
	}

	function update($chapter) {
		$this->check($chapter);
		$date = date("Y-m-d H:i:s");
		$chap = $this->read($_GET['id']);
		$chap['modified'] = $date;
		$chap->imageURL = $_FILES['chap']['name']['image'];
		$chap->text = $chapter['text'];
		$chap->question = $chapter['question'];
		$choice = $chap->choice;
		for($i=0; $i < count($choice->answer); $i++) {
			$answer = $choice->answer[$i];
			$answer[0] = $chapter['choixLib'][$i];
			$answer['ref'] = $chapter['choixRef'][$i];
		}
		file_put_contents(XML_FILE, $this->file->asXml());

		flash_message('success', 'Modification du chapitre <u>' . $chap['code'] . '</u> réussi !');
		header('Location:?p=update&id='.$_GET['book_id']);
	}

	function delete($id) {
		
	}

}
