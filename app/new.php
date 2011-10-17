<h1>Création d'un livre</h1>

<div class="box-center">

	<form method="post" action="?p=new" enctype="multipart/form-data">
		<p>
			<label for="title">Titre</label>
			<input type="text" name="book[title]" id="title">
		</p>

		<p>
			<label for="image">Image</label>
			<input type="file" name="book[image]" id="image">
		</p>

		<p>
			<label for="intro">Introduction</label>
			<textarea name="book[intro]" id="intro" class="mercury-region" data-type="editable"></textarea>
		</p>

		<input type="submit" name="submit" value="Créer" class="btn primary">
		<a href="?p=admin" class="btn">Retour</a>

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		new Book($_POST['book']);
	}
?>