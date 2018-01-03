<div id="mainSectionHome">
	
<h1>Training Grounds</h1>

<h4 style="display: inline-block;">Energy:</h4> 
<input type="number" value="1" id="turnCount" name="energyNum" min="1" max="100" style="display: inline-block;"/>
<br/>
<?php echo $stat; ?>

<button type="button" onclick="trainStat()">Train</button>
<div id="results"></div>

<script>
	
	function trainStat() {
		
		var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/trainStat/";
		// Need to encode it otherwise it doesn't appear as a string with the "'s either side.
		var stat = <?php echo json_encode($stat); ?>;
		var turns = $("#turnCount").val();;
		var dash = "/";
		var combined = url.concat(stat, dash, turns);
		$.ajax({
			type: "POST",
			url: combined,
			data: '',
			success: function (response) {
				$('#results').html(response);
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







