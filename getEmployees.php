<?php 
    $search = $_GET['string'];
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT * FROM employee WHERE employeeName LIKE '%" . $search . "%'"; 
    $result = mysqli_query($conn,$sql);
    $empData = array();
    if(mysqli_num_rows($result)>0) {
        while($row = mysqli_fetch_array($result)){
            $data['id'] = $row['employeeCode'];
            $data['value'] = $row['employeeName'];
            array_push($empData, $data);
        }
    }
    echo json_encode($empData);
?>