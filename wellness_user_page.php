<?php require_once('Connections/wellnessConn.php'); ?>
<?php 
session_start();
if(isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username'])) {
   //echo 'Set and not empty, and no undefined index error!';
} else {
	header("Location: WellnessUnauthorizedAccess.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Page</title>

    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="dist/css/wellness_progress.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="dist/css/jquery.datepick.css">

  </head>
  <body>
    
<div id="container">
		<!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">AWC Wellness</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li ><a href="wellness_index">Home</a></li>
              <li><a href="wellness_admin_page">Overview</a></li>
              <li class="active"><a href="#">My Progress</a></li>
			  <li id="logout"><a href="#">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

	<h1 id="greeting"><div id="div_greet"></div></h1>

	
	<div id="data_container">
		<div id="div_activity_form">
			<form method="POST" id="activity_form" class="act_">
				<div id="activity_row">
					<h4>New Activity</h4>
					<p></p>
					Activity: <select name="activity" class="_activity" id="_activity">
						<option value="Walking">Walking</option>
						<option value="Running">Running</option>
						<option value="Jogging">Jogging</option>
						<option value="Cycling">Cycling</option>
						<option value="Hiking">Hiking</option>
						<option value="Other">Other Aeorbic Activity</option>
						</select>
					<p></p>
					Date of Activity: <input type="text" name="date" class="_datepicker" id="act_datepicker"/>
					<p></p>
					Duration: <input type="text" name="duration" class="_duration" id="duration"/> minutes
					<p></p>
					<p></p>
				</div>
				<button class="btn btn-success" id="submit_activity">submit</button>
			</form>
			
		</div>
		<div id="activity_list">
			<h4>Past Cardio</h4>
			<table id="tbl_past_wod" rules="cols" cellpadding="10px">
				<tr>
					<th>Date</th>
					<th>Type of Cardio</th>
					<th>Duration</th>
				</tr>
				<tbody class="tbl_body_past_actvs">
				</tbody>
			</table>
		</div>
		<div id="leaderboard">
			<h4>Stats</h4>
			<div id="total_minutes">
				<h5>Total Minutes:</h5>
				<div id="total_minutes_data" class="stats_data"></div>
			</div>
			<div id="total_grouped_minutes">
				<h5>Total Grouped Minutes:</h5>
				<div id="total_grouped_minutes_data" class="stats_data"></div>
			</div>
			<div id="total_weekly_minutes">
				<h5>Total Weekly Minutes:</h5>
				<div id="total_weekly_minutes_data" class="stats_data"></div>
			</div>
			<div id="total_weekly_grouped_minutes">
				<h5>Total Weekly Grouped Minutes:</h5>
				<div id="total_weekly_grouped_minutes_data" class="stats_data"></div>
			</div>
		</div>
		<button class="btn btn-primary" id="change_pw">
        Change Password
      </button>
	</div>
	<div id="popup">
		<div>Enter New Password:</div>
		<input id="new_pass" type="password"/>
		<div>Confirm Password:</div>
		<input id="confirm_pass" type="password"/>
		<p></p>
		<button onclick="done()">Submit</button>
		<button onclick="cancel()">Cancel</button>		
	</div>
</div>
	
</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="dist/js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="dist/js/jquery.datepick.js"></script>
    
	<script> 
	
	$(document).ready(function() {
	var uid = "<?php echo $_SESSION['MM_UserID'];?>" ;
		console.log("User ID: " + uid);
		getUserFirstName();
		getUserActivities();
		getUserTotalActivities();
		getUserGroupedTotalActivities();
		getUserWeeklyTotalActivities();
		getUserWeeklyGroupedTotalActivities();
	});
	$(function() {
		$("#act_datepicker").datepick({dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: true, autoSize: true});
	});	
	$(function() {
		$( "#submit_activity" ).click(function( event ) {
		console.log("submit activity pressed");
		submitActivity();
		event.preventDefault();
		});
	});
	
	$("#change_pw").click(function () {
		console.log("should open change pw modal...");
		document.getElementById("popup").style.display = "block";
	});
	
	$("#logout").click(function () {
		console.log("logging out...");
		
		$.ajax(
		{ 
			url: "wellness_logout.php", //the script to call to get data  
			success: function(response) //on recieve of reply
			{
				console.log("logged out...");
				window.location.replace("http://cboxbeta.com/wellness_index");
			} 
		});
	});
	
	function done() { 
    
		var new_password = document.getElementById("new_pass").value;
		var con_password = document.getElementById("confirm_pass").value;
		var doesMatch = true;
		var clean=/^[a-zA-Z0-9&_\.@]+$/;
		if(clean.test(new_password)) {
			if(new_password.length == con_password.length && doesMatch == true) {
				for(var i =0; i < new_password.length; i++) {
					if(new_password.charAt(i) != con_password.charAt(i)) {
						doesMatch = false;
					}
				}
			} else {
				doesMatch = false;
			}
			
			if(doesMatch == false) {
				alert("Passwords do not match!");
			} else {
				//alert("Passwords match!");
				document.getElementById("popup").style.display = "none";
				updatePassword(new_password);
			}	
		}
		else {
			alert("Invalid characters");
		}
   	}
	
	function cancel() {
		document.getElementById("popup").style.display = "none";
	}
	
	/********************************* GETTER METHODS *********************************/
	
	/*
	* Called when page is finished loading
	* Used to get user's first name
	*
	*/
	function getUserFirstName()
	{
		
		//console.log("User ID: " + uid);
		var html = "";
		//now load data into table
		//alert("PRE-AJAX");
		$.ajax(
		{ 
			url: "testPHP.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				//alert(response);
				loadUserFirstName(response);
			} 
		});
	}
	
	function getUserActivities()
	{
		var html = "";
		$.ajax(
		{ 
			url: "getUserActivities.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				//console.log(response);
				loadUserActivities(response);
			} 
		});
	}
	
	function getUserTotalActivities()
	{
		console.log("get user total activities");
		var html = "";
		$.ajax(
		{ 
			url: "getUserTotalActivities.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				console.log(response);
				loadUserTotalActivities(response);
			} 
		});
	}
	
	function getUserGroupedTotalActivities()
	{
		console.log("get user grouped total activities");
		var html = "";
		$.ajax(
		{ 
			url: "getUserGoupedTotalActivities.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				console.log(response);
				loadUserGroupedTotalActivities(response);
			} 
		});
	}
	
	function getUserWeeklyTotalActivities()
	{
		console.log("get user weekly total activities");
		var html = "";
		$.ajax(
		{ 
			url: "getUserTotalWeeklyActivities.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				console.log(response);
				loadUserWeeklyTotalActivities(response);
			} 
		});
	}
	
	function getUserWeeklyGroupedTotalActivities()
	{
		console.log("get user weekly grouped total activities");
		var html = "";
		$.ajax(
		{ 
			url: "getUserWeeklyGroupedActivities.php", //the script to call to get data  
			dataType: "json",
			success: function(response) //on recieve of reply
			{
				console.log(response);
				loadUserWeeklyGroupedTotalActivities(response);
			} 
		});
	}
	
	/******************************** LOAD **************************************/

	/*
	* Called in getUserActivities function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserActivities(data)
	{
		var html_sec1 = "";
		var date = "";
		var activity = "";
		var duration = "";
		var actID = "";
		
		for(var i = 0; i < data.length; i++) {
			date = data[i].DateofActivity;
			activity = data[i].activity;
			duration = data[i].duration_of_activity;
			actID = data[i].activity_id;
			///console.log(date + ", " + activity + ", " + duration);
			html_sec1 += "<tr><td>"+
				data[i].DateofActivity+"</td><td>"+data[i].activity+"</td><td>"
				+data[i].duration_of_activity+"</td><td><input type=\"button\" value=\"Remove\" id=\"removebutton\" onclick=\"removeActivity("+actID+");\"></td></tr>";
		}
		//Update html content
		$('.tbl_body_past_actvs').empty();
		$('.tbl_body_past_actvs').html(html_sec1);
	}
	
	/*
	* Called in getUserFirstName function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserFirstName(data)
	{
		var html_sec1 = "";
		var name = "";
		name = data[0].f_name;
		
		html_sec1 += "Welcome "+name+"!";
		//Update html content
		$('#greeting').html(html_sec1);
	}
	
	/*
	* Called in getUserTotalActivities function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserTotalActivities(data)
	{
	console.log("total activity loading: " + data);
		var html_sec1 = "";
		var totalMinutes = "";
		totalMinutes = data[0].TotalActivity;
		
		html_sec1 += totalMinutes+" minutes";
		//Update html content
		$('#total_minutes_data').html(html_sec1);
	}
	
	/*
	* Called in getUserActivities function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserGroupedTotalActivities(data)
	{
		var html_sec1 = "";
		var activity = "";
		var duration = "";
		
		for(var i = 0; i < data.length; i++) {
			activity = data[i].activity;
			duration = data[i].TotalActivity;
			///console.log(date + ", " + activity + ", " + duration);
			html_sec1 += activity +": "+duration;
			html_sec1 += "<br>";
		}
		//Update html content
		$('#total_grouped_minutes_data').empty();
		$('#total_grouped_minutes_data').html(html_sec1);
	}
	
	/*
	* Called in getUserWeeklyTotalActivities function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserWeeklyTotalActivities(data)
	{
	console.log("weekly activity loading: " + data);
		var html_sec1 = "";
		var totalMinutes = "";
		totalMinutes = data[0].WeeklyActivity;
		
		html_sec1 += totalMinutes+" minutes";
		//Update html content
		$('#total_weekly_minutes_data').html(html_sec1);
	}
	
	/*
	* Called in getUserActivities function.
	* Parses the ajax request - JSON - format, and
	* places the results in descending order in a table 
	* in the appropriate DOM.
	*
	*/
	function loadUserWeeklyGroupedTotalActivities(data)
	{
		var html_sec1 = "";
		var activity = "";
		var duration = "";
		
		for(var i = 0; i < data.length; i++) {
			activity = data[i].activity;
			duration = data[i].WeeklyActivity;
			///console.log(date + ", " + activity + ", " + duration);
			html_sec1 += activity +": "+duration;
			html_sec1 += "<br>";
		}
		//Update html content
		$('#total_weekly_grouped_minutes_data').empty();
		$('#total_weekly_grouped_minutes_data').html(html_sec1);
	}
	

