<?php

		// Create the chart - Column 2D Chart with data given in constructor parameter
		// Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
		$conn = require_once('databaseconnection.php');
		$sql = "SELECT COUNT(*) as empNo FROM employee WHERE employeeStatus=1;";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$emp_no = $data['empNo'];
		}
		$sql = "SELECT COUNT(*) as empNo FROM employee_attendance A JOIN employee B ON A.employeeID=B.employeeID WHERE date = '" . date('Y-m-d') . "' AND intime <> '' ";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$pre_no = $data['empNo'];
		}
		$sql = "SELECT COUNT(*) as empNo FROM employee_leave WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$leave_no = $data['empNo'];
		}
		$sql = "SELECT COUNT(*) as empNo FROM employee_tour WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$tour_no = $data['empNo'];
		}
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Attendance</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', '');
        data.addColumn('number', 'No of Staff');
				<?php
					$pieSql = "SELECT timerange,count(timerange) as cnt FROM `employee_attendance` WHERE date='" . date('Y-m-d') ."' AND status<>'A' GROUP BY timerange";
					$pieResult = mysqli_query($conn,$pieSql);
					if(mysqli_num_rows($pieResult) > 0) {
						echo 'data.addRows([';
						while($data=mysqli_fetch_array($pieResult)) {
							echo '["' . $data['timerange'] . '",'. $data['cnt'] . '],';
						}
						echo "]);";
					}
				?>

				var data1 = google.visualization.arrayToDataTable([
         ['Element', 'No of Staff', { role: 'style' }],
         ["Present",<?php echo $pre_no; ?>, 'green'],            // RGB value
         ["Leave",<?php echo $leave_no; ?> , 'blue'],            // English color name
         ["Tour",<?php echo $tour_no; ?>, 'gold'],

       ["Absentee",<?php echo $emp_no-($pre_no+$leave_no+$tour_no); ?>, 'color: red' ], // CSS-style declaration
      ]);
			var view = new google.visualization.DataView(data1);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
        // Set chart options
				var today = new Date();
        var options = {'title':'In-Time Statistics',
                       'width':400,
                       'height':300};
											 var options1 = {
												 'title':'Attendance Statistics as on ' + today.toDateString() + ' : ',
																				'width':400, 'height':300,
											           legend: { position: 'none' },


											           axes: {
											             x: {
											               0: { side: 'bottom', label: 'No Of Staffs'} // Top x-axis.
											             }
											           },
											           bar: { groupWidth: "90%" }
											         };
															 var data = google.visualization.arrayToDataTable([
											           ['Year', 'Sales'],
											           ['2013',  1000],
											           ['2014',  1170],
											           ['2015',  660],
											           ['2016',  1030]
											         ]);

											         var options = {
											           title: 'Company Performance',
											           hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
											           vAxis: {minValue: 0}
											         };

											         var chart = new google.visualization.AreaChart(document.getElementById('areachart_div'));
											         chart.draw(data, options);
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
				var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      	chart.draw(view, options1);
      }
    </script>

</head>
<body>
	<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.html"><img src="images/logo.png" alt="LOGO"></a>
				<a href="index.html"><img src="images/logo2.png" alt="LOGO"></a>
			</div>
			<ul id="navigation">
				<li>
					<a href="index.html">Home</a>
				</li>
				<li class="selected">
					<a href="about.html">Attendance</a>
				</li>
				<li>
					<a href="blog.html">Blog</a>
				</li>
				<li>
					<a href="gallery.html">Gallery</a>
				</li>
				<li>
					<a href="contact.html">Contact Us</a>
				</li>
			</ul>
		</div>
	</div>
	<div id="contents">
		<div class="wrapper clearfix">
			<!--<div id="sidebar">
				<ul>

				</ul>

			</div>-->
			<div class="main">
				<h1> Today's Attendance</h1>
				<div id="columnchart_values" style="width: 400px; height: 300px;float:left;display:inline-block;"></div>
				<div id="chart_div" style="width: 400px; height: 300px;float:center;display:inline-block;"></div>
				<div id="areachart_div" style="width: 400px; height: 300px;float:right;display:inline-block;"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<ul id="featured" class="wrapper clearfix">

		</ul>
		<div class="body">
			<div class="wrapper clearfix">
				<div id="links">
					<div>
						<h4>Social</h4>
						<ul>
							<li>
								<a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank">Google +</a>
							</li>
							<li>
								<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="http://freewebsitetemplates.com/go/youtube/" target="_blank">Youtube</a>
							</li>
						</ul>
					</div>
					<div>
						<h4>Heading placeholder</h4>
						<ul>
							<li>
								<a href="index.html">Link Title 1</a>
							</li>
							<li>
								<a href="index.html">Link Title 2</a>
							</li>
							<li>
								<a href="index.html">Link Title 3</a>
							</li>
						</ul>
					</div>
				</div>
				<div id="newsletter">

				</div>
				<p class="footnote">
					© Copyright © 2023.Company name all rights reserved
				</p>
			</div>
		</div>
	</div>
</body>
</html>
