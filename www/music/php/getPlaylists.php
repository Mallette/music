<?php

// Mode DEBUG
$debug = false;

// Répertoire où créer les playlists
$playlistsDir = '/storage/playlists/';

// Vérifie si le répertoire existe
$isFileExists = file_exists( $playlistsDir );

// Si non, on peut créer ou vérifier l'existence du ficher
if( $isFileExists ){
	
	$playlistsFiles = scandir($playlistsDir);
	natcasesort($playlistsFiles);
	
	if( count($playlistsFiles) > 2 ) {
		
		$isMenu = isset($_GET['menu']) && !empty($_GET['menu']) && ($_GET['menu'] == 'OK');
		if($debug) echo "isMenu = $isMenu<br>";
		
		foreach( $playlistsFiles as $playlist ) {
			if( strlen($playlist) > 2 ) {
				if($isMenu){
					$res .= "\"$playlist\": {\"name\": \"$playlist\", \"icon\": \"playlist\"},";
				} else {
					$res = ["name" => "$playlist", "icon" => "playlist" ];
					$wrapper[] = $res;
				}
			}
		}
		
		if($isMenu){
			if($debug) echo "Pour menu<br>";
			echo "{ ".substr($res, 0, strlen($res)-1)." }";
		} else {
			if($debug) echo "Pour ouverture popup<br>";
			echo json_encode($wrapper);
		}
		
	} else {
		echo "<p class=\"alert alert-info\">Aucune playlist n'a été créé pour le moment.</p>";
	}
	
} else {
	echo "<p class=\"alert alert-warning\">Le répertoire de playlists n'existe pas.</p>";
}


?>