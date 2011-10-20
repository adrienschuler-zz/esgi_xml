<?php  
	$book = new Book();
	$book = $book->read($_GET['id']);
	$book = $book[0];
?>

<h1>Création d'un chapitre</h1>

<div class="box-center">

	<form method="post" action="?p=create_chapter&id=<?php echo $book['id']; ?>" enctype="multipart/form-data">

		<p>
			<label for="title">Numéro du chapitre</label>
			<input type="text" name="chap[number]" id="number">
		</p>		

		<p>
			<label for="image">Image</label>
			<input type="file" name="chap[image]" id="image">
		</p>

		<p>
			<label for="texte">Texte</label>
			<textarea name="chap[text]" id="texte" class="mercury-region" data-type="editable"></textarea>
		</p>

		<p>
			<label for="texte">Question à poser</label>
			<input type="text" name="chap[question]" id="question">
		</p>

		<p>
			<label for="texte">Nombre de choix</label>
			<select onchange='createFormChoice(this.value);'>
				<option value="">-</option>
				<?php
					for($i=1;$i<=100;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select>
			<div id="formChoiceDiv"></div
		</p>

		<input type="submit" name="submit" value="Créer" class="btn primary">
		<a href="?p=admin" class="btn">Retour</a>

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		new Chapter($book['id'], $_POST['chap']);
	}
?>

<script>
function createFormChoice(nbForm) {
	var div = $('#formChoiceDiv'),
		nbFormHere = $("#formChoiceDiv > div").size();

	for(var i = nbFormHere; i < nbForm; i++) {
		var divFormElement = $('<div></div>'),
			lRef = $('<label>Chapitre référencé :</label>'),
			inputRef = $('<input type=text name=chap[choixRef]['+i+']>'),
			lLibelle = $('<label>Libellé du choix :</label>'),
			inputLibelle = $('<input type=text name=chap[choixLib]['+i+']>');

		div.append(
			divFormElement.append(lRef, inputRef, lLibelle, inputLibelle)
		);
	}
}
</script>
