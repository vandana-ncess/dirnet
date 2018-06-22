<?php

		// Create the chart - Column 2D Chart with data given in constructor parameter
		// Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
		$conn = require_once('databaseconnection.php');
		
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Documents</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
</head>
<body>
	<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.html"><img src="images/logo.png" alt="LOGO"></a>
				<a href="index.html"><img src="images/logo22.png" alt="LOGO"></a>
			</div>
			<ul id="navigation">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
                                    <a href="attendance.php">Attendance</a>
				</li>
				<li>
					<a href="publications.php">Publications</a>
				</li>
				<li class="selected">
					<a href="documents.html">Documents</a>
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
								<a href="https://twitter.com/hashtag/ESSO-NCESS" target="_blank">Twitter</a>
							</li>
							<li>
								<a href="https://www.facebook.com/ESSO.NCESS/" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="https://www.youtube.com/channel/UCAbCDyOAbBV2vBMUR3ojpXQ" target="_blank">Youtube</a>
							</li>
						</ul>
					</div>
					<div>
						<h4>Heading placeholder</h4>
						<ul>
							<li>
								<a href="http://ncess.gov.in/" target="_blank">NCESS WebSite</a>
							</li>
							<li>
								<a href="https://ncess.eoffice.gov.in/" target="_blank">eOffice</a>
							</li>
							<li>
								<a href="http://192.168.100.161/NcessIntranet" target="_blank">NCESS INTRANET</a>
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