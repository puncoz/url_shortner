<?php echo doctype('html5') ?>
<html lang="en">
<head>
	<!-- 
		Basic Site's Information
	-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page_info['title'] ?></title>
	<meta name="robots" content="noindex, nofollow">
	<meta name="keywords" content="<?php echo $page_info['meta_keywords'] ?>">
	<meta name="description" content="<?php echo $page_info['meta_description'] ?>">
	<meta name="application-name" content="short.url.np">
	<meta name="author" content="Puncoz Nepal [http://www.puncoz.com]">
	<meta name="base_url" content="<?php echo base_url() ?>">

	<!-- 
		FAVICON
	-->
	<?php echo link_tag('assets/images/favicon.ico', 'shortcut icon', 'image/ico') ?>

	<!-- 
		Style Sheets
	-->	
	<?php echo link_tag('assets/vendor/bootstrap/css/bootstrap.min.css') ?>
	<?php echo link_tag('assets/vendor/font-awesome/css/font-awesome.min.css') ?>
	<?php echo link_tag('assets/custom/css/style.css') ?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url() ?>assets/vendor/html5shiv.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body>

	<!--
		TOP NAVIGATION BAR
	-->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">NAV</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url() ?>" title="Nepal's First URL Shortner">short.URL.np</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>

	<!--
		Main Container
	-->
	<section id="main_content" class="container">

		<?php echo $page_content ?>

	</section><!-- /#main_content -->

	<!--
		Footer
	-->
	<footer>
		<div class="container">
			<p class="text-centered">
				&copy; <?php echo mdate("%Y",time()) ?> <a href="<?php echo base_url() ?>">short.URL.np</a> | Project By <a href="http://www.puncoz.com" target="_blank">Puncoz Nepal</a> | All Right Reserved.
			</p>
		</div>
	</footer>

	<!--
		Scripts
	-->
	<script src="<?php echo base_url() ?>assets/vendor/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="<?php echo base_url() ?>assets/vendor/ie10-viewport-bug-workaround.js"></script>
	<!-- jQuery Copy -->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/vendor/jquery.zclip/jquery.zclip.min.js"></script>

	<script src="<?php echo base_url() ?>assets/custom/js/scripts.js"></script>

</body>
</html>