<?php 
    $catID = $_GET['catID'];$str = "";
    if($catID ==7)
        $str = " AND designation LIKE '%project%'";
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT designationID,designation FROM designation WHERE categoryID=IFNULL(". $catID . ",categoryID) AND designationStatus=1" . $str; 
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0) {
       //echo '<select id="ddlDesignation" name="ddlDesignation" style="width: 250px;">
       echo '<option value=0></option>';
        while($data = mysqli_fetch_array($result)){
            echo '<option value=' . $data['designationID'] . '>' . $data['designation'] . '</option>' ;
        }
       // echo '</select>';
    }
?>