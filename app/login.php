<div id="login-container">
	<form action="#" method="post">
		<p><input type="text" name="user[login]" placeholder="Login"></p>
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