<?php

/*******************************
* Ajoute la chanson en SESSION
*******************************/

session_start();

// Mode DEBUG
$debug = false;
$url = $_GET['url'];
$name = $_GET['name'];
$playlist = $_GET['playlist'];


if( isset($url) && !empty($url) 
	&& isset($name) && !empty($name)
	&& isset($playlist) && !empty($playlist) ){

	// Chemin de la playlist
	$playlistDir = '/storage/playlists/'.$playlist;
	
	// Vérifie si le répertoire existe
	$isPlaylistExists = file_exists( $playlistDir );

	if( $isPlaylistExists ){
		
		$fileHandler = fopen($playlistDir, 'a+');
		$content = $url."\n";
		fwrite($fileHandler, $content);
		fclose($fileHandler);
		
		echo "<p class=\"alert alert-info\">La playlist <b>$name</b> a bien été ajouté à la playlist <b>$playlist</b>.</p>";
		
	} else {
		echo "<p class=\"alert alert-warning\">La playlist n'existe pas.</p>";
	}

} else {
	echo "<p class=\"alert alert-warning\">L'url, le nom ou la playlist n'est pas définie ($url, $playlist).</p>";
}


?>