<!DOCTYPE html>
<html lang="en">
	<!-- 
		Basic Site's Information
	-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nepal's First URL shortener</title>
	<meta name="robots" content="noindex, nofollow">
	<meta name="keywords" content="url shortner">
	<meta name="description" content="Nepal's One and Only Url Shortner.">
	<meta name="application-name" content="url_shortner">
	<meta name="author" content="Puncoz Nepal [http://www.puncoz.com]">

	<!-- 
		FAVICON
	-->
	<link rel="icon" sizes="16x16" type="image/x-icon" href="<?php echo base_url() ?>assets/images/favicon.ico">

	<!-- 
		Style Sheets
	-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/custom/css/style.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url() ?>assets/vendor/html5shiv.min.js"></script>
      <script src="<?php echo base_url() ?>assets/vendor/respond.min.js"></script>
      <![endif]-->
      </html>
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
				<a class="navbar-brand" href="<?php echo base_url() ?>" title="Nepal's First URL Shortner">URL Shortner</a>
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

		<div id="short_url" class="row" style="display:none">
			<div class="col-md-4 col-md-offset-4">
				
				<div class="alert alert-success text-centered" role="alert">
					<code>
						http://short.url.np/askdf3242n
					</code>
				</div>

			</div><!-- /.col -->
		</div><!-- /.row -->

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				
				<?php

				?>
				<div class="form-group">
					<label for="" class="hidden">Long URL</label>
					
				</div>
				<div class="form-group has-error has-feedback">
					<label class="control-label" for="long_url">Long URL</label>
					<input type="url" class="form-control" id="long_url" name="long_url" aria-describedby="form_feedback" placeholder="eg: http://www.example.com/" required autofocus>
					<span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true"></span>
					<span id="form_feedback" class="sr-only">(error)</span>
				</div>
				<button type="submit" class="btn btn-success btn-block">Shorten</button>
			</form>

		</div><!-- /.col -->
	</div><!-- /.row -->

</section><!-- /#main_content -->

	<!--
		Footer
	-->
	<footer>
		<div class="container">
			<p class="text-centered">
				&copy; <?php echo mdate("%Y",time()) ?> <a href="http://www.puncoz.com" target="_blank">Puncoz Nepal</a> | All Right Reserved.
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
	<script src="<?php echo base_url() ?>assets/custom/js/scripts.js"></script>

</body>
</html>