<div id="mainSectionHome">

<div id="thinStripPlayerRanks">
	<table class="table table-hover">
		<tbody>
		<?php 
			foreach($playerRanks as $value) {			
				echo "<tr>";
				echo "<td>", $value['Name'], "(", $value['playerID'], ")</td>";
				echo "<td>", $value['Level'], "</td>";
				echo "<td>", $value['pvpWins'], "</td>";
				echo "</tr>";
			}
		?>
		</tbody>
	</table>
</div>
	
</div>





