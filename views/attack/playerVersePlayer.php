<div id="mainSectionHome">

	<div id="searchPlayer">
		<h4>Search Name:</h1>
		<input type="text" autocomplete="off" id="searchPlayerBar" name="playerName" onkeyup="searchPlayer()" onblur="hideSearchList()">
	</div>
	
	<div id="searchPlayerLevel">
		<h4>Search Level:</h1>
		<input type="number" autocomplete="off" value="1" id="searchPlayerBarLevel" name="playerLevel" onkeyup="searchPlayerLevel()" onchange="searchPlayerLevel()" onblur="hideSearchListLevel()">
	</div>
	
	<div id="displayNames">
		
	</div>
	
	<div id="displayNamesLevel">
	
	</div>

	<div id="topLevelPlayers"/>
		<h1>Top Levels</h1>
		<?php 
			foreach($topLevel as $value) {			
				echo "<strong>Level ", $value['Level'], "</strong> ";
				echo $value['Name'], "(", $value['playerID'], ")";
				if ($value['vip']) {
					echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/vipCrownSmall\" />"; 
				}
				if ($value['playerID'] == get_cookie('pID')) {
					echo " <strong style=\"color: green;\">You!</strong><br />";
				} else {
					if ($value['Health'] > 0) {
						echo "<a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/attackPlayer/", $value['playerID'], "\"> attack </a><br/>";
					} else {
						echo " <strong style=\"color: red;\">[Dead]</strong><br />";
					}
				}
			}
		?>
	</div>
	<div id="topWinPlayers"/>
		<h1>Top Wins</h1>
		<?php 
			foreach($topWins as $value) {			
				echo "<strong>Wins ", $value['pvpWins'], "</strong> ";
				echo $value['Name'], "(", $value['playerID'], ")";
				if ($value['vip']) {
					echo "<img src=\"http://mi-linux.wlv.ac.uk/~1610476/Images/vipCrownSmall\" />"; 
				}
				if ($value['playerID'] == get_cookie('pID')) {
					echo " <strong style=\"color: green;\">You!</strong><br />";
				}
				else {
					if ($value['Health'] > 0) {
						echo "<a href=\"http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/attackPlayer/", $value['playerID'], "\"> Attack </a><br/>";
					} else {
						echo " <strong style=\"color: red;\">[Dead]</strong><br />";
					}
				}
			}
			?>
	</div>
<script>

	function hideSearchList() {
		setTimeout(function() {
			$('#displayNames').css("display", "none");
		}, 500);
	}
	
	function hideSearchListLevel() {
		setTimeout(function() {
			$('#displayNamesLevel').css("display", "none");
		}, 500);
	}
	
	function searchPlayer() {
		
		var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/searchPlayer/";
		var str = $("#searchPlayerBar").val();;
		var combined = url.concat(str);
	
		if (str) {
			$.ajax({
				type: "POST",
				url: combined,
				data: '',
				success: function (response) {
					$('#displayNames').css("display", "block");
					$('#displayNames').html(response);
				},
				failure: function (response) {
					alert("Failure.");
				},
				error: function (response) {
					alert("Error." + response);
				}
			});
		}
	}
	
		function searchPlayerLevel() {
		
		var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/searchPlayerLevel/";
		var str = $("#searchPlayerBarLevel").val();;
		var combined = url.concat(str);
	
		if (str) {
			$.ajax({
				type: "POST",
				url: combined,
				data: '',
				success: function (response) {
					$('#displayNamesLevel').css("display", "block");
					$('#displayNamesLevel').html(response);
				},
				failure: function (response) {
					alert("Failure.");
				},
				error: function (response) {
					alert("Error." + response);
				}
			});
		}
	}
	</script>
	
</div>





