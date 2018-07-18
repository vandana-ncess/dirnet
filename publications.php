<?php
    $conn = require_once('databaseconnection.php');
    $sql = "SELECT * FROM category where categoryName <>'Administrative Staff'";
    $resultCat= mysqli_query($conn,$sql);
    $resultCat1 = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Publications</title>
	
 <link rel="stylesheet" href="css/bootstrap.min.css" />  
           <script src="js/bootstrap.min.js"></script>  
           <script src="js/jquery.min.js"></script>  
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script>  
 $(document).ready(function(){  
      $('#txtEmp').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"getEmployee.php",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#empList').fadeIn();  
                          $('#empList').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  
           $('#txtEmp').val($(this).text());  
           $('#txtID').val(this.id);
           $('#empList').fadeOut();  
      });  
 });  
 </script>  
 <script type="text/javascript">
     function loadSearch(radio) {
        var modal = document.getElementById('myModal')
       // Get the button that opens the modal
       // Get the <span> element that closes the modal
       var span = document.getElementsByClassName("close")[0];;alert(span);
       // When the user clicks on the button, open the modal 
      if(radio.value == 2)
               modal.style.display = "block";
           else
               modal.style.display = "none";
       // When the user clicks on <span> (x), close the modal
       span.onclick = function() {
           modal.style.display = "none";
       }
       // When the user clicks anywhere outside of the modal, close it
       window.onclick = function(event) {
           if (event.target == modal) {
               modal.style.display = "none";
           }
       }
   }
 </script>
    <script type="text/javascript">
        // Load the Visualization API and the piechart package.
    google.charts.load('46', {'packages':['corechart','bar']});
    
    function loadCharts() {
        loadDesignation('ddlDesig',null);
        loadDesignation('ddlSearDesig',null);
        loadDesignation('ddlDesignation',null);
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(loadGraph);
        document.getElementById('txtEmp').value="Dr. N Purnachandra Rao";
        document.getElementById('txtID').value=1107;
        google.charts.setOnLoadCallback(loadEmployeeGraph);
    }
    function loadGraph() {
        $from = document.getElementById('txtFrom').value;
        $to = document.getElementById('txtTo').value;
        $year = " BETWEEN " + $from + " AND " + $to;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var jsonData = $.ajax({
                url: "getPublications.php",
               data : {file:"PubDataForPeriod"},
                dataType: "json",
                async: false
                }).responseText;
            var options = {title: 'Research Publications for the Period : ' + document.getElementById('txtFrom').value + " - " + document.getElementById('txtTo').value};  
            var options2 = {
        
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        
      }; 
var dataColumn1 = new google.visualization.DataTable(jsonData);
            // Instantiate and draw the chart.
            var chart_div1 = document.getElementById('columnchart_material1');
            var chart = new google.visualization.ColumnChart(chart_div1);
            google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div1.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div1.innerHTML);
                });
            chart.draw(dataColumn1, options);
            var chart_div2 = document.getElementById('columnchart_material2');
                var chart2 = new google.visualization.ColumnChart(chart_div2);
                google.visualization.events.addListener(chart2, 'ready', function () {
                    chart_div2.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div2.innerHTML);
                });

                chart2.draw(dataColumn1, options2);
                
            }
        };
        xmlhttp.open("GET","getData.php?mode=range&year="+$year);
        xmlhttp.send();
    }
    function loadEmployeeGraph() {
        $empID = document.getElementById('txtID').value;
        $year = " year BETWEEN " + document.getElementById('txtFromEmp').value + " AND " + document.getElementById('txtToEmp').value;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var jsonData = $.ajax({
                url: "getPublications.php",
               data : {file:"empPub"},
                dataType: "json",
                async: false
                }).responseText;
                
            var options = {title: 'Research Publications of '+ document.getElementById('txtEmp').value, bars: 'horizontal',isStacked: true,hAxis:  {grldlines: { multiple: 1 }}};  
 
            var dataColumn = new google.visualization.DataTable(jsonData);
            var chart_div =document.getElementById('columnchart_emp');
            // Instantiate and draw the chart.
            var chart = new google.visualization.BarChart(chart_div);
            google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div.innerHTML);
                });
            chart.draw(dataColumn, options);
            }     
        };
        xmlhttp.open("GET","getData.php?mode=emp&year="+$year+"&emp="+$empID);
        xmlhttp.send();
    }
    function loadComaparisonGraph() {
        $desID = document.getElementById('ddlDesignation').value;
       // $year = " year BETWEEN " + document.getElementById('txtFromEmp').value + " AND " + document.getElementById('txtToEmp').value;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var jsonData = $.ajax({
                url: "getPublications.php",
               data : {file:"empComparisonPub"},
                dataType: "json",
                async: false
                }).responseText;
                
            var options = { bars: 'horizontal',isStacked: true,hAxis: { grldlines: { multiple: 1 }}
            };  
 
            var dataColumn = new google.visualization.DataTable(jsonData);
            // Instantiate and draw the chart.
            var chart_div = document.getElementById('compchart_emp')
            var chart = new google.visualization.BarChart(chart_div);
            
            google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div.innerHTML);
                });
            chart.draw(dataColumn, options);
            }     
        };
        xmlhttp.open("GET","getData.php?mode=desig&desigID="+ $desID);
        xmlhttp.send();
    }
    function drawChart() {
     // Set a callback to run when the Google Visualization API is loaded.
       google.charts.setOnLoadCallback(drawChart1);
       $year = document.getElementById('ddlYear').value;
      
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var jsonData = $.ajax({
                url: "getPublications.php",
                data : {file:"sampleData"},
                dataType: "json",
                async: false
                }).responseText;
    
    
                var dataColumn = new  google.visualization.DataTable(jsonData);
                var viewSubTotalVariety = new google.visualization.DataView(dataColumn);
                  viewSubTotalVariety.setColumns([0, 1,2,
                 ]);
                var options = {
                  title: "Research Publication for the Year " + document.getElementById('ddlYear').value,
                 // bars: 'horizontal', // Required for Material Bar Charts.
                //isStacked: true,
               bars: 'horizontal',
                hAxis:  {grldlines: { multiple: 1 }}
                };
                var chart_div=document.getElementById("columnchart_values");
                var chart =  new google.visualization.BarChart(chart_div);
                google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div.innerHTML);
                });
                chart.draw(viewSubTotalVariety, options);
                 
             // var chart = new google.visualization.ColumnChart(document.getElementById("barchart_values"));
              //  chart.draw(viewSubTotalVariety, materialOptions);
            }
           
            
        };
        xmlhttp.open("GET","getData.php?mode=year&year="+$year);
        xmlhttp.send();
      
    }
     function drawChart1() {
     // Set a callback to run when the Google Visualization API is loaded.
    
       $year = document.getElementById('ddlYear').value;
      
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               
    var jsonData1 = $.ajax({
                url: "getPublications.php",
                data : {file:"sampleDataPie"},
                dataType: "json",
                async: false
                }).responseText;
    
                // Create our data table out of JSON data loaded from server.
                var dataPie = new google.visualization.DataTable(jsonData1);
           //     var viewPie = new google.visualization.DataView(dataPie);
//viewPie.setColumns([1,{calc:sum, type:'number', label:'Height in Inches'}]);
                // Instantiate and draw our chart, passing in some options.
                var chart_div = document.getElementById('chart_div')
                var chart = new google.visualization.PieChart(chart_div);
                google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    console.log(chart_div.innerHTML);
                });
                chart.draw(dataPie, {width: 520, height: 300});
               
            }
           
            
        };
        xmlhttp.open("GET","getData.php?mode=year&year="+$year);
        xmlhttp.send();
      
    }
    function loadJSON()
    {
        $year = document.getElementById('ddlYear').value;
       
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            }
        };
        xmlhttp.open("GET","getData.php?mode=year&year="+$year);
        xmlhttp.send();
    }
    function loadDesignation($ddl,$catID) {
        $ddlDes = document.getElementById($ddl);
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $ddlDes.innerHTML = "<select name = '" + $ddl + "' id='"+ $ddl+"' >" +  this.responseText + "</select>"  ;
                loadEmployee();
            }
        };
        xmlhttp.open("GET","getDesignation.php?catID="+$catID);
        xmlhttp.send();
    }
    
    function loadEmployee() {
        $catID = document.getElementById('ddlCat').value;
          $desigID = document.getElementById('ddlDesig').value;
          $str="";
          if($catID>0)
              $str = $str + " AND A.categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND A.designationID=" + $desigID;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlEmp").innerHTML = this.responseText ;
            }
        };
        xmlhttp.open("GET","getEmployee.php?str="+$str);
        xmlhttp.send();
    }
    function loadEmp()
      {alert('hi');
          document.getElementById('btnSave').style.display = "none";
          $catID = document.getElementById('ddlSearCat').value;
          $desigID = document.getElementById('ddlSearDesig').value;
          $divID = document.getElementById('ddlSearDiv').value;
          $empName = document.getElementById('txtSearEmp').value;
          $str = "";
          if($catID>0)
              $str = $str + " AND A.categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND A.designationID=" + $desigID;
          if($divID>=0)
              $str = $str + " AND A.divisionID =" + $divID;
          if($empName != '')
              $str = $str + " AND employeeName like '%" + $empName + "%'";
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('btnSave').style.display = "block";
                document.getElementById("tblEmp").innerHTML = this.responseText ;
               
            }
        };
        xmlhttp.open("GET","getUser.php?str="+$str+"&menuID="+$menuID);
        xmlhttp.send();
      }
    </script>    
    <script>
        autocomplete(document.getElementById("myInput"), employees);
    </script>
