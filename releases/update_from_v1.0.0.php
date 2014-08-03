<?php
/*--------------------------------------------------------------+
 | PHP-Fusion 7 Content Management System             			|
 +--------------------------------------------------------------+
 | Copyright © 2002 - 2013 Nick Jones                 			|
 | http://www.php-fusion.co.uk/                       			|
 +--------------------------------------------------------------+
 | Infusion: ClanCash                                 			|
 | Filename: ccp_admin_panel.php                      			|
 | Author:                                            			|
 | RedDragon(v6) 	    http://www.efc-funclan.de      			|
 | globeFrEak (v7) 		http://www.cwclan.de           			|
 | GUL-Sonic (v7.02)	http://www.germanys-united-legends.de 	|
 +--------------------------------------------------------------+
 | This program is released as free software under the			|
 | Affero GPL license. You can redistribute it and/or			|
 | modify it under the terms of this license which you			|
 | can read by viewing the included agpl.txt or online			|
 | at www.gnu.org/licenses/agpl.html. Removal of this			|
 | copyright header is strictly prohibited without				|
 | written permission from the original author(s).				|
 +--------------------------------------------------------------*/

require_once "../../../maincore.php";


// Includes
require_once INFUSIONS."clancash_panel/infusion_db.php";
//require_once INFUSIONS."clancash_panel/includes/ccp_functions.php";

// Header
	require_once THEMES."templates/header.php";


// Language Files
if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."clancash_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."clancash_panel/locale/English.php";
}
<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: startseite.php
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
require_once "../maincore.php";
require_once THEMES."templates/header.php";
include GSLOCALE."update_from_v1.0.php";

// Check: iAUTH and $aid
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) redirect("index.php");
// Check: Admin Rights
if (!iADMIN) redirect("index.php");

openbox($gsupdate['000']);
	
	echo "<div class='uphead'>\n";
	echo " Text Update ! ";
	echo "</div>\n";

closebox();

// MySQL database functions
function dbquery_gs_update($query) {
	$result = @mysql_query($query);
	if (!$result) {
		//echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

openbox($gsupdate['100'].": v1.0 => v1.1");
/*********** FOLGENDE DATEN WERDEN UPGEDATET *************
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD member_show_names BOOL NOT NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD placeholder_name varchar(15) default 'xxxxx'";
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD paypal BOOL NOT NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD standard_konto int(11) default '1'";
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD version VARCHAR(20) NOT NULL";

$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_email varchar(200) NOT NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_button varchar(200) NOT NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_submit_button varchar(200) NOT NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_cancel_url varchar(200) default NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_thanks_url varchar(200) default NULL";
$mysql[] = "ALTER TABLE ".DB_CCP_KONTEN." ADD paypal_beitrag_checked tinyint(2) NOT NULL default '1'";

$mysql[] = "CREATE TABLE ".DB_CCP_PAYPAL . " (
id int(11) NOT NULL auto_increment,
name varchar(32) default NULL,
subtype varchar(32) default NULL,
value decimal(8,2) NOT NULL default '10.00',
PRIMARY KEY  (id)
) ENGINE=MyISAM;";

$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET member_show_names='0'";
$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET placeholder_name='xxxxx'";
$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET paypal='0'";
$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET version='1.3'";

$mysql[] = "INSERT ".DB_CCP_PAYPAL." (id, name, subtype, value) VALUES ('1','Betrag', '1', '5.00')";
$mysql[] = "INSERT ".DB_CCP_PAYPAL." (id, name, subtype, value) VALUES ('2','Betrag', '2', '10.00')";
$mysql[] = "INSERT ".DB_CCP_PAYPAL." (id, name, subtype, value) VALUES ('3','Betrag', '3', '15.00')";
$mysql[] = "INSERT ".DB_CCP_PAYPAL." (id, name, subtype, value) VALUES ('4','Betrag', '4', '20.00')";

$mysql[] = "UPDATE ".DB_INFUSIONS." SET inf_version='1.3' WHERE inf_folder='clancash_panel'";
						
$mysql[] = "UPDATE " .DB_ADMIN. " SET admin_image='../infusions/clancash_panel/images/admin.gif' WHERE admin_rights='CCP'";
************************** ENDE UPDATE BEREICH */
$errors = 0;
foreach($mysql as $query) {

		if(dbquery_gs_update($query)) {
			$res = "<b>".$gsupdate['307']."</b>";
		} else {
			$errors++;
			$res = "<b>".$gsupdate['308'].":</b>&nbsp;";
			$res .= mysql_error();
		}

	echo "<br /><code>".htmlentities($query)."</code>";

	echo "<br />".$res."<br />";

}

if($errors) {
	echo "<p><b>".$gsupdate['309'].": ".$errors."</b></p>";
} else {
	echo "<p><b>".$gsupdate['310']."</b></p>";
}

echo "<br /><a href='".BASEDIR."gamesystem/admin/gamesystem_settings.php".$aidlink."'>".$gsupdate['311']."</a><br /><br />";

closebox();

// Footer
	require_once THEMES."templates/footer.php";
?>

