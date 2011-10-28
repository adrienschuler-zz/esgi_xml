<div class="page-header">
	<h2>Connexion</h2>
</div>

<?php display_messages(); ?>

<div id="login-container">
	<form action="#" method="post">
		<p><input type="text" name="user[login]" placeholder="Identifiant"></p>
		<p><input type="password" name="user[password]" placeholder="Mot de passe"></p>
		<p><input type="submit" name="submit" value="Connexion" class="btn"></p>
	</form>
</div>

<?php
	if (isset($_POST['submit'])) {
		$user = new User();
		$user->login($_POST['user']);
	}
?>