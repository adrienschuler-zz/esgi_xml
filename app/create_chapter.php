<?php  
	$book = new Book();
	$book = $book->read($_GET['id']);
?>

<h1>Création d'un chapitre</h1>

<div class="box-center">

	<form method="post" action="?p=create_chapter&id=<?php echo $book['id']; ?>" enctype="multipart/form-data" value="8000000">

		<p>
			<label for="number">Numéro du chapitre</label>
			<input type="text" name="chap[number]" id="number" value="<?php if (isset($_GET['chap'])) echo $_GET['chap']; ?>">
			<span id="number_error"></span>
		</p>
		<p>
			<label for="image">Image</label>
			<input type="file" name="chap[image]" id="image">
			<span id="image_error"></span>
		</p>

		<p>
			<label for="texte">Texte</label>
			<textarea name="chap[text]" id="texte"></textarea>
			<span id="texte_error"></span>
		</p>

		<p>
			<label for="question">Question à poser</label>
			<input type="text" name="chap[question]" id="question">
			<span id="question_error"></span>
		</p>

		<p>
			<label>Nombre de choix</label>
			<select onchange='createFormChoice(this.value);'>
				<option value="">-</option>
				<?php
					for($i=1;$i<=10;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select>
			<div id="formChoiceDiv"></div
		</p>

		<br><br>

		<a href="?p=update&id=<?php echo $book['id']; ?>" class="btn">Retour</a>
		<input type="submit" name="submit" value="Créer" disabled="disabled" class="btn primary" id="create_but">

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
		var divFormElement = 	$('<div></div>'),
			lRef = 				$('<label>Chapitre référencé :</label>'),
			inputRef = 			$('<input type=text name=chap[choixRef]['+i+'] class="choixRef" id=choixRef'+i+'>'),
			valid_chapter_ref = $('<span id="choixRef'+i+'_error"></span>'),
			lLibelle = 			$('<label>Libellé du choix :</label>'),
			inputLibelle = 		$('<input type=text name=chap[choixLib]['+i+'] class="choixLib" id=choixLib'+i+'>'),
			valid_ref_lib = 	$('<span id="choixLib'+i+'_error"></span>');

		div.append(
			divFormElement.append(lRef, inputRef,valid_chapter_ref, lLibelle, inputLibelle, valid_ref_lib)
		);
	}
}

function check($elem, bool) {
	var container = $('#' + $elem.prop('id') + '_error');
	if (bool) {
		container.removeClass('form_ok');
		container.addClass('form_error');
	} else {
		container.removeClass('form_error');
		container.addClass('form_ok');
	}
}

function unlockCreation() {
	if ($('.form_error').length == 0) {
		$('#create_but').removeAttr('disabled');
	} else {
		$('#create_but').attr('disabled', 'disabled');
	}
}

$('#texte, #question, .choixLib').live('change', function() {
	check($(this), $.trim($(this).val()).length == 0);
	unlockCreation();
});

$('#number, .choixRef').live('change', function() {
	check($(this), isNaN($(this).val()));
	unlockCreation();
});

$('#image').bind('change', function() {
	var extension_valide = ['jpeg','jpg','bmp','gif','png'],
		fileName = $(this).val().match(/[-_\w]+[.][\w]+$/i)[0],
		extension = fileName.substring(fileName.indexOf(".") + 1);

	check($(this), $.inArray(extension, extension_valide) == -1);
});
</script>
