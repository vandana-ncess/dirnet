<?php 
 /*   $str = $_GET['str'];
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT employeeCode,employeeName FROM employee A JOIN designation B ON A.designationID=B.designationID WHERE employeeStatus=1 " . $str . " ORDER BY level"; 
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0) {
        echo '<select id="ddlEmp" name="ddlEmployee" ><option value=0></option>';
        while($data = mysqli_fetch_array($result)){
            echo '<option value=' . $data['employeeCode'] . '>' . $data['employeeName'] . '</option>' ;
        }
        echo '</select>';
    }*/
?>
<?php
    $output = '';
    $str = $_GET['query'];
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT employeeCode,employeeName FROM employee A JOIN designation B ON A.designationID=B.designationID WHERE employeeStatus=1 AND employeeName LIKE "
            . " '%". $str. "%'  ORDER BY level"; 
    $result = mysqli_query($conn,$sql);

// Generate skills data array
    $output = '<ul class="list-unstyled" style="max-height:200px;">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '<li id="'.$row['employeeCode'].'">'.$row["employeeName"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li>Employee Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
?>