</head>
<body onload="loadCharts()">
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
				<li class="selected">
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
			<div class="main">
				<h1> Research Publications</h1>
                               <table style="width: 100%;">
                                    <tr>
                                        <td width="100px"> Select Year
                                            <select name="ddlYear" id="ddlYear" class="form-control" style="width:70px;" onchange="google.charts.setOnLoadCallback(drawChart);">
                                                    <?php
                                                        for($i=date('Y');$i>=1979;$i--) {
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    ?>
                                                </select>  
                                         <!--   <input type="submit" name="btnShowYearWise" value="Show" onclick="" />-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div style="padding-bottom: 10px;width:100%;">
                                                <div id="columnchart_values" style="width: 60%; height: 300px;float: left;"></div>
                                              <!--  <div id="barchart_values" style="width: 30%; height: 300px;float: left;"></div>-->
                                                <div id="chart_div" style="width: 40%; float: right; height: 300px;"></div>
                                            </div>            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table><tr>
                                                <td width="90px">
                                                    Period  From <input type="number" id="txtFrom" class="form-control" name="txtFrom" value="2014"  /></td>
                                                <td width="90px">
                                                    To <input type="number" class="form-control" value="2018" id="txtTo" name="txtTo"  /></td>
                                                <td width="70px" style="vertical-align: bottom;"> 
                                                        <input type="button" name="btnShow" value="Show" class="form-control"  onclick="google.charts.setOnLoadCallback(loadGraph)" /> 
                                                </td></tr></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                             <div id="columnchart_material1" style="width: 60%; height: 400px;float: left;"></div>                
                                            </div>  
                                            <div id="columnchart_material2" style="width: 40%; float: right; height: 400px;"></div>                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Category<select onchange="loadDesignation('ddlDesig',this.value)" class="form-control" name="ddlCat" id="ddlCat" >
                                            <?php
                                                while($data = mysqli_fetch_array($resultCat)) {
                                                    echo '<option value="' . $data['categoryID'] . '">' . $data['categoryName'] .'</option>';
                                                }
                                            ?>
                                            </select></td>
                                            <td width="200px">Designation<select name="ddlDesig" class="form-control" id="ddlDesig"  onchange="loadEmployee()">
                                            
                                            </select></td>
                                            <td  width="200px">Employee<input type="text" name="txtEmp" id="txtEmp" class="form-control"  /> <input type="hidden" name="txtID" id="txtID" /> 
                                             </td>
                                              <td width="60px"> Period From <input type="number" id="txtFromEmp" class="form-control" name="txtFromEmp" class="form-control" value="2014"  /></td>
                                               <td width="60px"> To <input type="number" value="2018" class="form-control" id="txtToEmp" name="txtToEmp"  />
                                            </td>
                                            <td width="60px" style="vertical-align: bottom;" >
                                                <input type="button" name="btnShowEmp" value="Show" class="form-control" style="background-color: activeborder;"  onclick="google.charts.setOnLoadCallback(loadEmployeeGraph)" /> 
                                            
                                           </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" /><td   width="200px"><div id="empList"></div> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                             <div id="columnchart_emp" style="width: 60%; height: 400px;float: left;"></div>                
                                            </div>  
                                              
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="rdoDesig"  value="1" onchange="loadSearch(this)" />Designation wise
                                                    </td>
                                                    <td>
                                                        <select name="ddlDesignaion" id="ddlDesignation" class="form-control" onchange="google.charts.setOnLoadCallback(loadComaparisonGraph)" >
                                                            
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="rdoDesig"   value="2" onchange="loadSearch(this)"/>Custom
                                                    </td>
                                                    <td>
                                                        <input type="text" name="txtName" id="txtName" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >
                                                        <div id="compchart_emp" style="width: 90%; height: 600px;float: left;"></div>                
                                            </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                               
                               
                                
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
        <div id="myModal" class="modal">
  <!-- Modal content -->
            <div class="modal-content">
              <span class="close">&times;</span>
              <p>Select Employees</p>
              <table>
                  <tr>
                      <td>Search</td>
                  </tr>
                  <tr>
                            <td  style="padding-top: 20px;">Division</td>
                            <td style="padding-top: 20px;">
                                <select id="ddlSearDiv" name="ddlSearDiv"  style="width: 300px;"><option value="-1">All</option>
                                    <?php
                                        $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1";
                                        $result = mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0)
                                        {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value=" . $row['divisionID'] . ">" . $row['divisionName'] . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td  style="padding-top: 20px;padding-left: 5px;">Category</td>
                            <td style="padding-top: 20px;">
                                <select id="ddlSearCat" name="ddlSearCat" onchange="loadDesignation('ddlSearDesig',this.value)" style="width: 300px;" ><option value="null">All</option>
                            <?php
                                    while ($row = mysqli_fetch_array($resultCat1)) {
                                        echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                                    }
                                    echo "<script>loadDesignation('ddlSearDesig',document.getElementById('ddlSearCat').value);</script>";
                            ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td >Designation</td>
                            <td>
                                <select id="ddlSearDesig" name="ddlSearDesig" onload="loadDesignation('ddlSearDesig',document.getElementById('ddlSearCat').value)"  style="width: 300px;">
                                </select>
                            </td>
                            <td   style="padding-left: 5px;">Name</td><td colspan="3"><input type="text" name="txtSearEmp" id="txtSearEmp" style="width: 250px;" /> </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right" style="padding: 10px;"><input type="button" name="btnSearch" id="btnSearch" value="Search" onclick="loadEmp()" /></td>
                        </tr>
                        <tr align="right">
			    <td colspan="4" align="left" bgcolor="#424066" height="25px;" style="color: white;" ></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding-top: 10px;"><div style="overflow-y:scroll;max-height: 350px;"> <table id ="tblEmp" style="overflow-x:   scroll;overflow-y: auto;"></table></div></td>
                        </tr>
                    <tr>
                        <td colspan="4" align="right"><input type='submit' name='btnSave' id='btnSave' value='Save' style="display: none;float: right;"  /> </td> 
                    </tr>
                   
              </table>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
    $("#txtName").autocomplete({
        source: "getEmployees.php",
        data : document.getElementById('txtName').value,
        select: function( event, ui ) {
            event.preventDefault();
            $("#txtName").val(ui.item.id);
        }
    });
});
        </script>
</body>
</html>
