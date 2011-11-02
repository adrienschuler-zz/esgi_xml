<?php

class Book {
	
	var $file;
	var $book;
	var $id;
	

	function __construct($book = null) {
		$this->file = simplexml_load_file(XML_FILE);
		
		if ($book && $this->check($book)) {
			$this->create($book);
		}
	}

	function check($book) {
		$cover_path = IMAGE_PATH . "livres/" . $book['title'] . "/cover/";
		mkdir($cover_path, 0777, true);
		$target_path = $cover_path . basename($_FILES['book']['name']['image']);
		//Delete old image
		$imgToDel = $this->file->xpath("book[@id='$this->id']/intro/imageURL");
		if($imgToDel[0][0]!=""){
			unlink($cover_path .$imgToDel[0][0]); 
		}
		if($_FILES['book']['name']['image']!=""){
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
		}
		return true;
	}

	function create($book) {
		$date = date("Y-m-d H:i:s");

		$livre = $this->file->addChild('book');
		$livre->addAttribute('id', uniqid());
		$livre->addAttribute('title', htmlspecialchars($book['title'], ENT_QUOTES));
		$livre->addAttribute('author', $_SESSION['user']['login']);
		$livre->addAttribute('created', $date);
		$livre->addAttribute('modified', $date);

		$intro = $livre->addChild('intro');
		$intro->addChild('imageURL', $_FILES['book']['name']['image']);
		$intro->addChild('text', htmlspecialchars($book['intro'], ENT_QUOTES));
		
 		$dom = new DOMDocument('1.0');
	 	$dom->preserveWhiteSpace = false;
	 	$dom->formatOutput = true;
	 	$dom->loadXML($this->file->asXML());
	 	$dom->save(XML_FILE);
		//$this->file->asXML(XML_FILE);

		flash_message('success', 'Création du livre <u>' . $book['title'] . '</u> réussi !', 'Vous pouvez dès à présent le compléter via le bouton d\'édition (<span class="edit"></span>).');
		header('Location:?p=admin');
	}

	function read($id) {
		$book = $this->file->xpath("book[@id='$id']");
		$this->id = $book[0]['id'];
		$this->chapters = $this->file->xpath("book[@id='$id']/chapter");
		return $book[0];
	}

	function update($book) {
		$this->check($book);
		foreach($this->file->book as $livre)
		{
			if ($livre['id'] == $this->id)
			{
				$livre['title'] = $book['title'];
				$livre['modified'] = date("Y-m-d H:i:s");
				$intro = $livre->intro;
				$intro->imageURL=$_FILES['book']['name']['image'];
				$intro->text=$book['intro'];
				break;
			}
		}
	 	$dom = new DOMDocument('1.0');
	 	$dom->preserveWhiteSpace = false;
	 	$dom->formatOutput = true;
	 	$dom->loadXML($this->file->asXML());
	 	$dom->save(XML_FILE);
		//file_put_contents(XML_FILE, $this->file->asXml());

		flash_message('success', 'Modification du livre <u>' . $book['title'] . '</u> réussi !');
		header('Location:?p=update&id='.$this->id);
	}

	function delete($id) {
		$book = $this->file->xpath("book[@id='$id']");
		
		$domRef = dom_import_simplexml($book[0]); 
	    $domRef->parentNode->removeChild($domRef);
	 	$dom = new DOMDocument('1.0');
	 	$dom->preserveWhiteSpace = false;
	 	$dom->formatOutput = true;
	 	$dom->loadXML($this->file->asXML());
	 	$dom->save(XML_FILE);

		flash_message('success', 'Livre supprimé !', '');
		header('Location: ?p=admin');
	}

	function delete_chapter($book_id, $id) {
		$chapter = $this->file->xpath("//chapter[@id='$id']");
		$domRef = dom_import_simplexml($chapter[0]); 
	    $domRef->parentNode->removeChild($domRef);
	 	$dom = new DOMDocument('1.0');
	 	$dom->preserveWhiteSpace = false;
	 	$dom->formatOutput = true;
	 	$dom->loadXML($this->file->asXML());
	 	$dom->save(XML_FILE);

		flash_message('success', 'Chapitre supprimé !', '');
		header('Location: ?p=update&id=' . $book_id);
	}

	function getChapters() {
		return $this->chapters;
	}

	function ParagUsedNCreated()
	{
		//Recupere le tableau des paragraphes[references] utilisés
		$parags = $this->file->xpath("//book[@id='".$this->id."']//answer/@ref");
		$paragUsed = array_unique($parags);
		//Recupere le tableau des paragraphes[codes] créés
		$paragCreated = $this->file->xpath("//book[@id='".$this->id."']//chapter/@code");
		$parUsedNCreated = Array();

		foreach($paragUsed as $pused)
		{
			$create=false;
			foreach($paragCreated as $pcreated)
			{
				if(trim($pused)==trim($pcreated)) 
					$create=true;			
			}
			if(!$create) 
			{	
				array_push($parUsedNCreated, $pused);					
			}
		}	
		$idUsedNCreated=array_unique($parUsedNCreated);
		return $idUsedNCreated;	
	}

	function getIntroduction() {
		$intro = $this->file->xpath("//book[@id='".$this->id."']/intro/text");
		foreach($intro as $node)
			echo htmlspecialchars($node);
	}

	function queryXPATH($query)
	{
		$file = 'tmp/'.uniqid().'.txt';
		$handle = fopen($file, 'w+');
		$result = $this->file->xpath($query);

		if(count($result)>0)
		{
			foreach($result as $node) {
				fwrite($handle, "\n" . $node->asXML());
			}
			fclose($handle);

			return $file;
		}else
			return null;
	}

}
