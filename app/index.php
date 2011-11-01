<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Le livre dont vous êtes le Héro</title>

	<link href="http://fonts.googleapis.com/css?family=Rochester" rel="stylesheet">
	<link href="stylesheets/libs/twitter-bootstrap-1.3/less/bootstrap.less" rel="stylesheet/less" media="all">
	<link href="stylesheets/libs/prettify.css" rel="stylesheet">
	<link href="stylesheets/less/styles.less" rel="stylesheet/less" media="all">

	<script src="javascripts/libs/less-1.1.3.min.js"></script>
	<script src="javascripts/libs/jquery-1.6.4.min.js"></script>
	<script src="javascripts/plugins/jquery.tmpl.min.js"></script>
	<script src="javascripts/plugins/jquery.lettering.js"></script>
	<script src="javascripts/plugins/jquery.tablesorter.min.js"></script>
	<script src="javascripts/plugins/twitter-bootstrap-1.3/bootstrap-modal.js"></script>
	<script src="javascripts/plugins/twitter-bootstrap-1.3/bootstrap-alerts.js"></script>
	<script src="javascripts/libs/prettify.js"></script>
</head>
<body>
	<!-- nav -->
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="?p=admin">Projet XML</a>
				<div class="credentials">
					<p>
						<?php if (isset($_SESSION['user'])) : ?>
							Vous êtes connecté en tant que <?php echo $_SESSION['user']['login']; ?>&nbsp;&nbsp;
							<a href="?p=logout">Déconnexion</a>
						<?php else : ?>
							Vous n'êtes pas identifé.&nbsp;&nbsp;
							<a href="?p=login">Connexion</a>
							ou&nbsp; 
							<a href="?p=register">Inscription</a>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<?php
			check_session();

			if (isset($_GET['p'])) {
				$file = APP . $_GET['p'] . '.php';
				if (file_exists($file)) {
					require $file;
				}
			} else {
				require APP . 'admin.php';
			}
		?>
	</div>

	<footer>
		<p>
			ESGI - 5PPA - AL<br><br>
			Ahcéne IDINARENE<br>
			Alain JANIN-MANIFICAT<br>
			Adrien SCHULER<br>
		</p>
	</footer>

<script>
	$(function() {
		prettyPrint();
	});
</script>

</body>
</html>
