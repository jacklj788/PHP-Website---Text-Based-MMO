<div id="mainSectionHome">

	<p id="battleResultsStatus">
<?php 

	echo "You ended up with <strong style=\"color: green;\">", $playerLife, "</strong> life left. ";	
	echo "Your enemy ended up with <strong style=\"color: red;\">", $enemyLife, "</strong> life left.";
?>
	</p>
	
	<p id="battleResultsLife">
<?php 
	if ($playerLife > $enemyLife + 30) {
		echo "You are the superior knight! Everyone knows it.";
	} else if ($playerLife > $enemyLife) {
		echo "Phew! That was a close one. You came out ahead though!";
	} else {
		echo "Embarassing, you will never live this one down. At least you will live.";
		echo "i suggest training more before tackling this foe again";
	}
?>
	</p>
	
<?php 	
	if ($playerLife > $enemyLife) {
		echo "<h1 id=\"h1Winner\">WINNER!!</h1>";
	}
	else {
		echo "<h1 id=\"h1Loser\">LOSER..</h1>";
		echo "<p id=\"goldLost\">You lost 5gold in the process</p>";
		echo "<p id=\"goRevive\">You are now dead. Revive yourself at the heal station for a small cost of gold.</p>";
	}

?>


</div>