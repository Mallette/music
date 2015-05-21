<?php

// Mode DEBUG
$debug = false;

// Nom de la playlist
$playlist = $_GET['p'];

if( !empty($playlist) ){

	// Chemin de la playlist choisie
	$playlistPath = '/storage/playlists/'.$playlist;

	// Vérifie si le fichier existe
	$isFileExists = file_exists( $playlistPath );

	// Si la playlist existe
	if( $isFileExists ){
		
		$handle = fopen($playlistPath, "r");
		if ($handle) {
			while (($ligne = fgets($handle)) !== false) { 
			
				$titreTab = explode("/", $ligne);
				$c = count($titreTab);
				$sep = "/";
				
				$title = $titreTab[$c-1];
				$album = $titreTab[$c-2];
				$artist = $titreTab[$c-3];
				
				$titre = $artist. $sep .$album. $sep .$title;
				
				$res = ['track'=>
					[
						["src" => trim(htmlentities($ligne))],
						["art" => trim(htmlentities($artist))],
						["alb" => trim(htmlentities($album))],
						["tit" => trim(htmlentities($title))]
					]
				];
				
				// Ajoute la ligne au tableau
				$arrayTracks[] = $res;
			}
			fclose($handle);
			
			$resultats = ['resultat' => $arrayTracks];
			
			echo json_encode($resultats);
			
			
		} else {
			echo "<p class=\"alert alert-warning\">Problème de lecture de la playlist.</p>";
		}
	} else {
		echo "<p class=\"alert alert-warning\">La playlist $playlist n'existe pas.</p>";
	}
} else {
	echo "<p class=\"alert alert-warning\">Pas de playlist sélectionnée.</p>";
}


?>