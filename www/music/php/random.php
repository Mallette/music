<?php

// http://rpi.mengelle.fr/music/php/random.php?nbElem=50

// Nombre de chanson à afficher
$nb_elem = strtoupper($_GET['nbElem']);

// Liste des chansons aléatoires
$arrayTracks = [];


// Mode DEBUG
$debug = false;
$debug2 = false;
if($debug) echo "Nombre de chanson à afficher : '".$nb_elem."'<br/>";


// Si la valeur n'est pas vide
if( isset($nb_elem) && !empty($nb_elem) && $nb_elem > 0 ){
	
	// Chemin du fichier d'index
	$path = "/home/pi/music/index.txt";
	if($debug) echo "Chemin de l'index : ".$path."<br/>";
	
	// Ouverture du fichier d'index
	if($debug) echo "Ouverture du fichier<br/>";
	$handle = fopen($path, "r");
	
	if ($handle) {
		
		$pre = "/storage/";
		$cPre = strlen($pre);
		
		// Pour chaque ligne du fichier
		while (($ligne = fgets($handle)) !== false) {
			
			if($debug2) echo "Ligne : ".$ligne."<br/>";
			
			// Supprime le préfix : "/storage/"
			$ligne = substr($ligne, $cPre);
			if($debug2) echo "Suppression prefixe : ".$ligne."<br/>";
			
			// Mise en forme des lignes à afficher
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

			if($debug2) echo "Src : ".$ligne."<br/>";
			
			// Ajoute la ligne au tableau
			$arrayTracks[] = $res;
			
		}
		
		$nb_elem = min($nb_elem, count($arrayTracks));
		
		// Récupère de manière aléatoire les chansons
		$winners = array_rand($arrayTracks, $nb_elem);
		
		//$resultats = "";
		$resultats = [];
		for($i = 0; $i < $nb_elem; $i++){
			$resultats[] = $arrayTracks[$winners[$i]];
		}
		$resultats = ['resultat' => $resultats];
		
		echo json_encode($resultats);
		
		// Fermeture du fichier
		fclose($handle);
		if($debug) echo "Fermeture fichier<br/>";
		
	} else {
		if($debug) echo "Problème d'ouverture de l'index<br/>";
		echo "Problème d'ouverture de l'index.";
	}	
	
} else {
	echo "Oups...";
}

?>