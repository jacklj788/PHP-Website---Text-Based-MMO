<div id="mainSectionHome">
	
	<button onclick="attackBodyPart('head')" id="btnHead" class="attackBtns">HEAD</button>
	<button onclick="attackBodyPart('body')" id="btnBody" class="attackBtns">BODY</button>
	<button onclick="attackBodyPart('arm')" id="btnArm" class="attackBtns">ARM</button>
	<button onclick="attackBodyPart('leg')" id="btnLeg" class="attackBtns">LEG</button>

	
	<div id="combatLog"> 
		<div id="combatLogContent">
			<p>Target Engaged!</p>
		</div>
	</div>
	
	<img id="attackPlayerIcon" src="http://mi-linux.wlv.ac.uk/~1610476/Images/personAttack.png"/>
	
	<?php	
		$damagePerHit = $playerStats['Strength'] - $enemyStats['Defense'];
		$enemyDamagePerHit = $enemyStats['Strength'] - $playerStats['Defense'];
		$missChance;
		
		if ($damagePerHit < 5) {
			$damagePerHit = 5;
		}
		if ($enemyDamagePerHit < 5) {
			$enemyDamagePerHit = 5;
		}
		if ($playerStats['Agility'] > ($enemyStats['Agility'] * 2)) {
			$missChance = 100;
		} else if ($playerStats['Agility'] > $enemyStats['Agility']) {
			$missChance = 50;
		} else {
			$missChance = 0;
		}
	?>
	
	<button onclick="imFeelingLucky()" id="attackBtn">ATTACK</button>
	
	<canvas id="myCanvas" width="400" height="150" style="border:1px solid #c3c3c3;">
		Your browser does not support the canvas element.
	</canvas>
	
	<script>
	
		var canvas = document.getElementById("myCanvas");
		var failZone = canvas.getContext("2d");
		var successZone = canvas.getContext("2d");
		var criticalZone = canvas.getContext("2d");
		var pin = canvas.getContext("2d");
		
		var playerLife = 100;
		var enemyLife = 100;
		
		var damagePerAttack = <?php echo $damagePerHit; ?>;
		var enemyDamagePerAtatck = <?php echo $enemyDamagePerHit; ?>;
		var miss = <?php echo $missChance; ?>;
		
		var missThisTurn = 0;
		
		var bodyPartBeingAttacked = "body";
		
		var positionY = 2;
		var moveRight = 1;
		
		var gameStart = true;
		
		var bloodSize = 100;
		
		var gamePinMove = setInterval(movePin, 1);
		
		var test = setInterval(function() {
			if (gameStart) {
				if (miss == 100) {
					$("#combatLogContent").append("<p>The enemy missed you.. Completely.. </p>");
				} else if (miss == 50) {
					if(missThisTurn = 1) {
						$("#combatLogContent").append("<p>The enemy just about missed you!</p>");
						missThisTurn= 0;
					} else {
						playerLife -= enemyDamagePerAtatck;
						$("#combatLogContent").append("<p>The enemy hit you for" + enemyDamagePerAtatck + " damage!!</p>");		
						missThisTurn= 1;						
					}
				}
				else {
					playerLife -= enemyDamagePerAtatck;
					$("#combatLogContent").append("<p>The enemy hit you for" + enemyDamagePerAtatck + " damage!!</p>");
				}
				
				if (enemyLife <= 0 || playerLife <= 0) 	{
					gameStart = false;
				}
				var str2 = "s";
				var speed = "3";
				//ar str3 = "px red";
				var string = speed.concat(str2);
				//$("body").css("box-shadow", "inset 0 0 400px red");
				$("body").css("animation-name", "bloodPulse");
				$("body").css("animation-duration", string);
				//bloodSize += 100;
				setTimeout(function(){
					$("body").css("animation-name", "none");
				}, 3000);
			}
		}, 4000);
		
		
		function setUpGame() {
			gameStart = true;
			
			if(bodyPartBeingAttacked == "head") {
				failZone.fillStyle = "#0C0E12";
				// X , Y, WIDTH, HEIGHT
				failZone.fillRect(0,0,400,150);
				
				successZone.fillStyle = "#B9BABD";
				successZone.fillRect(100,0,200,150);
				
				criticalZone.fillStyle = "#435788";
				criticalZone.fillRect(195,0,10,150);				
			}
			else if(bodyPartBeingAttacked == "body") {
				failZone.fillStyle = "#0C0E12";
				// X , Y, WIDTH, HEIGHT
				failZone.fillRect(0,0,400,150);
				
				successZone.fillStyle = "#B9BABD";
				successZone.fillRect(50,0,300,150);
				
				criticalZone.fillStyle = "#435788";
				criticalZone.fillRect(190,0,20,150);				
			}
			else {
				failZone.fillStyle = "#0C0E12";
				failZone.fillRect(0,0,400,150);
				
				successZone.fillStyle = "#B9BABD";
				successZone.fillRect(35,0,330,150);
				
				criticalZone.fillStyle = "#435788";
				criticalZone.fillRect(180,0,40,150);
			}
		}
		
		function createUserPin() {
			pin.fillStyle = "#0000FF";
			pin.fillRect(200,0,5,150);
		}
		
		function movePin() {
			if (gameStart == true) {
				setUpGame();
				
				
				if(positionY == 390) {
					moveRight = 0;
				}
				
				if(positionY == 0) {
					moveRight = 1;
				}
				if(moveRight == 1)
				{
					positionY += 2;
				}
				
				if(moveRight == 0)
				{
					positionY -= 2;
				}
				
				pin.fillStyle = "#0000FF";
				pin.fillRect(positionY,0,5,150);
			}
			else {
				clearInterval(test);
				clearInterval(gamePinMove);
				var str1 = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/battleResults/";
				var str2 = <?php echo $playerStats['playerID'];?>;
				var str3 = <?php echo $enemyStats['playerID'];?>;
				var str4 = (playerLife).toFixed(2);
				var str5 = (enemyLife).toFixed(2);
				var url = str1.concat(str2, "/", str3, "/", str4, "/", str5);
				window.location = url;
			}
		}
		
		function imFeelingLucky() {
			
			if (bodyPartBeingAttacked == "arm" || bodyPartBeingAttacked == "leg") {
				if (positionY >= 180 && positionY <= 220) {
					$("#combatLogContent").append("<p>You scored a critical hit!! Striking the enemy for " + damagePerAttack + "</p>");
					enemyLife = enemyLife - damagePerAttack;
				}
				else if(positionY >= 35 && positionY <= 365) {
					$("#combatLogContent").append("<p>You hit the enemy for " + (damagePerAttack / 2) + "</p>");
					enemyLife = enemyLife - (damagePerAttack / 2);
				}
				else {
					$("#combatLogContent").append("<p>You failed to hit the target.</p>");
				}
			}
			else if (bodyPartBeingAttacked == "head") {
				if (positionY >= 195 && positionY <= 205) {
					$("#combatLogContent").append("<p>You scored a critical hit!! Striking the enemy for " + damagePerAttack + "</p>");
					enemyLife = enemyLife - damagePerAttack;
				}
				else if(positionY >= 100 && positionY <= 300) {
					$("#combatLogContent").append("<p>You hit the enemy for " + (damagePerAttack / 2) + "</p>");
					enemyLife = enemyLife - (damagePerAttack / 2);
				}
				else {
					$("#combatLogContent").append("<p>You failed to hit the target.</p>");
				}
			}
			else {
				if (positionY >= 190 && positionY <= 210) {
					$("#combatLogContent").append("<p>You scored a critical hit!! Striking the enemy for " + damagePerAttack + "</p>");
					enemyLife = enemyLife - damagePerAttack;
				}
				else if(positionY >= 50 && positionY <= 350) {
					$("#combatLogContent").append("<p>You hit the enemy for " + (damagePerAttack / 2) + "</p>");
					enemyLife = enemyLife - (damagePerAttack / 2);
				}
				else {
					$("#combatLogContent").append("<p>You failed to hit the target.</p>");
				}
			}
			
			if (enemyLife <= 0 || playerLife <= 0) 	{
				gameStart = false;
			}
						
		}
		
		function attackBodyPart(bodyPart) {
			
			bodyPartBeingAttacked = bodyPart;
			setUpGame();
			createUserPin();
		}
		
		function endGame(eL, pL) {
			alert("Enemy Life: " + eL + " Player Life: " + pL);
		}

	</script>

</div>





