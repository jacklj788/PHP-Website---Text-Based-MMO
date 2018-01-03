<div id="mainSectionHome">
	
	<div id="messageBox">
		<?php 
			foreach($messages as $value) {
				echo "<div class=\"eachMessage\">";
					echo "<div id=\"fromName\"><strong>From:</strong> ", $value['PlayerFromName'], "(", $value['PlayerFrom'], ")", "</div>";
					echo "<div id=\"dateSent\">Date: ", $value['SentDate'], "</div>";
					echo "<div id=\"messageHeading\">", $value['Heading'], "</div>";
					echo "<div id=\"messageContent\">", $value['Content'], "</div>";
					echo "<button type=\"submit\" class=\"btn btn-default\" id=\"replyToMessage\" onclick=\"populateReplyBox('", $value['PlayerFromName'], "')\">Reply</button>";
				echo "</div>";
			}
		?>
	</div>
	
	<div id="replyBox">
		<form id="messageFormReply" name="messageFormReply" method="post" enctype="multipart/form-data">
			<input type="text" id="replyToName" name="replyToName" required />
			<input type="text" id="replyHeading" name="replyHeading" placeholder="Message Topic.." required />
			<textarea rows="20" cols="50" id="replyContent" name="replyContent" placeholder="Enter your message here.." required ></textarea>
			
			<input id="replySend" name="replySend" type="submit">
		</form>
	</div>

	<div id="attackNews">
		<?php 
			foreach ($battles as $value) {
				echo "<div class=\"battleLogRow\">";
				
				$date = strtotime($value['Date']);
				echo date('d/m/Y H:i:s', $date), ": ";
				if ($value['DidTheyWin'] == 1) {
					echo $value['Name'], "(", $value['EnemyID'], ")", " killed you in battle.";
				}
				else {
					echo $value['Name'], "(", $value['EnemyID'], ")", " tried to attack you but failed.";
				}
				echo "</div>";
			}
		?>
	</div>
	
	<div id="anotherMessage" onclick="bringMessageboxDown()">Create Message</div>
<script>
	function populateReplyBox(name) {
		$("#replyToName").val(name);
		$("#replyContent").attr("placeholder", "Enter your message for " + name + " to read!");
	}	
	
	
	function bringMessageboxDown() {
		$("#anotherMessage").css("display", "none");
		$("#replyToName").val('');
		$("#replyHeading").val('');
		$("#replyContent").val('');
		$("#replyBox").animate({
			top: "8%"
		}, 2000);
	}
	
	 $(function(){
		  $("#replySend").click(function(e){  // passing down the event 

			$.ajax({
			   url:'http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/sendMail',
			   type: 'POST',
			   data: $("#messageFormReply").serialize(),
			   success: function(response){
					$("body").css("overflow", "hidden");
					$("#replyBox").animate({ right: "-50%"}, 2000, function() {
						$("#replyBox").css("top", "-100%")
						$("#replyBox").css("right", "0")
						$("#anotherMessage").css("display", "block");
					});
					
			   },
			   error: function(){
				   alert("Error sending message.");
			   }
		   });
		   e.preventDefault(); // could also use: return false;
		 });
	});
</script>
	
</div>





