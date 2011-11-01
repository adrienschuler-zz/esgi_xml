<h1>Création d'un livre</h1>

<div class="box-center">

	<form method="post" action="?p=create" enctype="multipart/form-data">
		<p>
			<label for="title">Titre</label>
			<input type="text" name="book[title]" id="title">
			<span id="title_error" class=""></span>
		</p>

		<p>
			<label for="image">Image</label>
			<input type="file" name="book[image]" id="image">
			<span id="image_error" class=""></span>
		</p>

		<p>
			<label for="intro">Introduction</label>
			<textarea name="book[intro]" id="intro" class="mercury-region" data-type="editable"></textarea>
			<span id="intro_error" class=""></span>
		</p>

		<a href="?p=admin" class="btn">Retour</a>
		<input type="submit" name="submit" value="Créer" class="btn primary" disabled="disabled" id="create_but">

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		new Book($_POST['book']);
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


$('#title, #intro').live('change', function() {
	check($(this), $.trim($(this).val()).length == 0);
	unlockCreation();
});

$('#image').bind('change', function() {
	var extension_valide = ['jpeg','jpg','bmp','gif','png'],
		fileName = $(this).val().match(/[-_\w]+[.][\w]+$/i)[0],
		extension = fileName.substring(fileName.indexOf(".") + 1);

	check($(this), $.inArray(extension, extension_valide) == -1);
	unlockCreation();
});
</script>