/*******************************************************************************/

function removeActivity(activity_id) {
	
	console.log("removing activity: " + activity_id);
		var html = "";
		$.ajax(
		{ 
			type: "POST",
			url: "wellness_removeUserActivity.php", //the script to call to get data  
			data: { "activity_id" : activity_id },
			dataType: "text",
			success: function(response) //on receive of reply
			{
				console.log(response);
				getUserActivities();
				getUserTotalActivities();
				getUserGroupedTotalActivities();
				getUserWeeklyTotalActivities();
				getUserWeeklyGroupedTotalActivities();
			} 
		});
}	
	
/************************************ SUBMITS ************************************************/

	function submitActivity()
	{
		var datastring = $("#activity_form").serializeArray();
		var activity_name = "";
		var activity_date = "";
		var activity_time = "";
		
		//console.log("DATASTRING: " + datastring);
		activity_name = datastring[0].value;
		activity_date = datastring[1].value;
		activity_time = datastring[2].value;
		
		console.log("Details: "+activity_name + ", " +activity_date+", "+activity_time);
		
		$.ajax({
			type: "POST",
            url: "wellness_addActivity.php",
			datatype: "text",
			data: {"name" : activity_name, 
				"date" : activity_date,
				"time" : activity_time },
            success: function(data) {
				console.log('Data send:' + data);
				clearForm();
				getUserActivities();
				getUserTotalActivities();
				getUserGroupedTotalActivities();
				getUserWeeklyTotalActivities();
				getUserWeeklyGroupedTotalActivities();
            },
			error: function(data) {
				console.log("ERROR: " + data);
				for(var i = 0; i < data.length; i++) {
					console.log(data[i].toString());
					}
			}
			
        });
	}
	
	function updatePassword(new_pw)
	{
		console.log("Details: "+new_pw);
		
		$.ajax({
			type: "POST",
            url: "wellness_updatePassword.php",
			datatype: "text",
			data: {"password" : new_pw},
            success: function(data) {
				console.log('Data send:' + data);
            },
			error: function(data) {
				console.log("ERROR: " + data);
			}
        });
	}
	
	function clearForm() {
		$('#activity_form input').each(function(index, element) {
			console.log(index + " : " + $(this).text());
			$(this).val('');
		});	
	}
	
	</script>
	
  </body>
</html>