<p><?php 
	foreach($searchPlayers as $value) {
		echo "<p class=\"searchedNamesDisplayed\">", $value['Name'],"(", $value['playerID'], ")";
		if ($value['Health'] > 0) {
			echo "<a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/attackPlayer/", $value['playerID'], "\"> attack </a><br/>";
		} else {
			echo "<strong style=\"color: red;\">[Dead]</strong></p>";
		}
		echo "</p>";
	}
?>
</p>