<?php

$libraryPath = $_SERVER['DOCUMENT_ROOT'];
$patternsPath = './patterns';

function displayPatterns($directory) {

	$patternLibrary = array();

	if ( is_dir( $directory ) ) {

		$patterns = scandir( $directory );

		foreach ( $patterns as $pattern ) {

			if ( $pattern != '.' && $pattern != '..' ) {

				if ( is_dir( $directory.'/'.$pattern ) ) {

					$subpatterns = scandir( $directory.'/'.$pattern );

					if ( $subpatterns ) {

						$patternSwatch = array(
							'heading' => $pattern
						);

						$patternLibrary[] = $patternSwatch;
					}

					foreach ( $subpatterns as $subpattern ) {

						if ( $subpattern != '.' && $subpattern != '..' ) {

							if ( strpos( $subpattern, '.txt' ) !== false ) continue;

							$patternTitle = str_replace('-', ' ', $subpattern);
							$patternTitle = str_replace('.html', '', $patternTitle);
							$patternCode = @file_get_contents($directory.'/'.$pattern.'/'.$subpattern);
							$patternUsage = @file_get_contents($directory.'/'.$pattern.'/'.str_replace('.html', '.txt', $subpattern));
							
							$patternSwatch = array(
								'title' => $patternTitle,
								'code'	=> $patternCode,
								'usage'	=> $patternUsage
							);

							$patternLibrary[] = $patternSwatch;

						}

					}

				} else {

					if ( strpos( $pattern, '.txt' ) !== false ) continue;

					$patternTitle = str_replace('-', '.', $pattern);
					$patternTitle = str_replace('.html', '', $patternTitle);
					$patternCode = @file_get_contents($directory.'/'.$pattern);
					$patternUsage = @file_get_contents($directory.'/'.$pattern.'/'.str_replace('.html', '.txt', $subpattern));
					
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

		foreach ( $patternLibrary as $pattern ) {

			if ( $pattern['heading'] ) {

				echo "<h2 class=\"pattern-group-title\" id=\"".$pattern['heading']."\">".$pattern['heading']."</h2>";

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