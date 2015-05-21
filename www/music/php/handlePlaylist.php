<?php

// Nom de la playlist
$playlistName = trim($_GET['title']);
// si TRUE  : on crée le fichier
// si FALSE : on vérifie si le fichier existe
$isCreation = $_GET['create'];

// Mode DEBUG
$debug = false;
if($debug) echo "Nom de la playlist à enregistrer : '".$playlistName."'<br/>";
if($debug) echo "Demande de création de fichier : '".$isCreation."'<br/>";

// Si le nom de la playlist n'est pas vide
if( isset($playlistName) && !empty($playlistName) && !empty($isCreation) && strlen($playlistName) > 2){
	
	// Répertoire où créer les playlists
	$root = '/storage/playlists/';
	$filename = $root.$playlistName;
	
	// Vérifie si un fichier du même nom existe pas déjà 
	$isFileExists = file_exists( $filename );
	
	// Si non, on peut créer ou vérifier l'existence du ficher
	if( !$isFileExists){
		
		if($isCreation === "TRUE"){
			$myfile = fopen($filename, "w");
			echo "<p class=\"alert alert-success\">La playlist <b>$playlistName</b> a été créé. </p>";
		} else {
			echo "<p class=\"alert alert-info\">La nom de playlist <b>$playlistName</b> est disponible. </p>";
		}
		
	} else {
		echo "<p class=\"alert alert-warning\">La playlist <b>$playlistName</b> existe déjà. </p>";
	}
	
} else {
	echo "<p class=\"alert alert-warning\">Le nom de la playlist n'est pas correct. Merci de saisir plus de 2 caractères.</p>";
}

?>