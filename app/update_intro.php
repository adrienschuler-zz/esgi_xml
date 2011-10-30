<h1>Modification d'un livre</h1>
<?php  
	$bookObject = new Book();
	$book = $bookObject->read($_GET['id']);
?>

<div class="box-center">

	<form method="post" action="#" enctype="multipart/form-data">
		<p>			
			<label for="title">Titre</label>
			<input type="text" name="book[title]" id="title" value="<?php echo $book['title'];?>" >
			<span id="title_error" class=""></span>
		</p>

		<p>
			<label for="image">Image (image actuellement utilisée : <?php echo $book->intro->imageURL;?>) Pensez à l'uploader de nouveau pour la conserver.</label>
			<input type="file" name="book[image]" id="image">
			<span id="image_error" class=""></span> 
		</p>

		<p>
			<label for="intro">Introduction</label>
			<textarea name="book[intro]" id="intro" class="mercury-region" data-type="editable"><?php echo $book->intro->text;?></textarea>
			<span id="intro_error" class=""></span>
		</p>

		<input type="submit" name="submit" value="Modifier" class="btn primary" disabled="disabled" id="create_but">
		<a href="?p=update&id=<?php echo $book['id']; ?>" class="btn">Retour</a>

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		$bookObject->update($_POST['book']);
	}
?>

<script>
function unlockCreation(){
	if($("#title_error").attr("class").indexOf("form_ok") != -1 &&
		$("#image_error").attr("class").indexOf("form_error") == -1 &&
		$("#intro_error").attr("class").indexOf("form_ok") != -1){

		$("#create_but").removeAttr("disabled");
	}
	else{
		$("#create_but").attr("disabled","disabled");
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


$('#title, #intro').bind('change', function() {
	check($(this), $.trim($(this).val()).length == 0);
	unlockCreation();
});
$('#title, #intro').trigger('change');

$('#image').bind('change', function() {
	var extension_valide = ['jpeg','jpg','bmp','gif','png'],
		fileName = $(this).val().match(/[-_\w]+[.][\w]+$/i)[0],
		extension = fileName.substring(fileName.indexOf(".") + 1);

	check($(this), $.inArray(extension, extension_valide) == -1);
	unlockCreation();
});
</script>
