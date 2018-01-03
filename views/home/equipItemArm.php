<h5>Currently Equipped</h>

<table class="table table-hover">
	<thead>
	<tr>
		<th>Name</th>
		<th>Power</th>
		<th>Sell Price</th>
		<th>Category</th>
	</tr>
	</thead>
    <tbody>
	<?php 
		foreach($equipped as $value) {
			$name = str_replace(' ','', $value['Name']);
			
			echo "<tr>";
			echo "<td>", $value['Name'], "</td>";
			echo "<td>", $value['Power'], "</td>";
			echo "<td>", $value['SellPrice'], "</td>";
			echo "<td>", $value['Category'], "</td>";
			echo "</tr>";
		}
	?>
    </tbody>
</table>

<table class="table table-hover">
	<thead>
	<tr>
		<th>Name</th>
		<th>Defence</th>
		<th>Sell Price</th>
		<th>Category</th>
	</tr>
	</thead>
    <tbody>
	<?php 
		foreach($equippedArm as $value) {
			$name = str_replace(' ','', $value['Name']);
			
			echo "<tr>";
			echo "<td>", $value['Name'], "</td>";
			echo "<td>", $value['Defence'], "</td>";
			echo "<td>", $value['Sell Price'], "</td>";
			echo "<td>", $value['Category'], "</td>";
			echo "</tr>";
		}
	?>
    </tbody>
</table>