<div id="mainSectionHome">
	
<h1>Work</h1>

<h4 style="display: inline-block;">Energy:</h4> 
<input type="number" value="1" id="turnCount" name="energyNum" min="1" max="100" style="display: inline-block;"/>
<br/>

<button type="button" onclick="earnGold()">Work</button>
<div id="results"></div>

<script>
	
	function earnGold() {
		
		var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/earnGoldFromWork/";
		var turns = $("#turnCount").val();;
		var combined = url.concat(turns);
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







