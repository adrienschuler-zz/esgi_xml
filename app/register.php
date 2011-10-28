<div class="page-header">
	<h2>Inscription</h2>
</div>

<?php display_messages(); ?>

<div id="register-container">
	<form action="#" method="post">
		<p><input type="text" name="user[login]" placeholder="Identifiant"></p>
		<p><input type="password" name="user[password]" placeholder="Mot de passe"></p>
		<p><input type="password" name="user[confirmation]" placeholder="Confirmation"></p>
		<p><input type="submit" name="submit" value="Inscription" class="btn"></p>
	</form>
</div>

<?php
	if (isset($_POST['submit'])) {
		$user = new User();
		$user->register($_POST['user']);
	}
?>