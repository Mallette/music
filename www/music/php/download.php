<?php


$name = $_GET['name'];
$url  = $_GET['url'];


// Mode DEBUG
$debug = false;
if($debug) echo "Name : '".$name."'<br/>URL : '".$url."'<br/>";

// Si la valeur n'est pas vide
if( !empty($name) && !empty($url) ){
	
	$ext = strtoupper( pathinfo($name, PATHINFO_EXTENSION) );
	if($debug) echo "Extension : '".$ext."'<br/>";
	
	if( $ext == "MP3"){	
		header('Content-Type: audio/mpeg');
	} else if( $ext == "WMA" ){
		header('Content-Type: x-ms-wma');		
	} else if( $ext == "M4A" ){
		header('Content-Type:audio/mp4');
	} else {
		echo "Oups...";
		return;
	}
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($name) . "\""); 
	readfile("../".$url);
	
} else {
	echo "Oups...";
}

?>