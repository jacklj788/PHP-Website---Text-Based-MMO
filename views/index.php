<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="http://mi-linux.wlv.ac.uk/~1610476/style.css">
</head>
<body>

<div id="mainSection">

	<h1 id="gameTitleHeading">Warriors of Dunswich <small>Conquer Your Enemies</small></h1>

	
	<div id="loginFormContainer">
		<form action="/~1610476/index.php/welcome/login" method="post">
			<label for="uNameForm" class="loginLbls" id="uNameFormLabel">Username:</label>
				<!-- [a-zA-Z] requires 1 letter. + means i can have more than 1  --> 
			<input type="text" class="form-control" id="uNameForm" pattern="[a-zA-Z]+" required name="playerName"/>
			
			<label for="pWordForm" class="loginLbls" id="pWordFormLabel">Password:</label>
			<input type="password" class="form-control" id="pWordForm" required name="playerPassword"/>
			
			<button type="submit" class="btn btn-default" id="loginSubmitBtn">Login</button>
		</form>
		
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/createAccount" id="joinNowBtn"><span>Join Now</span></a>
	</div>
	
</div>
<script>

</script>
</body>
</html>




