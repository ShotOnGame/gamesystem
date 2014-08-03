<?php

require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."gamesystem/account.php";

//Einbau Functioneninclude BASEDIR."gamesystem/includes/gamesystem_code.php";

openside($account['000']);
// Prüft ob Account vorhanden ist 
include BASEDIR."gamesystem/includes/function/func.account_pruefen.php";
	
	if ($accstatus == "accok") {
		opentable($account['100']);				
			echo "<div>\n";
			echo "<h4>".$account['101']."</h4>";
			echo "<div>\n";
			echo "<p> Du befindest dich im Account-Bereich des GameSystem ! </p>";	
			echo "<br />";
			echo "<span>Hier kannst du dir dein Profil ansehen! </span><br /><a class='button' href='".BASEDIR."gamesystem/account/acc_ansicht.php?acc_id=".$userdata['user_id']."'>".$account['108']."</a>";
			echo "<br />";
			echo "<br />";
			echo "<span>Hier kannst du andere Spieleraccounts ansehen ! </span><br /><a class='button' href='".BASEDIR."gamesystem/account/acc_userliste.php'>".$account['109']."</a>";
			echo "</div>";
			echo "</div>";			
		closetable();	
	}	
	if ($accstatus == "noacc") {			
		opentable($account['110']);
			echo "<div>\n";
			echo "<h4>".$account['111']."</h4>";
			echo "<div>\n";
			echo "<p> Du hast leider noch keinen Account erstellt um am GameSystem teilzunehmen! </p>";
			echo "<a class='button' href='".BASEDIR."gamesystem/account/acc_erstellen.php'>".$account['112']."</a>";
			echo "</div>";
			echo "</div>";			
		closetable();	
	}	
closeside();

require_once THEMES."templates/footer.php";
?>
