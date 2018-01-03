<div id="mainSectionHome">
	<div id="homeStatPanel">
		<h5 style="display: inline-block;">
			<?php echo $player['Name'];?> 
			<h6 style="display: inline-block; color: blue;">
				<abbr title="This is your level. Earn Experience and level up to get better rewards." style="text-decoration: none;">
					[<?php echo $player['Level'];?>]
				</abbr>
				<?php 
					if($player['vip']) { 
						echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/vipCrownSmall\" />"; 
					}
				?>
			</h6>
		</h5>
		<div id="expBar">
			<div class="progress">
				<div class="progress-bar bg-success" style="width:<?php echo $player['Experience'];?>%">
					<?php echo $player['Experience']; ?>
				</div>
				<div class="progress-bar bg-dark" style="width:<?php echo 100 - $player['Experience'];?>%">
				</div>
			</div>
		</div>
		<h6>Health:</h6>
		<div id="progressBars">
			<div class="progress">
				<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:<?php echo $player['Health'];?>%">
					<?php echo $player['Health']; ?>
				</div>
				<div class="progress-bar bg-dark" style="width:<?php echo 100 - $player['Health'];?>%">
				</div>
			</div>
		</div>
		<h6 style="display: inline-block;">Energy:</h6>
		<div id="progressBars">
			<div class="progress">
				<div class="progress-bar progress-bar-striped progress-bar-animated" style="width:<?php echo $player['Energy'];?>%">
					<?php echo $player['Energy']; ?>
				</div>
				<?php 
					if ($player['vip']) {
						echo "<div class=\"progress-bar bg-dark\" style=\"width: ", 200 -  $player['Energy'], "%\"></div>";
					} else {
						echo "<div class=\"progress-bar bg-dark\" style=\"width: ", 100 -  $player['Energy'], "%\"></div>";
					}
				?>
			</div>
		</div>
		<br/>
		<h6 style="display: inline-block">Gold:&nbsp;</h6>
		<p class="pStats"><?php echo $player['Money']; ?> [<abbr title="Used to purchase new weapons and armour.">?</abbr>]</p>
		<br/>
		<!-- &nbsp; is a white space. Just putting ' ' doesn't work correctly. -->
		<h6 style="display: inline-block">Strength:&nbsp;</h6>
		<p class="pStats"><?php echo $player['Strength']; ?> [<abbr title="Determines how much damage your physichal attacks do.">?</abbr>]</p>
		<br/>
		<h6 style="display: inline-block">Agility:&nbsp;</h6>
		<p class="pStats"><?php echo $player['Agility']; ?> [<abbr title="Determines your chance of hit / being hit by an attack.">?</abbr>]</p>
		<br/>
		<h6 style="display: inline-block">Defense:&nbsp;</h6>
		<p class="pStats"><?php echo $player['Defense']; ?> [<abbr title="Determines how much damage you block.">?</abbr>]</p>
		<br/>
		
		<div id="winRatesPVP">
			<h6 style="display: inline-block">PVP Wins:&nbsp;</h6>
			<p class="pWinRates"><?php echo $player['pvpWins']; ?></p>
			<br />
			<h6 style="display: inline-block">PVP Loses:&nbsp;</h6>
			<p class="pWinRates"><?php echo $player['pvpLoses']; ?></p>
			<br/>
		</div>
	</div>

	<div id="homeEquipmentPanel">   
	
	<div id="inventoryBag">
	
		<div id="invBagWeps">
		<h2 style="color: #4B8CFF;">Weapons</h2>
		<?php 
			foreach($playerWeapons as $value) {
				$name = str_replace(' ', '', $value['Name']);
				echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/BagIcons/", $name, "BagIcon.png\" draggable=\"true\" id=\"", $name, $value['weaponID'], "\" ondragstart=\"drag(event, '", $value['Category'], "')\" ondragend=\"hideGlow(event)\"class=\"invBagIcons\"/>";
			}
		?>
		</div>
		<div id="invBagArms">
		<h2 style="color: #4B8CFF;">Armour</h2>
		<?php 
			foreach($playerArmours as $value) {
				$name = str_replace(' ', '', $value['Name']);
				echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/BagIcons/", $name, "BagIcon.png\" draggable=\"true\" id=\"", $name, $value['armourID'], "\" ondragstart=\"drag(event, '", $value['Category'], "')\" ondragend=\"hideGlow(event)\" class=\"invBagIcons\"/>";
			}
		?>
		</div>
	</div>

	<div id="armourSlot" ondrop="dropArm(event)" ondragover="allowDrop(event)">
		<?php 
			$a = str_replace(' ','', $equippedArmours[0]['Name']); 
			echo "<img id=\"humanTemplateImg\" src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/" . $a . "\"/>"; 
		?>
		<div id="armourHightlightBorder"></div>
	</div>
	
	
	<!-- <img id="humanTemplateImg" draggable="false" src="http://mi-linux.wlv.ac.uk/~1610476/Images/person.png" /> -->
	
	<div id="currentlyEquipped">
	
	<h3 style="color: #4B8CFF;">Equipped</h3>
	
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
		foreach($equippedArmours as $value) {
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
	</div>
	
	<div id="staffSlot" ondrop="drop(event)" ondragover="allowDrop(event)">
		<?php 
			$a = str_replace(' ','', $equipped[0]['Name']); 
			echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/" . $a . "\"/>"; 
		?>
	</div>
	
	<script>
		// Needed to let you actually place the item inside it.
		function allowDrop(ev) {
			ev.preventDefault();
		}

		function drag(ev, cat) {
			ev.dataTransfer.setData("text", ev.target.id);

			if (cat == "Sword") {
				$("#staffSlot").css("box-shadow", "0 0 0 2000px rgba(0,0,0,0.6), 0 0 0 2px rgba(80,0,255,0.9)");
			}
			else {
				$("#armourHightlightBorder").css("box-shadow", "0 0 0 2000px rgba(0,0,0,0.6), 0 0 0 2px rgba(80,0,255,0.9)");
			}
		}
		
		function hideGlow() {	
			$("#staffSlot").css("box-shadow", "none");	
			$("#armourHightlightBorder").css("box-shadow", "none");			
		}
		
		function drop(ev) {
			
			$("#staffSlot").css("box-shadow", "none");
			
			ev.preventDefault();
			var data = ev.dataTransfer.getData("text");
			var wepName = data.replace(/[0-9]/g, '');
			// Grabs the number from data
			var wepID = data.replace(/[^0-9]/g, '');
			var imgSrc = "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/"
			var imgName = wepName;
			var imgEnd = ".png\"/>";
			var combined = imgSrc.concat(imgName, imgEnd);
			document.getElementById("staffSlot").innerHTML = combined;
			
			var testy = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/equipItem/";
			var a = <?php echo $player['playerID']; ?>;
			var b = "/";
			var testy2 = testy.concat(a, b, wepID);
			// alert(testy2);
			$.ajax({
                    type: "POST",
                    url: testy2,
                    data: '',
                    success: function (response) {
                        $('#currentlyEquipped').html(response);
                    },
                    failure: function (response) {
                        alert("Failure.");
                    },
                    error: function (response) {
                        alert("Error." + response);
                    }
                });
		}
		
		function dropArm(ev) {
			ev.preventDefault();
			var data = ev.dataTransfer.getData("text");
			var armName = data.replace(/[0-9]/g, '');
			// Grabs the number from data
			var armID = data.replace(/[^0-9]/g, '');
			var imgSrc = "<img id=\"humanTemplateImg\" src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/"
			var imgName = armName;
			var imgEnd = ".png\"/>";
			var combined = imgSrc.concat(imgName, imgEnd);
			document.getElementById("armourSlot").innerHTML = combined;
			document.getElementById("armourSlot").innerHTML += "<div id=\"armourHightlightBorder\"></div>";
			
			var testy = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/equipItemArm/";
			var a = <?php echo $player['playerID']; ?>;
			var b = "/";
			var testy2 = testy.concat(a, b, armID);
			// alert(testy2);
			$.ajax({
                    type: "POST",
                    url: testy2,
                    data: '',
                    success: function (response) {
                        $('#currentlyEquipped').html(response);
                    },
                    failure: function (response) {
                        alert("Failure.");
                    },
                    error: function (response) {
                        alert("Error." + response);
                    }
                });
		}
	</script>
	
	</div>
	
	<div id="notificationBox"> 
		<?php 
			$mailCount = 0;
			foreach ($mail as $value) {
				if ($value['HasBeenRead'] == 0) {
					$mailCount++;
				}
			}
			if ($mailCount > 0) {
				echo "<div class=\"alert alert-info alert-dismissable\">";
				echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
				echo "<strong>Mail:</strong> You have ", $mailCount, " unread messages!";
				echo "</div>";
			}
		?>
		<?php 
			$attackCount = 0;
			foreach ($battles as $value) {
				if($value['HasBeenSeen'] == 0) {
					$attackCount++;
				}
			}
			if ($attackCount > 0) {
				echo "<div class=\"alert alert-danger alert-dismissable\">";
				echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
				echo "<strong>Fights:</strong> You have been attacked ", $attackCount, " times.";
				echo "</div>";
			}
		?>
		
	</div>
	
</div>


