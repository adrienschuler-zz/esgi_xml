<?php
$B = new Book();
$book = $B->read($_GET['id']);
$chapters = $B->getChapters();
?>
<div class="page-header">
	<h2><?php echo $book['title'];?></h1>
</div>

<div class="box-center">

	<form method="post" action="#" enctype="multipart/form-data" value="8000000">
	
		<p>
			<label> XPATH
			<input type="text" name="xpath" style="width:250px;">
			</label>
		</p>
		<p>
			<label>Consulter l'indroduction ?
			<input type="checkbox" name="introduction">
			</label>
		</p>
		<p>
				<label>Consulter un chapitre</label>
				<select name="chapter">
					<option value="">-</option>
					<?php foreach ($chapters as $chapter)
							echo '<option value="'.$chapter['code'].'">'.$chapter['code'].'</option>';						
					?>
				</select>
				<div id="formChoiceDiv"></div>
		</p>
		
		<div class="well">
			<input type="submit" name="submit" value="Afficher" class="btn primary" id="create_but">
			<a href="?p=admin" class="btn">Retour</a>
			
		</div>
	</form>
</div>
<p class="content"> <b>Résultat :</b> </p>
<div id="divResult">
<?php
$f="";
if (isset($_POST['submit'])) {
	
	if(isset($_POST["xpath"]) && !empty($_POST["xpath"]))
	{
		// XPATH
		$file=$B->queryXPATH($_POST["xpath"]);
		if($file !=null && ('' != file_get_contents($file)))
		{		
			$f=$file;
			echo "Consulter votre résultat ci-dessous. Vous avez la possiblité de le télécharger sous format texte.";
		}else
		{
			echo 'Aucun résultat trouvé.';
		}
	}	
	if(isset($_POST["introduction"]))
	{
		// Introduction
		echo "<b>Introduction</b> <br/>";
		echo "-------------------------------------------------------- <br/>";
		$B->getIntroduction();
		echo "<br/><br/>";
	}
	if(isset($_POST["chapter"]) && $_POST["chapter"] !=null)
	{
		foreach($chapters as $chapter)
		{
			if($chapter['code'] == $_POST["chapter"])
			{
				// Chapitre
				echo "<b>Chapitre ".$_POST["chapter"]."</b> <br/>";
				echo "-------------------------------------------------------- <br/>";
				echo $chapter->text;
			}
		}
	}
}

?>
</div>
<a href="?p=download&choice=download&id=<?php echo $_GET['id']; ?>&file=<?php echo $f; ?>">Télécharger</a>
<iframe src="?p=download&choice=consult&id=<?php echo $_GET['id']; ?>&file=<?php echo $f; ?>" width="100%" height="15%" scrolling=auto frameborder=1></iframe>
