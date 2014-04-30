<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Page</title>

    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

	    <!-- Custom styles for this template -->
    <link href="dist/css/wellness_index.css" rel="stylesheet">
    <link href="dist/css/wellness_admin.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div id="container">
    
    <div class="container">

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
              <li><a href="wellness_admin_overview">Overview</a></li>
              <li><a href="wellness_user_page">My Progress</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>


	<div id="main_content">
    </div>
		<h2>Users Weekly Total Activity</h2>
        <div id="weekly_total_container">
            <table id="tbl_past_wod" rules="cols">
            	<thead>
                	<th>User ID</th>
                    <th>Name</th>
                    <th>Weekly Activity (min)</th>
                 </thead>
                <tbody class="tbl_body_past_wods">
                </tbody>
            </table>
        </div>
        <hr class="featurette-divider">
        <h2>Users Total Activity</h2>
        <div id="total_container">
            <table id="tbl_total_activity" rules="cols">
            	<thead>
                	<th>User ID</th>
                    <th>Name</th>
                    <th>Total Activity (min)</th>
                 </thead>
                <tbody class="tbl_body_total_activity">
                </tbody>
            </table>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
    
    <script>
	$(document).ready(function() {
		getWeeklyTotal();
		getCompleteTotal();
	});
	
	/********************************* GETTER METHODS *********************************/
	
	/*
	* Called when page is finished loading
	* Used to gather the weekly total of 
	* each individual user
	*
	*/
	function getWeeklyTotal()
	{
		var html = "";
		$('.tbl_past_wod').html(html);
		//now load data into table
		$.ajax(
		{ 
		  type:"POST",                                     
		  url:"wellness_getAdminWeeklyTotals.php",         
		  //data: { "dataString" : <something> }, //insert argumnets here to pass to getAdminWODs
		  dataType: "json",                //data format      
		  success: function(response) //on recieve of reply
		  {
			loadPastWODS(response);
		  },
		  error: function(){
				alert('error loading WeeklyTotal!');
			}
		});
	}
	
	/*
	* Called when page is finished loading
	* Used to gather the complete total of 
	* each individual user
	*
	*/
	function getCompleteTotal()
	{
		var html = "";
		$('.tbl_total_activity').html(html);
		//now load data into table
		$.ajax(
		{ 
		  type:"POST",                                     
		  url:"wellness_getAdminCompleteTotals.php",         
		  //data: { "dataString" : <something> }, //insert argumnets here to pass to getAdminWODs
		  dataType: "json",                //data format      
		  success: function(response) //on recieve of reply
		  {
			loadTotalActivity(response);
		  },
		  error: function(){
				alert('error loading WeeklyTotal!');
			}
		});
		//alert("Past WODs FIN");
	}

/******************************** LOAD TABLES **************************************/

/*
* Called in getPastWODS function.
* Parses the ajax request - JSON - format, and
* places the results in descending order in a table 
* in the appropriate DOM.
*
*/
function loadPastWODS(data_wods)
{
	var t_data = data_wods;
	
	var html_sec1 = "";
	var sec1_classID = "weeklyTotal_sec1_data"; 
	var user_id = "";
	var name = "";
	var weekly_act = "";
	//alert("loadPastWODS PRE-FOR LOOP");
	//alert("DATA: " + data_wods);
	//alert("t_DATA: " + t_data);
	for(var i = 0; i < data_wods.length; i++) {
		user_id = data_wods[i].user_id;
		name = data_wods[i].Name;
		weekly_act = data_wods[i].WeeklyActivity;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+user_id+"</td>";
		html_sec1 += "<td>"+name+"</td>";
		html_sec1 +="<td>"+weekly_act+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	//alert("HTML: " + html);
	$('.tbl_body_past_wods').empty();
	$('.tbl_body_past_wods').html(html_sec1);
	
}

/*
* Called in getPastWODS function.
* Parses the ajax request - JSON - format, and
* places the results in descending order in a table 
* in the appropriate DOM.
*
*/
function loadTotalActivity(data_wods)
{
	var t_data = data_wods;
	
	var html_sec1 = "";
	var sec1_classID = "completeTotal_sec1_data"; 
	var user_id = "";
	var name = "";
	var weekly_act = "";
	//alert("loadPastWODS PRE-FOR LOOP");
	//alert("DATA: " + data_wods);
	//alert("t_DATA: " + t_data);
	for(var i = 0; i < data_wods.length; i++) {
		user_id = data_wods[i].user_id;
		name = data_wods[i].Name;
		weekly_act = data_wods[i].WeeklyActivity;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+user_id+"</td>";
		html_sec1 += "<td>"+name+"</td>";
		html_sec1 +="<td>"+weekly_act+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	//alert("HTML: " + html);
	$('.tbl_body_total_activity').empty();
	$('.tbl_body_total_activity').html(html_sec1);
	
}


	</script>
  </body>
</html>