<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="http://mi-linux.wlv.ac.uk/~1610476/style.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div id="leftNavBar" onload="claimEnergy()">
    <!-- Putting these as real server files with actual names would be better -->
	<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/home"><img src="https://i.imgur.com/TN22WsW.png" class="navBarImages" onmouseover="smoothText(1)" onmouseleave="placeTextBack(1)"/></a>
	<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/social"><img src="https://i.imgur.com/wR3Lrod.png" class="navBarImages" onmouseover="smoothText(2)" onmouseleave="placeTextBack(2)"/></a>
	<img src="https://i.imgur.com/hmap735.png" class="navBarImages" onmouseover="smoothText(3)" onmouseleave="placeTextBack(3)" onclick="showExplore()"/>
	<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/payNow" id="vipCrownIcon"><img src="https://mi-linux.wlv.ac.uk/~1610476/Images/sideMenuIcons/vipCrown" class="navBarImages"/></a>
	<!-- <img src="https://i.imgur.com/K6r5kvd.png" class="navBarImages" onmouseover="smoothText(4)" onmouseleave="placeTextBack(4)" id="settingBtn"/> -->
	<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/logout" id="aLogout"><img src="https://i.imgur.com/dZYMfep.png" class="navBarImages" onmouseover="smoothText(5)" onmouseleave="placeTextBack(5)" id="logoutBtn"/></a>
	
	<p class="navBarTooltip" id="navBarT1">Home</p>
	<p class="navBarTooltip" id="navBarT2">Social</p>
	<p class="navBarTooltip" id="navBarT3">Explore</p>
	<!-- <p class="navBarTooltip" id="navBarT4">Settings</p> -->
	<p class="navBarTooltip" id="navBarT5">Logout</p>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		function smoothText(x){
			$("#navBarT" + x).css("display", "block");
			$("#navBarT" + x).animate({marginLeft: "35px"});    
		}
		
		function placeTextBack(x) {
			$("#navBarT" + x).animate({marginLeft: "0px"});
			setTimeout(function(){
				hideText(x);
			}, 500);		
		}
		
		function hideText(x) {
			$("#navBarT" + x).css("display", "none");
		}
		
		function showExplore(x){
			$("#hiddenExplore").css("z-index", "0");
			<!-- Need to make the main content -1 so the menu displays over it but -1 makes items not draggable / hoverable  -->
			$("#mainSectionHome").css("z-index", "-1");
			$("#hiddenExplore").animate({marginLeft: "8%"});   

			$("#navBarT3").css("display", "none");
		}
		
		function hideExplore(x) {
			$("#hiddenExplore").animate({marginLeft: "-8%"});  
			setTimeout(function(){
				resetZIndexes();
			}, 500);

		}
		
		function resetZIndexes() {
			$("#hiddenExplore").css("z-index", "-1");
			$("#mainSectionHome").css("z-index", "0");
		}
		
		window.onload = function claimEnergy() {
			var url = "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/updateEnergy/"
			var playerID = <?php echo $_COOKIE['pID'] ?>;
			var combined = url.concat(playerID);
			$.ajax({
                    type: "POST",
                    url: combined,
                    data: '',
                    success: function (response) {
                        // Do nothing.
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


<div id="hiddenExplore" onmouseleave="hideExplore()">
	<p class="hEHeading">Town Market</h4>
	<nav>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/shop/Armours">Armour Shop</a>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/shop/Weapons">Weapon Shop</a>
		<a href="#" onclick="ajaxHeal();event.preventDefault();">Heal [10 gold]</a>
	</nav>
	<br />
	<p class="hEHeading">Town Center</h4>
	<nav>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/playerVersePlayer">PVP</a>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/work/">Work</a>
	</nav>
	<br/>
	<p class="hEHeading">Training</h4>
	<nav>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/training/Agility">Agility</a>
		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/training/Strength">Strength</a>
 		<a href="http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/training/Defense">Defense</a>
	</nav>
</div>

<script>

	function ajaxHeal() {
		$.ajax({
			type: "POST",
			url: "http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/healStation",
			data: '',
			success: function (response) {
				alert("You have been healed!");
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




