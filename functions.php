<?php

$libraryPath = $_SERVER['DOCUMENT_ROOT'];
$patternsPath = './patterns';

function displayPatterns($patternsPath) {

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

	if ( $patternLibrary ) {

		// Loop through all patterns
		foreach ( $patternLibrary as $pattern ) {

			if ( $pattern['heading'] ) {

				echo "<h2 class=\"pattern-group-title\" id=\"".$pattern['heading']."\">".$pattern['heading']."</h2>";
				if( $pattern['description'] )
					echo "<p class=\"pattern-group-description\">".$pattern['description']."</p>";

			} else {

				echo "	  <div class=\"pattern\" id=\"".$pattern['title']."\">\n";
				echo "	      <details class=\"pattern-details\">\n";
				echo "	          <summary class=\"pattern-summary\">\n";
				echo "	              ".$pattern['title']."\n";
				echo "	          </summary>\n";
				echo "	          <pre class=\"pattern-markup-block language-markup\">\n";
				echo "	              <code class=\"pattern-markup language-markup\">\n";
				echo 					htmlspecialchars($pattern['code'])."\n";
				echo "	              </code>\n";
				echo "	          </pre>\n";
				echo "            <aside class=\"pattern-usage\"><strong>Usage:</strong>".$pattern['usage']."</aside>\n";
				echo "	      </details>\n";
				echo "	      <div class=\"pattern-preview\">\n";
				echo "	          ".$pattern['code']."\n";
				echo "	      </div>\n";
				echo "	  </div>\n";

			}

		}

	}

}

?>