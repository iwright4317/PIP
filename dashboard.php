<html>
  <head>
    
	<?php
	include ('./includes/js_css.inc');
	?>	
	<script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the controls package.
      google.charts.load('current', {'packages':['corechart', 'controls']});
      google.charts.load('current', {'packages':['gauge']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawDashboard);
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates a dashboard, a range slider and a pie chart,
      // passes in the data and draws it.
      function drawDashboard() {

        var result = $.ajax({url: "getData.php", dataType:"text", async: false }).responseText;       
    	var data = google.visualization.arrayToDataTable(JSON.parse(result));    	

        // Create a dashboard.
        var dashboard = new google.visualization.Dashboard(
            document.getElementById('dashboard_div'));

        // Create a range slider, passing some options
        var donutRangeSlider = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'filter_div',
          'options': {
            'filterColumnLabel': 'Work'
          }
        });

        // Create a pie chart, passing some options
        var pieChart = new google.visualization.ChartWrapper({
          'chartType': 'PieChart',
          'containerId': 'chart_div',
          'options': {
            'width': 580,
            'height': 300,
            'pieSliceText': 'value',
            'chartArea.left' : 5,
            'chartArea.width' : 500,
            'legend': 'right'
          }
        });        
                
        var result = $.ajax({url: "getDataG.php", dataType:"text", async: false }).responseText;       
    	var gdata = google.visualization.arrayToDataTable(JSON.parse(result));

        var options = {
          width: 460, height: 200,
          max: 500
        };

        var chart = new google.visualization.Gauge(document.getElementById('gauge_div'));
		chart.draw(gdata, options);
		
		
        var result = $.ajax({url: "getDataST.php", dataType:"text", async: false }).responseText;       
    	var stdata = google.visualization.arrayToDataTable(JSON.parse(result));

        var SToptions = {
          width: 460, height: 200,
          max: 100
        };

        var chartST = new google.visualization.Gauge(document.getElementById('gaugeST_div'));
		chartST.draw(stdata, SToptions);
		
		
		
        var result = $.ajax({url: "getDataST.php?daily=yes", dataType:"text", async: false }).responseText;       
    	var tdata = google.visualization.arrayToDataTable(JSON.parse(result));

        var Toptions = {
          width: 460, height: 200,
          max: 1000
        };

        var chartT = new google.visualization.Gauge(document.getElementById('gaugeT_div'));
		chartT.draw(tdata, Toptions);



		
        var result = $.ajax({url: "getDataToday.php?item=work", dataType:"text", async: false }).responseText;       
    	var todayDataW = google.visualization.arrayToDataTable(JSON.parse(result));

        var TodayOptionsW = {
          width: 153, height: 153,
          max: 50
        };

        var chartT = new google.visualization.Gauge(document.getElementById('gaugeTodayW_div'));
		chartT.draw(todayDataW, TodayOptionsW);
		

		
        var result = $.ajax({url: "getDataToday.php?item=percent", dataType:"text", async: false }).responseText;       
    	var todayDataP = google.visualization.arrayToDataTable(JSON.parse(result));

        var TodayOptionsP = {
          width: 153, height: 153,
          max: 100
        };

        var chartT = new google.visualization.Gauge(document.getElementById('gaugeTodayP_div'));
		chartT.draw(todayDataP, TodayOptionsP);
		

		
        var result = $.ajax({url: "getDataToday.php?item=total", dataType:"text", async: false }).responseText;       
    	var todayDataT = google.visualization.arrayToDataTable(JSON.parse(result));

        var TodayOptionsT = {
          width: 153, height: 153,
          max: 50
        };

        var chartT = new google.visualization.Gauge(document.getElementById('gaugeTodayT_div'));
		chartT.draw(todayDataT, TodayOptionsT);
		
        // Establish dependencies, declaring that 'filter' drives 'pieChart',
        // so that the pie chart will only display entries that are let through
        // given the chosen slider range.
        dashboard.bind(donutRangeSlider, pieChart);

        // Draw the dashboard.
        dashboard.draw(data);
      }
    </script>
  </head>

  <body>
<?php
//include ('./includes/banner.inc');
//echo "<meta http-equiv='refresh' content='120; url=dashboard.php' />";	
?>

<div class="container" style="font-size: normal; background-color: whitesmoke">	
	<div class="row">
		<div class="col-md-12" style="font-size: xx-large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
			PIP - On-line Daily Notifications - Dashboard
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6" style="font-size: normal; ">
			<div class="row">
				<div class="col-sm-12" style="font-size: large; font-weight: normal">
					<b>Activity Today</b> - <?php echo date("Y-m-d H:i:s",strtotime("-4 hours")); ?>
				</div>
			</div>
			<div class="row" style="border-bottom: 1px black solid">
				<div class="col-sm-4" style="font-size: large; ">
					Work via online 
    				<div id="gaugeTodayW_div" style="border-bottom: 1px black solid" ></div>
      			</div>
				<div class="col-sm-4" style="font-size: large; ">	 
					% Permits online 
    				<div id="gaugeTodayP_div" style="border-bottom: 1px black solid" ></div>
      			</div>
				<div class="col-sm-4" style="font-size: large; ">	 
					Total Permits
    				<div id="gaugeTodayT_div" style="border-bottom: 1px black solid" ></div>
      			</div>
      		</div>			
		    <!--Div that will hold the dashboard-->
    		<div id="dashboard_div">
      		<!--Divs that will hold each control and chart-->
      		<div style="font-size:x-Large">On-line work submissions by contractors</div>
      		<div id="filter_div"></div>
      		<div id="chart_div"></div>			
      		</div>
      	</div>		
		<div class="col-sm-6" style="font-size: Large; ">
			<div class="row">
				<div class="col-sm-12" style="font-size: large; font-weight:bold">
					Historical
				</div>
			</div>
      		On-line work submissions per 30-day periods
    		<div id="gauge_div" style="border-bottom: 1px black solid"></div>
      		% Permits Submitted via on-line form
    		<div id="gaugeST_div" style="border-bottom: 1px black solid" ></div>
      		Grand total Daily Notification Permits
    		<div id="gaugeT_div" style="border-bottom: 1px black solid" ></div>
    	</div>
	</div>
  </body>
</html>