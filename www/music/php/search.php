<?php

// Valeur recherchée tranformée en majuscule
$vr = strtoupper($_GET['search']);

// Longueur du terme recherché
$l = strlen($vr);

// Mode DEBUG
$debug = false;
if($debug) echo "Terme cherche : '".$vr."'<br/>";

// Si la valeur n'est pas vide
if( isset($vr) && !empty($vr) ){
	
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
			
			// Si la ligne lue comporte le terme recherché, on la renvoie
			if( strpos(strtoupper($ligne), $vr) !== FALSE ){
				if($debug) echo "Ligne : ".$ligne."<br/>";
				
				// Supprime le préfix : "/storage/"
				$ligne = substr($ligne, $cPre);
				if($debug) echo "Suppression prefixe : ".$ligne."<br/>";
				
				// Mise en forme des lignes à afficher
				$titreTab = explode("/", $ligne);
				$c = count($titreTab);
				$sep = "<span style=\"color: #ccc; margin:0px 7px;\">/</span>";
				
				$title = $titreTab[$c-1];
				$album = $titreTab[$c-2];
				$artist = $titreTab[$c-3];
				
				$titre = $artist. $sep .$album. $sep .$title;
				
				// Cherche la position du terme recherché dans le titre
				$pos = strpos(strtoupper($titre), $vr);
				if($debug) echo "l=$l et pos=$pos<br/>";
				if( isset($pos)  && !empty($pos) ){
					$titre = substr($titre, 0, $pos). "<span style=\"color: #c50;\">".substr($titre, $pos, $l)."</span>".substr($titre, ($pos+$l), strlen($titre));
				}
				
				$res = "<li class=\"puce\"><p class=\"fileFound c_menu_file\" data-src=\"".htmlentities($ligne). "\""
												." data-art=\"".htmlentities($artist)."\""
												." data-alb=\"".htmlentities($album). "\""
												." data-tit=\"".htmlentities($title). "\">$titre</p></li>";
												
				if($debug) echo "Src : ".$ligne."<br/>";
				
				if( !$debug) echo $res;
			}
		}
		
		if( !isset($res) || empty($res) ){
			echo "<li>Aucun résultat ne contient '$vr'</li>";
		}
		
		// Fermeture du fichier
		fclose($handle);
		if($debug) echo "Fermeture fichier<br/>";
		
	} else {
		if($debug) echo "Problème d'ouverture de l'index<br/>";
		echo "Problème d'ouverture de l'index.";
	}	
	
} else {
	echo "<table><tr><td><img class=\"img_32 margin_right_10\" src=\"img/error.png\"></td>"
			."<td><span class=\"bold\">Oups...</span><br/><span class=\"small\">Merci de renseigner un autre mot clef.</td></tr></table>";
}

?>