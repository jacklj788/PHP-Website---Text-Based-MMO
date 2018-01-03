<div id="mainSectionHome">

<h2 id="shopHead">The Shop!</h2>

<table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
		<?php 
			if($tName == "Armours") {
				echo "<th>Defence</th>";
			}
			else {
				echo "<th>Power</th>";
			}
		?>
        <th>Sell Price</th>
		<th>Category</th>
		<th>Purchase</th>
      </tr>
    </thead>
    <tbody>
	<?php 
		foreach($items as $value) {
			$name = str_replace(' ','', $value['Name']);
			
			echo "<tr>";
			if($tName == "Armours") {
				echo "<td draggable=\"true\" id=\"", $name, $value['armourID'], "\" ondragstart=\"drag(event)\">", $value['Name'], "</td>";
				echo "<td>", $value['Defence'], "</td>";
				echo "<td>", $value['Sell Price'], "</td>";
				echo "<td>", $value['Category'], "</td>";
				echo "<td><a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/buyItem/", $value['armourID'],'/', $value['Category'], "/", $value['cost'], "\">Buy for ",$value['cost'],"</a></td>";
				echo "</tr>";
			}
			else {
				echo "<td draggable=\"true\" id=\"", $name, $value['weaponID'], "\" ondragstart=\"drag(event)\">", $value['Name'], "</td>";
				echo "<td>", $value['Power'], "</td>";
				echo "<td>", $value['SellPrice'], "</td>";echo "<td>", $value['Category'], "</td>";
				echo "<td><a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/buyItem/", $value['weaponID'],'/', $value['Category'], "/", $value['cost'], "\">Buy for ",$value['cost'],"</a></td>";
				echo "</tr>";
			}
		}
	?>
    </tbody>
</table>

<h2 id="shopHead">Your Inventory</h2>

<table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
		<?php 
			if($tName == "Armours") {
				echo "<th>Defence</th>";
			}
			else {
				echo "<th>Power</th>";
			}
		?>
        <th>Sell Price</th>
		<th>Category</th>
		<th>Sell</th>
      </tr>
    </thead>
    <tbody>
	<?php 
		foreach($playerItems as $value) {
			$name = str_replace(' ','', $value['Name']);
			
			echo "<tr>";
			if($tName == "Armours") {
				echo "<td draggable=\"true\" id=\"", $name, $value['armourID'], "\" ondragstart=\"drag(event)\">", $value['Name'], "</td>";
				echo "<td>", $value['Defence'], "</td>";
				echo "<td>", $value['Sell Price'], "</td>";
				echo "<td>", $value['Category'], "</td>";
				echo "<td><a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/sellItem/", $value['armourID'],'/', $value['Category'], "/", $value['Sell Price'], "\">Sell for ",$value['Sell Price'],"</a></td>";
				echo "</tr>";
			}
			else {
				echo "<td draggable=\"true\" id=\"", $name, $value['weaponID'], "\" ondragstart=\"drag(event)\">", $value['Name'], "</td>";
				echo "<td>", $value['Power'], "</td>";
				echo "<td>", $value['SellPrice'], "</td>";echo "<td>", $value['Category'], "</td>";
				echo "<td><a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/sellItem/", $value['weaponID'],'/', $value['Category'], "/", $value['SellPrice'], "\">Sell for ",$value['SellPrice'],"</a></td>";
				echo "</tr>";
			}
		}
	?>
    </tbody>
</table>

</div>
