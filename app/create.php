<h1>Création d'un livre</h1>

<div class="box-center">

	<form method="post" action="?p=create" enctype="multipart/form-data">
		<p>
			<label for="title">Titre</label>
			<input type="text" name="book[title]" onchange='is_validText(this.value, "valid_title")' id="title">
			<div id="valid_title" style="display:none">✓</div>
		</p>

		<p>
			<label for="image">Image</label>
			<input type="file" name="book[image]" onchange='is_validImage(this.value, "valid_image")' id="image">
			<div id="valid_image" style="display:none">✓</div>
		</p>

		<p>
			<label for="intro">Introduction</label>
			<textarea name="book[intro]" id="intro" class="mercury-region" data-type="editable"
				onchange='is_validText(this.value, "valid_intro")' ></textarea>
			<div id="valid_intro" style="display:none">✓</div>
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
function is_validImage(value, elmt){

	var fileName = value.match(/[-_\w]+[.][\w]+$/i)[0];
	var extension = fileName.substring(fileName.indexOf(".")+1);
	var extension_valide = new Array('jpeg','jpg','bmp','gif','png');
	if($.inArray(extension, extension_valide) != -1){
		document.getElementById(elmt).setAttribute("style","display:inline");
	}else{
		document.getElementById(elmt).setAttribute("style","display:none");
	}
}

function is_validText(value, elmt){
	if($.trim(value).length==0){
		document.getElementById(elmt).setAttribute("style","display:none");
	}
	else{
		document.getElementById(elmt).setAttribute("style","display:inline");
	}
	unlockCreation();
}

function unlockCreation(){
	if($("#valid_title").attr("style").indexOf("display:inline") != -1 &&
		$("#valid_intro").attr("style").indexOf("display:inline") != -1){

		$("#create_but").removeAttr("disabled");
	}
	else{
		$("#create_but").attr("disabled","disabled");
	}
}

</script>
