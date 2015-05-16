<?php

session_start();

// On teste si je me suis bien connecté
if (!empty($_SESSION['login']) && !empty($_SESSION['mdp'])) {

	$msgWelcome = strtoupper($_SESSION['login']);

} else {
	header('Location: ../index.php');
	exit();
}



?>

<!DOCTYPE html>

<html lang="en" ng-app="RDash">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
	
		<title>DDE Musique</title>
		<link rel="icon" type="image/png" href="img/favicon.png" />
		
		<!-- JPLAYER -->
		<link href="jPlayer/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jPlayer/js/jquery.min.js"></script>
		<script type="text/javascript" src="jPlayer/js/jquery.jplayer.min.js"></script>
		<script type="text/javascript" src="jPlayer/js/jplayer.playlist.min.js"></script>
		
		<!-- Bootstrap core CSS + JS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		
		<!-- Jquery File Tree -->
		<!--<script src="js/jquery.js" type="text/javascript"></script>-->
		<script src="js/jquery.easing.js" type="text/javascript"></script>
		<script src="js/jqueryFileTree.js" type="text/javascript"></script>
		<link href="css/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
		
		<!-- Context menu -->
		<script src="menu/jquery.contextMenu.js" type="text/javascript"></script>
		<link href="menu/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
		
		<!-- MICRO -->
		<!-- <script src="js/volume-meter.js"></script> -->
		<!-- <script src="js/micro.js"></script> -->
		
		<!-- SPECIFIC -->
		<link href="css/wait.css" rel="stylesheet">
		<link href="css/welcome.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>

	</head>
	
	
	<body>
		
		<div id="lecteur">
			<h2 id="titre_lecteur">Lecteur <span class="toggle"></span></h2>
			<div id="lecteur_jplayer">
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>
				<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
					<div class="jp-type-playlist">
						<div class="jp-gui jp-interface">
							<div class="jp-controls">
								<button class="jp-previous" role="button" tabindex="0">previous</button>
								<button class="jp-play" role="button" tabindex="0">play</button>
								<button class="jp-next" role="button" tabindex="0">next</button>
								<button class="jp-stop" role="button" tabindex="0">stop</button>
							</div>
							<div class="jp-progress">
								<div class="jp-seek-bar">
									<div class="jp-play-bar"></div>
								</div>
							</div>
							<div class="jp-volume-controls">
								<button class="jp-mute" role="button" tabindex="0">mute</button>
								<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
								<div class="jp-volume-bar">
									<div class="jp-volume-bar-value"></div>
								</div>
							</div>
							<div class="jp-time-holder">
								<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
								<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
							</div>
							<div class="jp-toggles">
								<button class="jp-repeat" role="button" tabindex="0">repeat</button>
								<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
							</div>
						</div>
						<div class="jp-playlist">
							<ul>
								<li>&nbsp;</li>
							</ul>
						</div>
						<div class="jp-no-solution">
							<span>Mise à jour requise</span>
							Pour lire ce fichier, merci de mettre à jour votre navigateur ou votre <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="wrapper">

			<h2 class="grey">Hello <?php echo $msgWelcome; ?> !
				<span class="right">
					<a href="#" id="index" class="button_action">
						<img src="img/index.png" class="img_action" title="Indexe la bibliothèque"/>
					</a>
					<a href="http://rpi.mengelle.fr/music/dde_musique/Musique" target="_blank" class="button_action">
						<img src="img/dir.png" class="img_action" title="DDE musique sans interface"/>
					</a>
				</span>
			</h2>
			<div class="content">
				
				<!-- <canvas id="meter" width="500" height="20"></canvas> -->
				
				<div class="arbre">
					<div style="margin-bottom: 10px">
						<a href="#" id="random" class="button_action" >
							<img src="img/random.png" class="img_action" title="Lecture aléatoire de 30 chansons"/>
						</a>
						<a href="#" id="addResultToPlaylist" class="button_action">
							<img id="on" src="img/addResultToPlaylist_on.png" class="img_action diplay_none" title="Ajoute la sélection à la playlist"/>
							<img id="off" src="img/addResultToPlaylist_off.png" class="img_action" title="Lancer la recherche pour ajouter les résultats à la playlist"/>
						</a>
						<a href="#" id="deleteAllPlaylist" class="button_action">
							<img src="img/deletePlaylist.png" class="img_action" title="Vide la playlist"/>
						</a>
					</div>
					<div>
						<input type="text" id="search" placeholder="Recherche" value=""
							   style="box-shadow:inset 0 0 4px #eee; width:150px; padding:4px 12px; border-radius:4px; border:1px solid silver; vertical-align: middle;">
						<div id="searchIcon" class="notInProgress"></div>
					</div>
					
					<div id="fileTree" class="fileTree"></div>
					<div id="resultSearch"></div>
				</div>
			</div>
			
		</div>
	
		<!-- POP-UP -->
		<div class="modal fade" id="indexPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">×</button>
						<h3>Indexation de la médiathèque</h3>
					</div>
					<div class="modal-body">
						<pre><div id="detailsTraitementIndexation"></div></pre>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-default" data-dismiss="modal">OK</a>
					</div>
				</div>
			</div>
		</div>
	
		<!-- POP-UP -->
		<div class="modal fade" id="micro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">×</button>
						<h3>Désactivation du micro</h3>
					</div>
					<div class="modal-body">
						<p>Le micro n'est pas activé.</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-default" data-dismiss="modal">OK</a>
					</div>
				</div>
			</div>
		</div>	
		
		
		
