<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Le livre dont vous êtes le Héro</title>

	<link href="http://fonts.googleapis.com/css?family=Rochester" rel="stylesheet">
	<link href="stylesheets/libs/twitter-bootstrap-1.3/less/bootstrap.less" rel="stylesheet/less" media="all">
	<link href="stylesheets/less/styles.less" rel="stylesheet/less" media="all">
	<!--<link href="vendors/mercury/stylesheets/mercury.bundle.css" rel="stylesheet" media="all">-->

	<script src="javascripts/libs/less-1.1.3.min.js"></script>
	<script src="javascripts/libs/jquery-1.6.4.min.js"></script>
	<script src="javascripts/plugins/jquery.tmpl.min.js"></script>
	<script src="javascripts/plugins/jquery.lettering.js"></script>
	<!--<script src="vendors/mercury/javascripts/mercury_loader.js"></script>-->
</head>
<body>

	<?php 
		if (isset($_GET['p'])) {
			require APP . $_GET['p'] . '.php';
		} else {
			require APP . 'admin.php';
		}
	?>

</body>
</html>