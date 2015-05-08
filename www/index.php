<?php

$debbug = false;

// On teste si j'ai soumis le formulaire de connexion
if ( isset($_POST['btn']) && $_POST['btn'] == 'Connexion' ) {
	
	if ((isset($_POST['inputEmail']) && !empty($_POST['inputEmail'])) 
			&& (isset($_POST['inputPassword']) && !empty($_POST['inputPassword']))) {
		
		$login = $_POST['inputEmail'];
		$mdp = openssl_digest($_POST['inputPassword'], 'sha512');
		
		if($debbug){
			echo "Données du formulaire remplies.<br/>";
		}
		
		if( $login == 'music' && $mdp == '...................................................................................................' ){
			$ok = true;
		}
		
		if( isset($ok) && !empty($ok) && $ok ) {
			if($debbug){
				echo "C'est OK, on redirige.<br/>";
			} else {
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['mdp'] = $mdp;
				header('Location: music/welcome.php');
				exit();
			}
			
		} else {
			if($debbug){
				echo "Compte inconnu.<br/>";
			} else {
				header('Location: index.php');
				exit();
			}
		}
	} else {
		if($debbug){
			echo "Formulaire vide.<br/>";
		} else {
			header('Location: index.php');
			exit();
		}
	}
} else {
	if($debbug){
		echo "Formulaire non soumis.<br/>";
	}
}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connexion Raspberry Pi</title>

    <!-- Bootstrap core CSS -->
	<link href="music/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="music/css/signin.css" rel="stylesheet">
	
	<link rel="icon" type="image/png" href="music/img/favicon.png" />

	<!-- SPECIFIC -->
	<link href="music/css/wait.css" rel="stylesheet">
	
  </head>

  <body>
	<!-- Please wait -->
	<div id="wait" class="notLoading"><div id="img"></div></div>

    <div class="container">

      <form class="form-signin" role="form" action="index.php" method="post">
        <h2 class="form-signin-heading">Connexion au RPI</h2>
        <label class="sr-only">Login</label>
        <input name="inputEmail" class="form-control" placeholder="Login" >
        <label class="sr-only">Mot de passe</label>
        <input type="password" name="inputPassword" class="form-control" placeholder="Mot de passe" >
        <button id="btn" class="btn btn-lg btn-primary btn-block" type="submit" name="btn" value="Connexion">Valider</button>
      </form>

    </div>
	
  </body>
</html>
