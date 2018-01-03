<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Create Account</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="http://mi-linux.wlv.ac.uk/~1610476/style.css">
</head>
<body>

<div id="mainSection">

	<h3 id="cAccountHeading">Create Account</h3>
	
	<div id="caFormDiv">
		<div class="row">
			<div class="offset-md-4 col-md-4" id="cAForm">
				<form action="/~1610476/index.php/welcome/verifyAccountCreation" method="post" title="Create Account Details">
					<div class="form-group">
						<label for="uNameFormCA" class="loginLbls">Username:</label>
						<!-- [a-zA-Z] requires 1 letter. + means i can have more than 1  --> 
						<input type="text" class="form-control" id="uNameFormCA" pattern="[a-zA-Z]+" required name="playerNameCA" onblur="checkName()"/>
					</div>
					<div class="form-group">
						<label for="pWordFormCA" class="loginLbls">Password:</label>
						<input type="password" class="form-control" id="pWordFormCA" required name="playerPasswordCA" onkeyup="showStrength()"/>
					</div>
					<div class="form-group">
						<label for="pWordFormConfirmCA" class="loginLbls">Password:</label>
						<input type="password" class="form-control" id="pWordFormConfirmCA" required name="playerPasswordConfirmCA" onkeyup="checkIsSame()"/>
					</div>
					<button type="submit" class="btn btn-default" id="createAccountSubmitBtn" disabled>Sign Up</button>
				</form>
			</div>
		</div>
	
	<p id="pWordStrength"></p>
	<p id="uNameIsTaken"></p>
	
</div>


<div id="returnToLoginBtn">
	<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/index">Login</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	function showStrength() {
		var pass = $("#pWordFormCA").val();;
		
		if(pass.length < 4) {
			$("#pWordStrength").html("Weak.");
			$("#pWordStrength").css("color", "red");
		}
		// First checks for numbers. Second for upper case.
		else if (pass.match(/\d+/g) && pass.match(/.*[A-Z]+.*/)) {
			$("#pWordStrength").html("Strong.");
			$("#pWordStrength").css("color", "green");
		}
		else if (pass.match(/\d+/g) || pass.match(/.*[A-Z]+.*/)) {
			$("#pWordStrength").html("Average.");
			$("#pWordStrength").css("color", "orange");
		}
		else {
			$("#pWordStrength").html("Weak.");
			$("#pWordStrength").css("color", "red");
		}
	}
	
	function checkIsSame() {
		
		var pass = $("#pWordFormCA").val();;
		var passConfirm = $("#pWordFormConfirmCA").val();;
		
		var uNameStatus = $("#uNameIsTaken").text()
	
		if (pass == passConfirm && uNameStatus == "Available!") {
			document.getElementById('createAccountSubmitBtn').disabled = false;
		}
	}
	
	function checkName() {		
		var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/checkUsername/";
		var str = $("#uNameFormCA").val();;
		var combined = url.concat(str);
		
	
		$.ajax({
			type: "POST",
			url: combined,
			data: '',
			success: function (response) {
				// Removes quote marks.
				var a = jQuery.parseJSON(response);
				$("#uNameIsTaken").html(a);
				if (a == "Available!") {
					$("#uNameIsTaken").css("color","green");
				}
				else {
					$("#uNameIsTaken").css("color","red");
				}
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
</body>
</html>




