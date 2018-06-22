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
                $sql = "SELECT COUNT(*) as empNo,MAX(lastUpdated) as last FROM employee WHERE employeeStatus=1;";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $data = mysqli_fetch_array($result);
                    $emp_no = $data['empNo'];
                    $emp_last=$data['last'];
                }
		$sql = "SELECT COUNT(*) as empNo FROM employee_attendance A JOIN employee B ON A.employeeID=B.employeeID WHERE date = '" . date('Y-m-d') . "' AND intime <> '' ";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$pre_no = $data['empNo'];
		}
                $sql = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $data = mysqli_fetch_array($result);
                    $pre_last=$data['last'];
                }
		$sql = "SELECT COUNT(*) as empNo FROM employee_leave WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$leave_no = $data['empNo'];
		}
                $sql = "SELECT MAX(lastUpdated) as last FROM employee_leave";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $data = mysqli_fetch_array($result);
                    $leave_last=$data['last'];
                }
		$sql = "SELECT COUNT(*) as empNo FROM employee_tour WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
				$data = mysqli_fetch_array($result);
				$tour_no = $data['empNo'];
		}
                $sql = "SELECT MAX(lastUpdated) as last FROM employee_tour";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $data = mysqli_fetch_array($result);
                    $tour_last=$data['last'];
                }
                $sql = "SELECT COUNT(*) as cnt FROM employee A JOIN employee_attendance B ON A.employeeID=B.employeeID WHERE TIME_FORMAT(intime,'%H:%i:%s')>TIME_FORMAT('09:01:00','%H:%i:%s') AND date =' " . date('Y-m-d') ."'";
                                $result = mysqli_query($conn,$sql);
                                $row = mysqli_fetch_array($result);
                                $late_no = $row['cnt'];
                $sql = "SELECT COUNT(*) as cnt FROM employee A JOIN employee_attendance B ON A.employeeID=B.employeeID WHERE TIME_FORMAT(outtime,'%H:%i:%s')<TIME_FORMAT('17:30:00','%H:%i:%s') AND date =' " . date('Y-m-d') ."'";
                                $result = mysqli_query($conn,$sql);
                                $row = mysqli_fetch_array($result);
                                $early_no = $row['cnt'];
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Attendance</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
         <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
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

       ["Absentee",<?php echo $emp_no-($pre_no+$leave_no+$tour_no); ?>, 'color: red' ],
       ["Late Comers",<?php echo $late_no; ?>, 'color: orange' ],
       ["Early Goers",<?php echo $early_no; ?>, 'color: purple' ]
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
                       
                     
                        };
	var options1 = {
	'title':'Attendance Statistics as on ' + today.toDateString() + ' : ',
																				'width':300, 'height':300,
            legend: { position: 'none' },
'width':800,
           
            axes: {
                x: {
											              
                    0: { side: 'bottom', label: 'No Of Staffs'} // Top x-axis.
                 }
                },
		bar: { groupWidth: "90%" }
	};
	<?php
            $areaSql = "SELECT CONVERT(round(REPLACE(intime,':','.'),2),DOUBLE) as X ,count(*) as Y FROM `employee_attendance` WHERE date='".date('Y-m-d')."' AND status<>'A' group by round(REPLACE(intime,':','.'),2)";
            $areaResult= mysqli_query($conn,$areaSql);
            if(mysqli_num_rows($areaResult) > 0) {
                echo 'var data2=google.visualization.arrayToDataTable([["In-Time","No"]';
                while($areaData = mysqli_fetch_array($areaResult)) {
                    echo ',["'.$areaData['X'].'",'.$areaData['Y'].']' ;
                }
                echo ']);';
            }
        ?>										        
        var options2 = {
            title: 'Todays Trend',
            hAxis: {title: 'In-Time',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
	};
       // var chart = new google.visualization.AreaChart(document.getElementById('areachart_div'));
	//chart.draw(data2, options2);
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
				<a href="index.html"><img src="images/logo22.png" alt="LOGO"></a>
			</div>
			<ul id="navigation">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li class="selected">
                                    <a href="attendance.php">Attendance</a>
				</li>
				<li>
					<a href="publications.php">Publications</a>
				</li>
				<li>
					<a href="documents.html">Documents</a>
				</li>
                                <li>
					<a href="social.html">Social Media</a>
				</li>
                                <li>
					<a href="logout.php">Log Out</a>
				</li>
			</ul>
		</div>
	</div>
	<div id="contents" style="height: auto;">
		<div class="wrapper clearfix">
			<!--<div id="sidebar">
				<ul>

				</ul>

			</div>-->
                        <div class="main" style="height: auto;">
				<h1> Today's Attendance</h1>
				<div id="columnchart_values" style="width: 60%; height: 300px;float:left;display:inline-block;"></div>
				<div id="chart_div" style="width: 40%; height: 300px;float:center;display:inline-block;"></div>
				<!--<div id="areachart_div" style="width: 400px; height: 300px;float:right;display:inline-block;"></div>-->
                                <div   id="footer" style="height: 50px;color: black;">
                                    <h3>Today's Attendance Summary</h3></div>
                    <table class="attendance" style="width: 645px;color: black;width: 100%;">
                        <tr style="background-color:   #F9CFAE;">
                            <td>Total Employees</td><td><?php echo $emp_no; ?></td><td colspan="2">Last Updated On : <?php echo $emp_last; ?></td>
                            
                        </tr>
                        <tr style="background-color:   #B6F9AE;">
                            <td>Employees Present</td><td><?php echo $pre_no; ?></td><td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=attendance&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #F98A9D;">
                            <td>Employees Absent</td><td><?php echo ($emp_no-($pre_no+$leave_no+$tour_no)); ?></td><td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=absentee&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #9A95C3;">
                            <td>Employee(s) on Leave</td><td><?php echo $leave_no; ?></td><td>Last Updated On : <?php echo $leave_last; ?></td>
                            <td><a href="rptToday.php?report=leave&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #E0E472;">
                            <td>Employee(s) on Tour</td><td><?php echo $tour_no; ?></td>
                            <td>Last Updated On : <?php echo $tour_last; ?></td>
                            <td><a href="rptToday.php?report=tour&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #FFB4FA;">
                           <td>Late Comers</td><td><?php echo $late_no; ?></td>
                            <td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=late&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #C8F3F0;">
                            <td>Early Goers</td><td><?php echo $early_no; ?></td>
                            <td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=early&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                    </table>
                
                 <div class="content_box" style="padding-bottom: 0px;padding-left: 2px;">
                <div class="card mb-3" style="box-sizing: border-box;">
        <div class="card-header" style="box-sizing: border-box;background-color: blueviolet;color: #fff;font-size: 18;">
            <i class="fa fa-table" style="box-sizing: border-box;"></i> Today's Attendance List</div>
        <div class="card-body" style="box-sizing: border-box;">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="box-sizing: border-box;color: white;">
                <thead style="background-color: yellowgreen;height: 30px;">
                <tr>
                  <th>Name</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>  
                 <!-- <th>Status</th>-->
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tfoot style="background-color: yellowgreen;">
                <tr>
                  <th>Name</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>
                <!--  <th>Open/Closed</th>-->
                  <th>Status</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php
                    $_SESSION['start'] =  date('Y-m-d');
                    $_SESSION['end'] =  date('Y-m-d');
                    $sql = "SELECT A.employeeID as empID,A.employeeCode,employeeName,divisionName,designation,B.intime,"
                            . "B.outtime,leaveType,G.shortname,place, H.outtime as gateout, H.intime as gatein,B.status,open_closed_status,TIME_FORMAT(B.outtime,'%H:%i:%s')-TIME_FORMAT(B.intime,'%H:%i:%s') as timediff   FROM employee A JOIN employee_attendance B ON A.employeeID = B.employeeID JOIN division C on "
                            . "A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID LEFT JOIN gate_register H ON A.employeeCode = H.employeeCode "
                            . " AND H.date = '" . date('Y-m-d') . "' AND H.outtime <> '' LEFT JOIN employee_tour F ON A.employeeCode = F.employeeCode AND "
                            . "F.startDate <= '" . date('Y-m-d') . "' AND F.endDate >= '" .  date('Y-m-d') . "' LEFT JOIN employee_leave E ON A.employeeCode  = E.employeeCode"
                            . " AND E.startDate <= '" . date('Y-m-d') . "' AND E.endDate >= ' " . date('Y-m-d') . "' LEFT JOIN leave_type G ON E.leaveTypeID = G.leaveTypeID WHERE A.employeeStatus=1 AND b.date ='" . date('Y-m-d') . "';";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<tr><td style='color:red;'>". $row['employeeName'] . "</td>";
                           echo "<td>" . $row['intime'] . "</td><td>" . $row['outtime'] . "</td>";
                           echo "<td>" . $row['shortname'] . "</td><td>" . $row['place'] . "</td><td align='center'>" . $row['gateout'] . " - " . $row['gatein'] . "</td><td >" ; 
                                  //$row['open_closed_status']. "</td><td >";
                           if($row['status'] == 'A')
                           {
                               if($row['leaveType'] != '')
                                   echo "<span style='color:blue;'>L</span>";
                               else if($row['place'] != '')
                                   echo "<span style='color:orange;'>T</span>";
                               else 
                                   echo "<span style='color:red;'>A</span>";
                           }
                           else {
                               if($row['gateout'] !== null && $row['gatein'] == null)
                                   echo "<span style='color:red;'>A</span>";
                               else if($row['outtime'] != '' && $row['leaveType'] != '')
                                   echo "<span style='color:purple;'>HL</span>";
                               else if($row['outtime'] != '' && $row['leaveType'] == '') {
                                   if($row['timediff']<4)
                                        echo "<span style='color:red;'>A</span>";
                                   else if($row['timediff']<6)
                                        echo "<span style='color:orange;'>HD</span>";
                                    else {
                                        echo "<span style='color:green;'>P</span>";
                                    }
                               }
                               else
                                   echo "<span style='color:green;'>P</span>";
                           }
                           echo "</td></tr>";
                        }
                        
                    }
                ?>
              </tbody>
            </table>
          </div>
            <div><span style='color:green;'>P - Present; </span>&nbsp;<span style='color:red;'> A - Absent; </span>&nbsp;<span style='color:orange;'> HD - Half Day; </span>&nbsp;
                <span style='color:blue;'> L - Leave; </span>&nbsp;<span style='color:purple;'> HL - Half Day Leave; </span>&nbsp;<span style='color:orange;'> T - Tour </span></div>
        </div>
                    
      </div>
          </div>
          </div>
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
        <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script> 
</body>
</html>
