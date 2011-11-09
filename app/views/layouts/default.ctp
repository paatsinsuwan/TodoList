<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>index</title>
        <!--[if IE]>
                <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<?php echo $this->Html->css('screen.css'); ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script src="http://ajax.cdnjs.com/ajax/libs/underscore.js/1.1.4/underscore-min.js"></script>
        <script src="http://ajax.cdnjs.com/ajax/libs/backbone.js/0.3.3/backbone-min.js"></script>
		<?php echo $this->Html->script('Application.js'); ?>
</head>
<body>
	<div id="content">

		<?php 
			// not using at the moment
			//echo $this->Session->flash(); 
		?>

		<?php echo $content_for_layout; ?>

	</div>
</body>
</html>