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
			<div id="activity_form">
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
    
	<script> 
	
	$(document).ready(function() {
		getUserFirstName();
	});
	
	/********************************* GETTER METHODS *********************************/
	
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
	
	
	</script
	
  </body>
</html>