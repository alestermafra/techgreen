<!DOCTYPE html>
<html>
<head>
	<title>Mind Gold</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!----------- B O O T S T R A P ------------->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<!------------------------------------------->
    
	<link href="<?php echo $this->url('/css/css.css'); ?>" rel="stylesheet">
    
	<script src="<?php echo $this->url('/js/mgold.js'); ?>"></script>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
	
	<style>
		html, body {
			margin: 0;
			padding: 0;
		}
	</style>
	
	<script type="text/javascript">
		var APP_BASE = '<?php echo $this->controller->request->base ?>';
	</script>
</head>
<body class="bg-light">

<?php echo $this->element('nav') ?>

<style>
	.menu-container {
		position: fixed;
		top: 56px;
		bottom: 0;
		width: 250px;
		overflow-y: auto;
		z-index: 2;
	}
	
	.content-container {
		margin-left: 250px;
	}
	
	@media only screen and (max-width: 991px) {
		.content-container {
			margin-left: 0;
		}
		
		.menu-container {
			position: fixed;
			top: 56px;
			bottom: 0;
			margin-left: -250px;
			-webkit-transition: margin .25s ease-out;
			-moz-transition: margin .25s ease-out;
			-o-transition: margin .25s ease-out;
			transition: margin .25s ease-out;
		}
		
		.menu-container-screen-background {
			display: none;
			content: "";
			position: fixed;
			z-index: 2;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background-color: rgba(0, 0, 0, .5);
		}
		
		.menu-container.toggle {
			margin-left: 0;
		}
		
		.menu-container-screen-background.toggle {
			display: block;
		}
	}
</style>

<div class="menu-container-screen-background"></div>

	<div class="menu-container bg-dark" style="max-width: 250px; padding-right: 0;">
		<?php echo $this->element('menu', array('menu' => $menu)); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.navbar-toggler, .menu-container-screen-background').click(function() {
					$('.menu-container, .menu-container-screen-background').toggleClass('toggle');
				});
			});
		</script>
	</div>
	
	<div class="content-container">
		<?php echo $content_for_layout ?>
		<?php //echo $this->element('sql_debug'); ?>
	</div>

</body>
</html>