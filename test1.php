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
<html>
  <head>
    <!--Load the AJAX API-->
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
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
					["Present",<?php echo $pre_no; ?>],

			["Leave",<?php echo $leave_no; ?> ],
			["Tour",<?php echo $tour_no; ?> ],
			["Absentee",<?php echo $emp_no-($pre_no+$leave_no+$tour_no); ?> ]
        ]);

        // Set chart options
        var options = {'title':'How Much Pizza I Ate Last Night',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>
