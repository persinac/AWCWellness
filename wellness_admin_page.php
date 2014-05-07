<?php require_once('Connections/wellnessConn.php'); ?>
<?php 
session_start();
if(isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username'])) {

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
    <title>Overview Page</title>

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
              <li><a href="wellness_index">Home</a></li>
              <li class="active"><a href="#">Overview</a></li>
              <li><a href="wellness_user_page">My Progress</a></li>
			  <li id="logout"><a href="#">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
	
        <div id="weekly_total_container">
		<h2 id="weekly_total_header">Users Weekly Total Activity</h2>
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
        
        
        <div id="total_container">
		<h2 id="total_activity_header">Users Total Activity</h2>
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
		
		<hr class="featurette-divider">
		
		<div id="archives">
			<h3>Past Results</h3>
			<ul>
              <li><a href="#">Week 1</a></li>
              <li><a href="#">Week 2</a></li>
              <li><a href="#">Week 3</a></li>
			  <li><a href="#">Week 4</a></li>
			  <li><a href="#">Week 5</a></li>
              <li><a href="#">Week 6</a></li>
              <li><a href="#">Week 7</a></li>
			  <li><a href="#">Week 8</a></li>
			  <li><a href="#">Week 9</a></li>
              <li><a href="#">Week 10</a></li>
              <li><a href="#">Week 11</a></li>
			  <li><a href="#">Week 12</a></li>
            </ul>
			
		</div>
		<div id="chart_div"></div>
		<div id="activity_chart_div"></div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript"></script>
    <script>
	
	google.load('visualization', '1.0', {'packages':['corechart']});
	$(document).ready(function() {
		getWeeklyTotal();
		getCompleteTotal();
		getWeekNumber();
		//getWeeklyMinutes();
		loadGraphs();
	});
	var week = 0;
	var header = "";
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
	
	/********************************* GETTER METHODS *********************************/
	
	/*
	* Called when page is finished loading
	* Used to gather the weekly total of 
	* each individual user
	*
	*/
	function getWeekNumber()
	{
		var html = "";
		$('.tbl_past_wod').html(html);
		//now load data into table
		$.ajax(
		{ 
		  type:"GET",                                     
		  url:"getWeekNumber.php",         
		  dataType: "text",                //data format      
		  success: function(response) //on recieve of reply
		  {
			html = "Users Week "+response+" activity total";
			//header = html;
			week = response;
			header = "Week " + week + " daily activity level";
			$('#weekly_total_header').empty();
			$('#weekly_total_header').html(html);
			console.log(response);
		  },
		  error: function(){
				alert('error loading WeeklyTotal!');
			}
		});
	}
	
	
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

/********************************* Load and draw graph functions***********************************************/

function loadGraphs()
{
	getWeeklyMinutes();
	seeArray(data_array);
	submitForWeeklyActivityCount(getStartingDate(week));
    //drawChart();
	//drawWeeklyActivityBreakdown();
}
// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawDailyMinutesChart(minutes) {
	// Create the data table.
	var data = new google.visualization.DataTable();

	console.log("Minutes: " +minutes[0]+" "+minutes[1]+
	" "+minutes[2]+" "+minutes[3]+" "
	+minutes[4]+" "+minutes[5]+" "+minutes[6]);
	
	data.addColumn('string', 'Day');
	data.addColumn('number', 'Minutes');
	data.addRows([
	  ['Sunday', parseInt(minutes[0])],
	  ['Monday', parseInt(minutes[1])],
	  ['Tuesday', parseInt(minutes[2])],
	  ['Wednesday', parseInt(minutes[3])],
	  ['Thursday', parseInt(minutes[4])],
	  ['Friday', parseInt(minutes[5])],
	  ['Saturday', parseInt(minutes[6])]
	]);

	// Set chart options
	var options = {'title':header,
				   'width':950,
				   'height':500};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}

function drawWeeklyActivityBreakdown(activities) {
	// Create the data table.
	
	var data = new google.visualization.DataTable();

	console.log("activities: " +activities[0].activity+" "+activities[1].activity+
		" "+activities[2].activity+" "+activities[3].activity+" "+activities[4].activity+
		" ");
	
	data.addColumn('string', 'Day');
	data.addColumn('number', 'Minutes');
	for(var i = 0; i < activities.length; i++) {
		console.log(activities[i].activity +", "+ parseInt(activities[i].activityCount));
		data.addRows([
		  [activities[i].activity, parseInt(activities[i].activityCount)]
		]);
	}

	// Set chart options
	var options = {'title':header,
				   'width':950,
				   'height':500};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('activity_chart_div'));
	
	function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping);
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler); 
	
	chart.draw(data, options);
}

/*******************Functions to handle AJAX data submission for graphs***********************************/

function submitDatesForDailyMinutes(new_date)
{
	$.ajax(
		{ 
		  type:"POST",                                     
		  url:"wellness_getWeeklyMinutes.php",         
		  data: { "dateArray" : new_date }, //insert argumnets here to pass to getAdminWODs
		  dataType: "json",                //data format      
		  success: function(response) //on recieve of reply
		  {
			console.log(response);
			drawDailyMinutesChart(response);
		  },
		  error: function(){
				alert('error loading daily Minutes!');
			}
		});
}

function submitForWeeklyActivityCount(new_date)
{
	console.log("weekly activities");
	$.ajax(
		{ 
		  type:"POST",                                     
		  url:"wellness_getWeeklyActivityCount.php",         
		  data: { "date" : new_date }, //insert argumnets here to pass to getAdminWODs
		  dataType: "json",                //data format      
		  success: function(response) //on recieve of reply
		  {
			console.log(response);
			drawWeeklyActivityBreakdown(response);
		  },
		  error: function(){
				alert('error loading daily Minutes!');
			}
		});
}

/**************************** Utility methods ************************************/


var data_array = new Array();
function getWeeklyMinutes() {
	var startDate = getStartingDate(week);
	var startDay = parseInt(startDate.substring(8, 10));
	var temp = "";
	
	console.log(startDate + ", " + startDate.substring(0, 8) +", startDay:"+startDay+", startDay + 1: "+(startDay+1));
	if(startDay < 10) {
		temp = String(startDay);
		startDay = "0"+temp;
	}
	console.log("new startday: " + startDay);
	var newStartDate = "";
	var count = 0;
	for(var j = 0; j < 7; j++) {
		startDay = parseInt(startDate.substring(8, 10));
		startDay+=j;
		if(startDay < 10) {
			temp = String(startDay);
			startDay = "0"+temp;
		} else {
			temp = String(startDay);
			startDay = temp;
		}
		console.log("new startday: " + startDay);
		newStartDate = startDate.substring(0, 8) + startDay;
		//call function to run the ajax call, pass the new startdate into function
		data_array.push(newStartDate);
		//console.log("submitDate: "+submitDates(newStartDate));		
	}
	submitDatesForDailyMinutes(data_array);
}

function getStartingDate(weeknum)
{
	var startingdate = '2014-05-04';
	if(weeknum == 1) {
		startingdate = '2014-05-04';
	}
	return startingdate;
}
function seeArray(array)
{
	for(var i =0; i< array.length; i++)
	{
		console.log("Array at "+i+" = "+array[i]);
	}
}

	</script>
  </body>
</html>