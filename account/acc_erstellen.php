<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: account_erstellen.php
| Author: Julian Dröge
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include LOCALE.LOCALESET."gamesystem/account.php";
//Einbau Functionen
include BASEDIR."gamesystem/includes/gamesystem_code.php";

if (iMEMBER) {
  $msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'");

  // Forderungsdaten laden
	include "includes/inc.settings.php";
	
	openside('Account erstellen'); 

  
  
  if(isset($_POST['submit']) AND $_POST['submit']=='Abschicken'){
	  // Fehlerarray anlegen
	  $error = array();
	  // Pr fen, ob alle Formularfelder vorhanden sind
	  if(!isset($_POST['acc_id'],
				$_POST['acc_user'],
				$_POST['acc_nick'],
				$_POST['acc_level'],
				$_POST['acc_fordid'],
				$_POST['acc_ktonr'],
				$_POST['acc_freigabe'],
				$_POST['acc_sperre'],
				$_POST['acc_startgeld'],
				$_POST['acc_status'],
				$_POST['acc_timestamp'],
				$_POST['gs_regelwerk'],
				$_POST['gs_bestimmung']))
		  // Ein Element im Fehlerarray hinzuf gen
		  $errors = "Bitte benutzen Sie das Formular aus dem Forderungsbereich";
	  
	  else{

	  $user_names = array();
	  $user_ids = array();
		  
	  $sql = "SELECT user_name, user_id FROM ".DB_USERS."";
	  $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		  while($row = mysql_fetch_assoc($result)){
				   $user_names[] = $row['user_name'];
				   $user_ids[] = $row['user_id'];
		  }
		  
	  $sql = "SELECT acc_id, acc_fordid, acc_ktonr FROM ".DB_ACCOUNT."";
	  $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			  while($row = mysql_fetch_assoc($result)) {
					   $acc_nr[] = $row['acc_id'];
					   $acc_spielerid[] = $row['acc_fordid'];
					   $acc_konto[] = $row['acc_ktonr'];
		  }
		  
		  // Prüft, ob ein ford_name eingegeben wurde
	  if(trim($_POST['acc_id'])=='')
			  $error[]= $locale['410'];
		  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['acc_user'])=='')
			  $error[]= $locale['411'];
		  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['acc_nick'])=='')
			  $error[]= $locale['412'];
		  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['acc_ktonr'])=='')
			  $error[]= $locale['413'];
		  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['acc_nick'])=='')
			  $error[]= $locale['414'];
	  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['gs_regelwerk'])=='')
			  $error[]= $locale['416'];
	  // Prüft, ob eine ford_gameid eingegeben wurde
	  if(trim($_POST['gs_verpflichtung'])=='')
			  $error[]= $locale['417'];
	  elseif(in_array(trim($_POST['acc_id']), $acc_nr))
			  $error[]= $locale['415a']."(".$_POST['acc_id'].") ".$locale['415b']."";
	  
	  }
		  
		// Pr ft, ob Fehler aufgetreten sind
	    if(count($error)){
		   echo $locale['420']."<br>\n";
			echo "<br>\n";
		   foreach($error as $errors);
			   echo $errors."<br>\n";
		   echo "<br>\n";
			 echo $locale['421']."<a href=\"".$_SERVER['PHP_SELF']."\">".$locale['422']."</a>\n";
			 
		}
	
	
	// include INSERT DATEIN
	$usernick = $_POST['acc_nick'];
	$userfordid = $_POST['acc_fordid'];
	$userktonr = $_POST['acc_ktonr'];
	$userstartgeld = $_POST['acc_startgeld'];

	include "includes/inc.account.php";
	include "includes/inc.accountstats.php";
	
	include "includes/inc.konto.php";
	include "includes/inc.kontobuchung.php";
	include "includes/inc.kontostats.php";


	include "includes/inc.kassekonten.php";
	include "includes/inc.kassekasse.php";
	include "includes/inc.kassebuchungen.php";

	include "includes/inc.updateuser.php";

	include "includes/inc.countstatus.php";

	include "includes/inc.erfolgreich.php";

	include "includes/inc.helfer.php";
    } else {
	
	include"includes/inc.settings.php";	
		
	opentable('Account erstellen Formular');

			
//		$genktonr = mt_rand(800000,899999);
	//	$genfordid = mt_rand(600000,699999);
		//$gengameid = mt_rand(100000,199999);
	//	$genvorgangid = mt_rand(200000,299999);
		//$genzufall = mt_rand(500000,599999);

	  echo "<div>";
	  echo "<form ".
		   " name=\"accounterstellen\" ".
		   " action=\"".$_SERVER['PHP_SELF']."\" ".
		   " method=\"post\" ".
		   " accept-charset=\"ISO-8859-1\">\n";
	  echo $locale['430']."\n";
	  echo "<div>\n";	
	  echo "<table>\n";
	  echo "<tr>\n";
	  echo "<td><span\" ".
		   " title=\"".$locale['432t']."\">\n".
		   $locale['432']."\n".
		   "</span></td>\n";
	  echo "<td><label>".$userdata['user_name']."</label></td>\n";
	  echo "<input type=\"hidden\" name=\"acc_user\" value=\"".$userdata['user_name']."\" maxlength=\"45\">\n";
	  echo "</tr>\n";
	  echo "<tr>\n";
	  echo "<td><span\" ".
		   " title=\"".$locale['431t']."\">\n".
		   $locale['431']."\n".
		   "</span></td>\n";
	  echo "<td><label>".$userdata['user_id']."</label></td>\n";
	  echo "<input type=\"hidden\" name=\"acc_id\" value=\"".$userdata['user_id']."\" maxlength=\"45\">\n";
	  echo "</tr>\n";
	  echo "<tr>\n";
	  echo "<td><span\" ";
		echo   " title=\"".$locale['433t']."\">\n";
		echo $locale['433']."\n";
		echo   "</span></td>\n";
	  echo "<td><input type=\"text\" name=\"acc_nick\" placeholder=\"Dein Nickname..\" maxlength=\"32\"></td>\n";
	  echo "</tr>";
	  echo "<tr>\n";
	  echo "<td><span\" ".
		   " title=\"".$locale['434t']."\">\n".
		   $locale['434']."\n".
		   "</span></td>\n";
	  echo "<td><input type=\"text\" name=\"acc_level\" placeholder=\"Dein Level ..\" maxlength=\"32\"></label></td>\n";
	  echo "</tr>";
	  echo "<tr>\n";
	  echo "<td><span\" ".
		   " title=\"".$locale['435t']."\">\n".
		   $locale['435']."\n".
		   "</span></td>\n";
	  echo "<td><label>Autowert FordID ".$genfordid." | Userdata: ".$userdata['user_fordid']."</label></td>\n";
	  echo "<input type=\"hidden\" name=\"acc_fordid\" value=\"".$genfordid."\" maxlength=\"6\">\n";
	  echo "</tr>\n";
	  echo "<tr>\n";
	  echo "<td><span\" ".
		   " title=\"".$locale['436t']."\">\n".
		   $locale['436']."\n".
		   "</span></td>\n";
	  echo "<td><label>Autowert KontoNr  ".$genktonr." | Userdata: ".$userdata['user_ktonr']."</label></td>\n";
	  echo "<input type=\"hidden\" name=\"acc_ktonr\" value=\"".$genktonr."\" maxlength=\"6\">\n";
	  echo "</tr>\n";
	  echo "<tr>";
	  echo "<td><span\">\n".
		   $locale['437']."\n".
		   "</span></td>\n";
	  echo "<td><select name=\"acc_startgeld\">";
	  echo         "<option value=\"\">Startgeld w&auml;hlen</option>";
	  echo         "<option value=\"1000000\">01 Million</option>";
	  echo         "<option value=\"2000000\">02 Million</option>";
	  echo         "<option value=\"3000000\">03 Million</option>";
	  echo         "<option value=\"4000000\">04 Million</option>";
	  echo         "<option value=\"5000000\">05 Million</option>";
	  echo         "<option value=\"1000000\">10 Million</option>";
	  echo         "<option value=\"15000000\">15 Million</option>";
	  echo         "<option value=\"20000000\">20 Million</option>";
	  echo         "<option value=\"25000000\">25 Million</option>";
	  echo         "<option value=\"30000000\">30 Million</option>";
	  echo         "<option value=\"35000000\">35 Million</option>";
	  echo         "<option value=\"50000000\">50 Million</option>";
	  echo         "<option value=\"100000000\">100 Million</option>";
	  echo "</select></td>";
	  echo "</tr>";

	 
	  
		  echo "<input type=\"hidden\" name=\"acc_freigabe\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"acc_sperre\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"acc_status\" value=\"Wartend\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"acc_timestamp\" value=\"".$zeitstempel."\" maxlength=\"20\">\n";
		  
		  echo "<input type=\"hidden\" name=\"message_to\" value=\"\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"message_from\" value=\"".$userdata['user_id']."\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"message_subject\" value=\"\" maxlength=\"100\">\n";
		  echo "<input type=\"hidden\" name=\"message_message\" value=\"\" maxlength=\"255\">\n";
		  echo "<input type=\"hidden\" name=\"message_smileys\" value=\"y\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"message_read\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"message_datestamp\" value=\"".time()."\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"message_folder\" value=\"0\" maxlength=\"20\">\n";
  
		  echo "<input type=\"hidden\" name=\"kto_ktonr\" value=\"".$genktonr."\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_stand\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_standalt\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_betrag\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_art\" value=\"Startgeld\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_zweck\" value=\"Startgeld\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_ankonto\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_abkonto\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_status\" value=\"Offen\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kto_timestamp\" value=\"".time()."\" maxlength=\"20\">\n";

		  echo "<input type=\"hidden\" name=\"rang_ktostand\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_ktostandalt\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_punkte\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_tore\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_gegentore\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_sieg\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_unentschieden\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"rang_niederlage\" value=\"0\" maxlength=\"20\">\n";
	  
	  echo "<input type=\"hidden\" name=\"stats_id\" value=\"".$userdata['user_id']."\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_nick\" value=\"\" maxlength=\"50\">\n";
	  echo "<input type=\"hidden\" name=\"stats_fordid\" value=\"".$genfordid."\" maxlength=\"50\">\n";
	  echo "<input type=\"hidden\" name=\"stats_bemerkung\" value=\"keine\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_eingford\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_ausgford\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_erstellt\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_abgelaufen\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_abgebrochen\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_abgelehnt\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_beendet\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_archiv\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_gesamt\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_spiele\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_sieg\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_remis\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_lose\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_punkte\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_beste\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_letzte\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_schlagplus\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_schlagminus\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_timestamp\" value=\"".time()."\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_ktonr\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_startgeld\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_einnahmen\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_ausgaben\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_eingezahlt\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_ausgezahlt\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_einsatz\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_gebuehr\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_sonstiges\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_guthabenmax\" value=\"0\" maxlength=\"20\">\n";
	  echo "<input type=\"hidden\" name=\"stats_guthabenmin\" value=\"0\" maxlength=\"20\">\n";

		  echo "<input type=\"hidden\" name=\"kas_id\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_stand\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_standalt\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_betrag\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_art\" value=\"Startgeld\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_zweck\" value=\"Startgeld\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_ankonto\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_abkonto\" value=\"\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_timestamp\" value=\"".$zeitstempel."\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_gameid\" value=\"0\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_status\" value=\"Offen\" maxlength=\"20\">\n";
		  echo "<input type=\"hidden\" name=\"kas_bemerkung\" value=\"keine\" maxlength=\"20\">\n";

		  echo "<input type=\"hidden\" name=\"rang_id\" value=\"".$userdata['user_id']."\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_nick\" value=\"".$userdata['user_usernickname']."\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_fordid\" value=\"".$genfordid."\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_startkapital\" value=\"\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_bemerkung\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_betrag\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_guthaben\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_einsatz\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_gewinn\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_ktoalt\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_ktoneu\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_differenz\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_tendenz\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_eingford\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_ausgford\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_spiele\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_sieg\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_remis\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_lose\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_beste\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_letzte\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_schlagplus\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_schlagminus\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_verwarnung\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_strafe\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_bann\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_admin\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_admintext\" value=\"0\" maxlength=\"45\">\n";
		  echo "<input type=\"hidden\" name=\"rang_datum\" value=\"".$zeitstempel."\" maxlength=\"45\">\n";

  
			echo "<script type='text/javascript'>\n";
			echo "/* <![CDATA[ */\n";
			echo "function ConfirmRegelwerk() {\n";
			echo "return confirm('".$locale['438m']."');\n";
			echo "}\n";
			echo "function ConfirmVerpflichtung() {\n";
			echo "return confirm('".$locale['439m']."');\n";
			echo "}\n";
			echo "/* ]]>*/\n";
			echo "</script>\n";

		  echo "<tr>\n";
		  echo "<td><span\" ".
			   " title=\"".$locale['438t']."\">\n".
			   $locale['438']."\n".
			   "</span></td>\n";
		  echo "<td><input type=\"checkbox\" name=\"gs_regelwerk\" onclick=\"return ConfirmRegelwerk();\" value=\"akzeptiert\"> | <label>".$locale['438l']."</label></td>\n";
		  echo "</tr>\n";
		  echo "<tr>\n";
		  echo "<td><span\" ".
			   " title=\"".$locale['439t']."\">\n".
			   $locale['439']."\n".
			   "</span></td>\n";
		  echo "<td><input type=\"checkbox\" name=\"gs_bestimmungen\" onclick=\"return ConfirmVerpflichtung();\" value=\"akzeptiert\" option=\"unchecked\"> | <label>".$locale['439l']."</label></td>\n";
		  echo "</tr>\n";
		  echo "<tr>";
		  echo "</table>";
		  echo "</div>";
		  echo "<br>\n";
		  echo "<div class='formbutton'>";
		  echo "<input type=\"submit\" name=\"submit\" value=\"Abschicken\">   |  ";
		  echo "<input type=\"reset\" name=\"reset\" value=\"Zur&uuml;cksetzen\">";
		  echo "</div>";
		  echo "</form>\n";

}


closetable();

}

require_once THEMES."templates/footer.php";
?>
