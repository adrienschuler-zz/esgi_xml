<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Le livre dont vous êtes le Héro</title>

	<link href="http://fonts.googleapis.com/css?family=Rochester" rel="stylesheet">
	<link href="stylesheets/libs/twitter-bootstrap-1.3/less/bootstrap.less" rel="stylesheet/less" media="all">
	<link href="stylesheets/less/styles.less" rel="stylesheet/less" media="all">

	<script src="javascripts/libs/less-1.1.3.min.js"></script>
	<script src="javascripts/libs/jquery-1.6.4.min.js"></script>
	<script src="javascripts/plugins/jquery.tmpl.min.js"></script>
	<script src="javascripts/plugins/jquery.lettering.js"></script>
	<script src="javascripts/plugins/jquery.tablesorter.min.js"></script>
	<script src="javascripts/plugins/twitter-bootstrap-1.3/bootstrap-modal.js"></script>
</head>
<body>

	<div class="topbar">
		<div class="fill">
			<div class="container">
				<h1 class="brand">ESGI - Projet XML</h1>
				<p>
					Vous êtes connecté en tant que "unknow". 
					<a href="?p=logout">Déconnexion</a>
				</p>
			</div>
		</div>
	</div>

	<div class="container">
		<?php 
			if (isset($_GET['p'])) {
				require APP . $_GET['p'] . '.php';
			} else {
				require APP . 'admin.php';
			}
		?>
	</div>

</body>
</html>
