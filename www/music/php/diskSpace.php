<?php

/**************************************
 * Récupère l'espace disque du DDE
 **************************************/

// On enlève le début de chaîne "Use%" inutile (le résultat de la commande vaut "Use% 73%")
$diskSpace = substr(shell_exec("df -h '/storage/dde_musique' | awk '{ print $5}'"), 5);

// On enlève la début de chaîne "Use%" inutile
echo '<span title="Espace disque utilisé : '.$diskSpace.'">'.$diskSpace.'</span>';

?>