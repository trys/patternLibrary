<?php
$company = 'tomango';
$title   = 'pattern library &amp; front-end style-guide';
?>


<?php include_once('functions.php');?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<title><?php echo $company . ' - ' . $title;?></title>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="css/patternLibrary.css" rel="stylesheet" />
	</head>
	<body>
		<main role="main" class="library-container">
			<h1 class="library library-title"><?php echo $company . ' - ' . $title;?></h1>
			<p class="library library-description">
				This pattern library serves as a resource for anyone involved in this project for <?php echo $company;?>.
				All styles used on the website are outlined here and can be referenced when adding content or creating whole new sections of the website.<br />
				For a designer or developer wishing to see code examples, click <a href="?code=1">here</a>.
			</p>
			<?php displayPatterns($patternsPath);?>
		</main>
		<nav class="library library-nav">
			<span id="nav-controls"></span>
			<ul class="library-nav-list">
				<?php displayPatternNav($patternsPath);?>
			</ul>
		</nav>
		<script src="js/load.js"></script>
	</body>
</html>