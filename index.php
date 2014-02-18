<?php include_once('functions.php');?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<title>tomango - pattern library &amp; front-end style-guide</title>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href="css/patternLibrary.css" rel="stylesheet" />
	</head>
	<body class="library">
		<header class="library-banner">
			<h1 class="library-title"></h1>
			<h2 class="library-subtitle">pattern library &amp; front-end style-guide</h2>
		</header>
		<main role="main" class="library-container">
			<?php displayPatterns($patternsPath);?>
		</main>
	</body>
</html>