<script type="text/javascript">
//<![CDATA[
$(document).ready( function() {

    var hDoc;
    var speed = 400;
    var $lecteur = $('#lecteur');

	// Adapte la hauteur du bandeau lecteur
	function drawBandeauLecteur(hDoc){
        $lecteur.css("height", hDoc);
	}
	
	// Ajuste la hauteur de la playlist
	function ajusteHauteurPlaylist(){
		var hPlayer = $(".jp-gui").outerHeight(true);
		var hTitle = $("#titre_lecteur").outerHeight(true);
		$(".jp-playlist").css("height", (hDoc - hPlayer - hTitle - 2));
	}
	ajusteHauteurPlaylist();

    // On resize
	$( window ).on('resize', function() {
		hDoc = $(document).height();
		drawBandeauLecteur(hDoc);
		ajusteHauteurPlaylist();
	});

    // Initialize bandeau du lecteur
    $( window).trigger('resize');

    $lecteur.css("marginLeft", "-375px" );
	$('.wrapper').css("marginLeft", "45px" );
	$('#lecteur_jplayer').hide();
	$('.toggle').html(">");
	// Toggle lecteur
	$('#titre_lecteur').on('click', function(){
		var isOpen = ($lecteur.css('margin-left') == '0px');
		if( isOpen ){
			$('#lecteur').animate({ marginLeft: "-375px" }, speed );
			$('.wrapper').animate({ marginLeft: "45px" }, speed );
			$('#lecteur_jplayer').fadeToggle(speed, "linear");
			$('.toggle').html(">");
		} else {
			$('#lecteur').animate({ marginLeft: "0px" }, speed );
			$('.wrapper').animate({ marginLeft: "420px" }, speed );
			$('#lecteur_jplayer').fadeToggle(speed, "linear");
			$('.toggle').html("<");
		}
	});

	var myPlaylist = new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, myPlaylist
	,{
		playlistOptions: {
			enableRemoveControls: true
		},
		supplied: "oga, mp3, wma, m4a",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});
	
	function addToPlaylist(titleFile, moreInfo, urlFile){
		var wasEmpty = false;
		if(myPlaylist.playlist.length == 0){
			wasEmpty = true;
		}
		
		myPlaylist.add({
			title: titleFile,
			artist: moreInfo,
			free: true,
			mp3: urlFile
		});
		// Si la playlist était vide, on lit le fichier à ajouter
		if(wasEmpty){
			$("#jquery_jplayer_1").jPlayer("play");
		}
	}
	
	// RANDOM
	$('#random').on("click", function(){
		var nbElem = 30;
		$.ajax({
			type: "GET",
			url: "php/random.php",
			data: "nbElem=" + nbElem,
			datatype: "json",
			beforeSend: function() { 
				$("#searchIcon").removeClass("notInProgress").addClass("progressing");
			},
			success: function(r){
				var resultats = JSON.parse(r).resultat;
				
				for(i = 0; i < resultats.length; i++ ){
					var track = resultats[i].track;
					
					var src = track[0].src;
					var title = track[3].tit;
					var moreInfo = track[1].art + " - " + track[2].alb;
					
					src = src.trim();
					addToPlaylist(title, moreInfo, encodeURI(src));
				}
			},
			complete: function(){
				// On enlève le spinner
				$("#searchIcon").removeClass("progressing").addClass("notInProgress");
			}
		});
	});

	// INDEXATION
	$('#index').on("click", function(){
		$.ajax({
			type: "GET",
			url: "php/indexe.php",
			datatype: "json",
			beforeSend: function() {
				// On ajoute le spinner
				$("#searchIcon").removeClass("notInProgress").addClass("progressing");
				// On bloque la recherche
				$("#search").prop('disabled', true);
			},
			success: function(r){
				// Ouvre POP UP d'information
				$("#indexPopup").modal('show');
				// Ajoute le message dans la popup
				$("#detailsTraitementIndexation").append(r);			
			},
			complete: function(){
				// On enlève le spinner
				$("#searchIcon").removeClass("progressing").addClass("notInProgress");
				// On active la recherche
				$("#search").prop('disabled', false);
			}
		});
	});
	
	// VIDE LA PLAYLIST
	$('#deleteAllPlaylist').on("click", function(){
		myPlaylist.remove();
	});
	
	// Récupère les informations et ajoute à la playlist
	function getInfoAndAddToPlaylist(file){
		var titleFileTab = file.split("/");
		var titleFile = titleFileTab[titleFileTab.length-1];
		if( titleFileTab.length >= 3){
			var info3 = titleFileTab[titleFileTab.length-3] + " - ";
			var info2 = titleFileTab[titleFileTab.length-2];
		} else if (titleFileTab.length == 2) {
			var info3 = "";
			var info2 = titleFileTab[titleFileTab.length-2];
		} else {
			var info3 = "Artiste inconnu -";
			var info2 = "Album inconnu";
		}
		var moreInfo = info3 + info2;
		addToPlaylist(titleFile, moreInfo, encodeURI(file));
	}
	
	// ARBORESCENCE
	$('#fileTree').fileTree({
			root: '/storage/dde_musique/',
			script: 'php/jqueryFileTree.php'
		}, 
		function(file) {
			getInfoAndAddToPlaylist(file);
		}
	);

	// RECHERCHE
	$('#search').keyup(function(e){
		var v = $('#search').val();
		if(v==""){
			$("#fileTree").show();
			$("#resultSearch").hide().html();
			$("#searchIcon").removeClass("progressing").addClass("notInProgress");
			// Boutons d'ajout des résultats de recherche à la playlist
			var isHidden = $("#on").hasClass("diplay_none");
			if(isHidden === false){
				$("#on").addClass("diplay_none");
				$("#off").removeClass("diplay_none");
			}
		}
		if (e.which == 13 && v!=="") {
			$.ajax({
				type: "GET",
				url: "php/search.php",
				data: "search="+v,
				datatype: "json",
				beforeSend: function() { 
					$("#searchIcon").removeClass("notInProgress").addClass("progressing");
					$("#fileTree").hide();
					$("#resultSearch").show();
					// Supprime les anciennes recherches
					$('.fileFound').remove();
				},
				success: function(r){
					$("#resultSearch").html("<ul>"+r+"</u>");
					$('.fileFound').on("click", function(){
						var title = $(this).attr("data-tit");
						var moreInfo = $(this).attr("data-art") + " - " + $(this).attr("data-alb");
						var src = $(this).attr("data-src");
						src = src.trim();
						addToPlaylist(title, moreInfo, encodeURI(src));
					});					
				},
				error: function(e){
					$("#resultSearch").html(e);
				},
				complete: function(){
					// On enlève le spinner
					$("#searchIcon").removeClass("progressing").addClass("notInProgress");
					
					// Affiche le bouton d'ajout à la playlist s'il y a des résultats !!!
					var hasResults = $("#resultSearch").html().length > 100;
					if(hasResults === true){
						$("#on").removeClass("diplay_none");
						$("#off").addClass("diplay_none");
					} else {
						$("#off").addClass("diplay_none");
						$("#on").removeClass("diplay_none");
					}

				}
			});
		}
	});
	
	// AJOUTE RESULTATS A LA PLAYLIST
	// id="on" -> img : addResultToPlaylist_on.png 
	$('#on').on("click", function(){
		var res = $('.fileFound');
		$.each(res, function(){
			var title = $(this).attr("data-tit");
			var moreInfo = $(this).attr("data-art") + " - " + $(this).attr("data-alb");
			var src = $(this).attr("data-src");
			src = src.trim();
			addToPlaylist(title, moreInfo, encodeURI(src));
		});
	});
	
	// MENU CONTEXTUEL sur fichier
	$.contextMenu({
        selector: '.c_menu_file', 
        items: {
            "download": {	
				name: "Télécharger fichier", 
				icon: "dl", 
				callback: function(key, options) {
					// var m = "clicked: " + key + ". Fonction non disponible pour le moment. ";
					// window.console && console.log(m) || alert(m);
					if( $(this).hasClass("fileFound") ){
						var url = $(this).attr("data-src").trim();
						var name = $(this).attr("data-tit").trim();
					} else {
						var a = $(this).children()[0];
						var url = $(a).attr("rel");
						var name = $(a).html();
					}
					window.location="php/download.php?name="+name+"&url="+url;
				}
			},
			"openInNewTab": {	
				name: "Lire le fichier dans un nouvel onglet", 
				icon: "music", 
				callback: function(e){
					if( $(this).hasClass("fileFound") ){
						var url = $(this).attr("data-src").trim();
						var name = $(this).attr("data-tit").trim();
					} else {
						var a = $(this).children()[0];
						var url = $(a).attr("rel");
						var name = $(a).html();
					}
					var win = window.open(url, '_blank');
					win.focus();
				}
			}
        },
		events: {
			show: function(opt){ 
				this.addClass('currently-showing-menu');
			},
			hide: function(opt){ 
				this.removeClass('currently-showing-menu');
			}
		}
    });
	
	// TODO ne marche pas si dossier non déplié !!!

	// MENU CONTEXTUEL sur dossier
/*
	$.contextMenu({
        selector: '.c_menu_dir', 
        items: {
            "playAlbum": {	
				name: "Lire l'album", 
				icon: "add", 
				callback: function(key, options) {
					$(this).click();
					var array = $(this).first().find('ul').find('.c_menu_file').first();
					if( array.length > 0 ){
						for( i=0; i<array.length; i++ ){
							var track = array[i];
							var a = $(track).children()[0];
							var url = $(a).attr("rel");
							getInfoAndAddToPlaylist(url);
						}
					}
				}
			}
        },
		events: {
			show: function(opt){
				this.addClass('currently-showing-menu');
			},
			hide: function(opt){ 
				this.removeClass('currently-showing-menu');
			}
		}
    });	
*/

	
});
//]]>
</script>

	</body>
	
</html>