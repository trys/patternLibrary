<?php

$libraryPath = $_SERVER['DOCUMENT_ROOT'];
$patternsPath = './patterns';


function displayPatterns($patternsPath) {
	$patternLibrary = gatherPatterns($patternsPath);
	if ( $patternLibrary ) {
		// Loop through all patterns
		foreach ( $patternLibrary as $pattern ) {

			if ( isset( $pattern['title'] ) && $pattern['title'] == '.DS_Store' ) continue;

			if ( isset($pattern['heading']) ) {
				echo "<h2 class=\"library pattern-group-title\" id=\"".$pattern['heading']."\">".$pattern['heading']."</h2>";
				if( $pattern['description'] )
					echo "<p class=\"library pattern-group-description\">".$pattern['description']."</p>";
			} else {
				echo "	  <article class=\"pattern\" id=\"".$pattern['title']."\">\n";
				echo "	      <div class=\"pattern-details\">\n";
				echo "	          <header class=\"library pattern-summary\">\n";
				echo "	              <a href=\"#" . $pattern['title'] . "\">".$pattern['title']."</a>\n";
				echo "	          </header>\n";
				if ( isset( $_GET['code'] ) ) {
				echo "	          <pre class=\"pattern-markup-block language-markup\">\n";
				echo "	              <code class=\"pattern-markup language-markup\">\n";
				echo 					htmlspecialchars($pattern['code'])."\n";
				echo "	              </code>\n";
				echo "	          </pre>\n";
				echo "            <aside class=\"library pattern-usage pattern-usage-slim\"><strong>Usage:</strong>".$pattern['usage']."</aside>\n";
				} elseif ( $pattern['usage'] ) {
				echo "            <aside class=\"library pattern-usage pattern-usage-full\"><strong>Usage:</strong>".$pattern['usage']."</aside>\n";
				}
				echo "	      </div>\n";
				echo "	      <div class=\"pattern-preview\">\n";
				echo "	          ".$pattern['code']."\n";
				echo "	      </div>\n";
				echo "	  </article>\n";
			}
		}
	}
}

function displayPatternNav($patternsPath) {
	$patternLibrary = gatherPatterns($patternsPath);
	foreach ( $patternLibrary as $pattern ) {
		if ( isset($pattern['heading']) ) {
			echo "<li class=\"pattern-nav-title\"><a href=\"#".$pattern['heading']."\">".$pattern['heading']."</a></li>";
		}
	}
}


function gatherPatterns($patternsPath) {

	$patternLibrary = array();

	if ( is_dir( $patternsPath ) ) {

		$patterns = scandir( $patternsPath );

		// Loop through patterns directory and pick out all files and sub-directories.
		foreach ( $patterns as $pattern ) {

			if ( $pattern != '.' && $pattern != '..' ) {

				// If pattern is a sub-directory
				if ( is_dir( $patternsPath.'/'.$pattern ) ) {

					$subpatterns = scandir( $patternsPath.'/'.$pattern );

					if ( count ( $subpatterns ) > 2 ) {

						$patternDescription = @file_get_contents($patternsPath.'/'.$pattern.'/'.$pattern.'.txt');

						// Create pattern-group-title from sub-directory name
						$patternSwatch = array(
							'heading' 	  => $pattern,
							'description' => $patternDescription
						);

						$patternLibrary[] = $patternSwatch;

						// Loop sub-directory files and push to patternLibrary
						foreach ( $subpatterns as $subpattern ) {

							if ( $subpattern != '.' && $subpattern != '..' ) {

								// Skip iteration if is usage file
								if ( strpos( $subpattern, '.txt' ) !== false ) continue;

								$patternTitle = str_replace('-', ' ', $subpattern);
								$patternTitle = str_replace('.html', '', $patternTitle);
								$patternCode = @file_get_contents($patternsPath.'/'.$pattern.'/'.$subpattern);
								$patternUsage = @file_get_contents($patternsPath.'/'.$pattern.'/'.str_replace('.html', '.txt', $subpattern));
								
								$patternSwatch = array(
									'title' => $patternTitle,
									'code'	=> $patternCode,
									'usage'	=> $patternUsage
								);

								$patternLibrary[] = $patternSwatch;

							}

						}
					}

				} else {

					// Skip iteration if is usage file
					if ( strpos( $pattern, '.txt' ) !== false ) continue;

					$patternTitle = str_replace('-', '.', $pattern);
					$patternTitle = str_replace('.html', '', $patternTitle);
					$patternCode = @file_get_contents($patternsPath.'/'.$pattern);
					$patternUsage = @file_get_contents($patternsPath.'/'.$pattern.'/'.str_replace('.html', '.txt', $subpattern));
					
					$patternSwatch = array(
						'title' => $patternTitle,
						'code'	=> $patternCode,
						'usage' => $patternUsage
					);

					$patternLibrary[] = $patternSwatch;

				}

			}

		}

	}

	return $patternLibrary;

}



?>