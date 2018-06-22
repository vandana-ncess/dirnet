<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Attendance</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
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
					<a href="attendance.php">Attendance</a>
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
			<div id="sidebar">
				<ul>

				</ul>

			</div>
			<div class="main">
				<h1> Today's Attendance</h1>
				<?php

				include("fusioncharts.php");
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
				$columnChart = new FusionCharts("column2d", "ex1", "100%", 400, "chart-1", "json", '{
				                "chart":{
				                  "caption":"",
				                  "subCaption":"Attendance Summary",
				                  "numberPrefix":"$",
				                  "theme":"ocean"
				                },
				                "data":[
				                  {
				                     "label":"Present",
				                     "value":$pre_no;
				                  },
				                  {
				                     "label":"Leave",
				                     "value":$leave_no
				                  },
				                  {
				                     "label":"Tour",
				                     "value":$tour_no
				                  },
				                  {
				                     "label":"Other Absentees",
				                     "value":$emp_no-($pre_no+$leave_no+$tour_no);
				                  }
				                ]
				            }');
				// Render the chart
				$columnChart->render();
				?>
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
