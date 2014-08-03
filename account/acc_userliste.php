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
| can read by viewing the included agpl.txt or ondata
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include GSLOCALE."account.php";

$b_per_page = "10";

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) {
    $rowstart = 0;
} else {
    $rowstart = $_GET['rowstart'];
}
$result = dbquery("SELECT * FROM ".DB_ACCOUNT." ORDER BY acc_id ASC LIMIT 0, 100");
$rows = dbrows($result);
$result = dbquery("SELECT * FROM ".DB_ACCOUNT." ORDER BY acc_id ASC LIMIT $rowstart,$b_per_page");

if ($rows > 0) {
	openbox('Userliste');

		echo "<table class='sortable'>";
		echo "  <thead>";
		echo "  <tr>";
		echo "		<th>".$information130."</th>";
		echo "		<th>".$information131."</th>";
		echo "		<th>".$information132."</th>";
		echo "		<th>".$information133."</th>";
		echo "		<th>".$information134."</th>";
		echo "		<th>".$information135."</th>";
		echo "		<th>".$information136."</th>";
		echo "		<th>".$information137."</th>";
		echo "	</tr>";
		echo "  </thead>";

		$sql = "SELECT * FROM ".DB_ACCOUNT." ORDER BY acc_id ASC LIMIT 0, 10";
		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$dataid = $data['acc_id'];
		$datanick = $data['acc_nick'];
		$profilid = $data['acc_id'];
		
		$getaccidlink = get_accidlink($dataid, $datanick);
		$getaccnicklink = get_accnicklink($dataid, $datanick);
		$getproflink = get_proflink($profilid, $datanick);
		
		echo "<tr>\n";
		echo $getaccidlink."\n";
		echo $getproflink."\n";
		echo $getaccnicklink."\n";
		echo "<td>".$data['acc_level']."</td>\n";
		echo "<td>".$data['acc_fordid']."</td>\n";
		echo "<td>".$data['acc_ktonr']."</td>\n";
		echo "<td>".number_format ($data['acc_startgeld'], 0, ',', '.')." NG</td>\n";
		echo "<td>".$data['acc_timestamp']."</td>\n";
		echo "</tr>";
	}
	echo "</table>";
} else {
    echo $keintrag;
}
echo "<div align='center' style='margin-top:5px;margin-bottom:5px;'>
" . makePageNav($rowstart, $b_per_page, $rows, 3, '' )."</div>\n";

	closebox();

	
	
		add_to_head("<script>

			var myTH = document.getElementsByTagName('th')[0];
			sorttable.innerSortFunction.apply(myTH, []);

			var newTableObject = document.getElementById(idOfTheTableIJustAdded)
			sorttable.makeSortable(newTableObject); 

		</script>");

require_once THEMES."templates/footer.php";

?>
