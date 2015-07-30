
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="Biblioteca-Merial" />

		<link href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/funcoes.js"></script>
		<script type="text/javascript" src="ajaxMethods.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#gallery a').lightBox({
					fixedNavigation : true
				});
				$('.thumbnail').tooltip()
			});
		</script>
		<title>Biblioteca Virtual</title>
	</head>