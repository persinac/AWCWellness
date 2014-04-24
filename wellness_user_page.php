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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Overview</a></li>
              <li><a href="#">My Progress</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

	<h1 id="greeting"><div id="div_greet"></div></h1>

	</div>
		<div id="data_container">
			<div id="div_activity_form">
			<form method="POST" id="activity_form" class="act_">
                <div id="activity_row">
					<h4>New Activity</h4>
                    <p></p>
                    Activity: <input type="text" name="activity" class="_activity" id="_activity"/>
                    <p></p>
                    Date Achieved: <input type="text" name="date" class="_datepicker" id="act_datepicker"/>
					<p></p>
					Duration: <input type="text" name="duration" class="_duration" id="duration"/> minutes
                    <p></p>
                    <p></p>
				</div
			</form>
			<button class="btn btn-success" id="submit">submit</button>
			</div>
			<div id="activity_list">
			</div>
			<div id="leaderboard">
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
		getUserFirstName();
	});
	$(function() {
		$("#act_datepicker").datepick({dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: true, autoSize: true});
	});	
	/********************************* GETTER METHODS *********************************/
	$(function(){
		$("button#submit").click(function() {
			submitActivity();
		});
	});
	
	/*
	* Called when page is finished loading
	* Used to get user's first name
	*
	*/
	function getUserFirstName()
	{
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
	
	/******************************** LOAD **************************************/

	/*
	* Called in getPastWODS function.
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
	
/************************************ SUBMITS ************************************************/
	function submitActivity() {
		var datastring = $("#activity_form").serializeArray();
		var sendRequest = true;
		var activity_name = "";
		var activity_date = "";
		var activity_time = "";
		
		//alert("DATASTRING: " + datastring.toString());
		activity_name = datastring[0].value;
		activity_date = datastring[1].value;
		activity_time = datastring[2].value;
		
		//sendRequest = false;
		alert(activity_name + ", " +activity_date+", "+activity_time);
		$.ajax({
			type: "POST",
			url: "wellness_addActivity.php",
			data: { "activity_name" : activity_name,
			"activity_date" : activity_date,
				"activity_time" : activity_time
				},
			success: function(data) {
				 alert('Data send:' + data);
			}
		});
	}
	
	</script
	
  </body>
</html>