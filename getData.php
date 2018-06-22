<?php 
    if(isset($_GET['year'])) $year=$_GET['year'];
    $mode = $_GET['mode'];
    // This is just an example of reading server side data and sending it to the client.
    // It reads a json formatted text file and outputs it.
    $conn = require_once('databaseconnection.php');
    $rows = array(); $rows1 = array();
    $table = array();$table1 = array();
     /*$sql = "SELECT sum(case when researchArea = 1 AND category=1 then 1 else 0 end) as crpsci , sum(case when researchArea = 2 then 1 else 0 end) as cop, "
                        . "sum(case when researchArea = 3 then 1 else 0 end) as hyp ,sum(case when researchArea = 4 then 1 else 0 end) as atp "
                        . "FROM rep WHERE  year=".$year." GROUP BY year";*/
    if($mode == 'year') {
        $sql = "SELECT sum(case when researchArea = 1 AND category=1 then 1 else 0 end) as crpsci ,sum(case when researchArea = 1 AND category=2 then 1 else 0 end) as crpnon"
                . " , sum(case when researchArea = 2 AND category=1 then 1 else 0 end) as copsci,sum(case when researchArea = 2 AND category=2 then 1 else 0 end) as copnon, "
                        . "sum(case when researchArea = 3 AND category=1 then 1 else 0 end) as hypsci ,sum(case when researchArea = 3 AND category=2 then 1 else 0 end) as hypnon, "
                . "sum(case when researchArea = 4 AND category=1 then 1 else 0 end) as atpsci,sum(case when researchArea = 4 AND category=2 then 1 else 0 end) as atpnon "
                        . "FROM rep WHERE  year=".$year." GROUP BY year";
        $result=mysqli_query($conn,$sql);
            //fetech all data from json table in associative array format and store in $result variable
        if(mysqli_num_rows($result)>0) {
                    $table['cols'] = array(
                            array('label' => 'Research Area', 'type' => 'string'),
                            array('label' => 'SCI', 'type' => 'number'),
                        array('label' => 'NON-SCI', 'type' => 'number'),
                         //   array('role'=> 'style','type'=> 'string','p' => array('style' => 'color')),
                            array('role'=> 'annotation','type'=> 'string','p' => array('role'=> 'annotation'))
                        );
                     $table1['cols'] = array(
                            array('label' => 'Research Area', 'type' => 'string'),
                            array('label' => 'No of Publications', 'type' => 'number')
                      //  array('label' => 'NON-SCI', 'type' => 'number'),
                         //   array('role'=> 'style','type'=> 'string','p' => array('style' => 'color')),
                          //  array('role'=> 'annotation','type'=> 'string','p' => array('role'=> 'annotation'))
                        );

                    $row = mysqli_fetch_assoc($result);
                            $temp = array();$temp[] = array('v' => 'CrP'); $temp1 = array();$temp1[] = array('v' => 'CrP');
                            $temp[]=array('v' => (int) $row['crpsci']);
                             $temp[]=array('v' => (int) $row['crpnon']); $temp1[]=array('v' => (int) $row['crpsci']+ (int) $row['crpnon']);
                           // $temp[] = array('v' => 'blue');
                            $temp[]=array('v' => $row['crpsci']);
                            $rows[] = array('c' => $temp); $rows1[] = array('c' => $temp1);
                      $temp = array();$temp[] = array('v' => 'CoP'); $temp1 = array();$temp1[] = array('v' => 'CoP');
                            $temp[]=array('v' =>  (int)$row['copsci']);$temp[]=array('v' =>  (int)$row['copnon']);
                          //  $temp[] = array('v' => 'red');
                            $temp[]=array('v' =>  $row['copsci']);
                            $rows[] = array('c' => $temp);
                      $temp1[]=array('v' => (int) $row['copsci']+(int) $row['copnon']); $rows1[] = array('c' => $temp1);
                       $temp = array();$temp[] = array('v' => 'HyP');  $temp1 = array();$temp1[] = array('v' => 'HyP');
                            $temp[]=array('v' => (int) $row['hypsci']);$temp[]=array('v' => (int) $row['hypnon']);
                           // $temp[] = array('v' => 'orange')
                            $temp[]=array('v' =>  $row['hypsci']);
                            $temp1[]=array('v' => (int) $row['hypsci']+ $row['hypnon']);
                            $rows[] = array('c' => $temp);  $rows1[] = array('c' => $temp1);
                     $temp = array();$temp[] = array('v' => 'AtP');  $temp1 = array();$temp1[] = array('v' => 'AtP');
                            $temp[]=array('v' =>  (int)$row['atpsci']);$temp[]=array('v' =>  (int)$row['atpnon']);
                            //$temp[] = array('v' => 'green');
                            $temp[]=array('v' =>  $row['atpsci']);
                            $temp1[]=array('v' => (int) $row['atpsci']+ $row['atpnon']);
                            $rows[] = array('c' => $temp); $rows1[] = array('c' => $temp1);

                    $table['rows'] = $rows; $table1['rows'] = $rows1;
                    $fileName = "sampleData.json";$fileName1 = "sampleDataPie.json";
                }
    }
    elseif($mode == 'range')
    {
        $sql = "SELECT year,sum(case when researchArea = 1 then 1 else 0 end) as crp , sum(case when researchArea = 2 then 1 else 0 end) as cop, "
                . "sum(case when researchArea = 3 then 1 else 0 end) as hyp ,sum(case when researchArea = 4 then 1 else 0 end) as atp FROM "
                . "rep WHERE year " . $year ." GROUP BY year ";
        echo $sql;
        $result=mysqli_query($conn,$sql);
            //fetech all data from json table in associative array format and store in $result variable
        if(mysqli_num_rows($result)>0) {
                    $table['cols'] = array(
                            array('label' => 'Year', 'type' => 'string'),
                            array('label' => 'CrP', 'type' => 'number'),
                            array('label' => 'CoP', 'type' => 'number'),
                            array('label' => 'HyP', 'type' => 'number'),
                            array('label' => 'AtP', 'type' => 'number')
                           // array('role'=> 'style','type'=> 'string','p' => array('style' => 'color')),
                           // array('role'=> 'annotation','type'=> 'string','p' => array('role'=> 'annotation'))
                        );

                    while($row = mysqli_fetch_assoc($result)) {
                            $temp = array();$temp[]=array('v' =>  $row['year']);
                            $temp[]=array('v' => (int) $row['crp']);
                           // $temp[] = array('v' => 'blue');$temp[]=array('v' => $row['crp']);
                            //$rows[] = array('c' => $temp);
                           // $temp = array();$temp[] = array('v' => 'CoP');
                            $temp[]=array('v' =>  (int)$row['cop']);
                            //$temp[] = array('v' => 'red');$temp[]=array('v' =>  $row['cop']);$rows[] = array('c' => $temp);
                      
                           // $temp = array();$temp[] = array('v' => 'HyP');
                            $temp[]=array('v' => (int) $row['hyp']);
                            //$temp[] = array('v' => 'orange');$temp[]=array('v' =>  $row['hyp']);$rows[] = array('c' => $temp);
                            //$temp = array();$temp[] = array('v' => 'AtP');
                            $temp[]=array('v' =>  (int)$row['atp']);
                            //$temp[] = array('v' => 'green');$temp[]=array('v' =>  $row['atp']);
                            $rows[] = array('c' => $temp);
                    }
                            

                    $table['rows'] = $rows;
                }
                $fileName = "PubDataForPeriod.json";
    }
   elseif($mode == 'emp') {
        $emp = $_GET['emp'];
        $sql = "SELECT year,sum(case when category = 1 then 1 else 0 end) as sci , sum(case when category = 2 then 1 else 0 end) as nonsci "
                . " FROM research_publications WHERE INSTR(authorIDs, '".$emp."') >0 AND ".$year." GROUP BY year";
        $result=mysqli_query($conn,$sql);
            //fetech all data from json table in associative array format and store in $result variable
        if(mysqli_num_rows($result)>0) {
                    $table['cols'] = array(
                            array('label' => 'Year', 'type' => 'string'),
                            array('label' => 'SCI', 'type' => 'number'),
                            array('label' => 'NON-SCI', 'type' => 'number'),
                       
                           // array('role'=> 'style','type'=> 'string','p' => array('style' => 'color')),
                           // array('role'=> 'annotation','type'=> 'string','p' => array('role'=> 'annotation'))
                        );

                    while($row = mysqli_fetch_assoc($result)) {
                            $temp = array();$temp[]=array('v' =>  $row['year']);
                            $temp[]=array('v' => (int) $row['sci']); $temp[]=array('v' => (int) $row['nonsci']);
                           
                            $rows[] = array('c' => $temp);
                    }
                            

                    $table['rows'] = $rows;
                }
                $fileName = "empPub.json";
    }
    elseif($mode == 'desig') {
        $desID = $_GET['desigID'];
        $sql = "SELECT employeeName, sum(case when category = 1 then 1 else 0 end) as sci , sum(case when category = 2 then 1 else 0 end) as nonsci FROM employee A LEFT JOIN research_publications B ON INSTR(authorIDs, employeeCode) >0 WHERE "
                . "designationID =".$desID . " GROUP BY employeeName";
        $result=mysqli_query($conn,$sql);
            //fetech all data from json table in associative array format and store in $result variable
        if(mysqli_num_rows($result)>0) {
                    $table['cols'] = array(
                            array('label' => 'Employee', 'type' => 'string'),
                            array('label' => 'SCI', 'type' => 'number'),
                            array('label' => 'NON-SCI', 'type' => 'number'),
                       
                           // array('role'=> 'style','type'=> 'string','p' => array('style' => 'color')),
                           // array('role'=> 'annotation','type'=> 'string','p' => array('role'=> 'annotation'))
                        );

                    while($row = mysqli_fetch_assoc($result)) {
                            $temp = array();$temp[]=array('v' =>  $row['employeeName']);
                            $temp[]=array('v' => (int) $row['sci']); $temp[]=array('v' => (int) $row['nonsci']);
                           
                            $rows[] = array('c' => $temp);
                    }
                            

                    $table['rows'] = $rows;
                }
                $fileName = "empComparisonPub.json";
    }
//Now encode PHP array in JSON string 
$json=json_encode($table,true);
if($mode == 'year') {
    $json1=json_encode($table1,true);
    var_dump($json1);
    $fo1=fopen($fileName1,"w");
    $fr1=fwrite($fo1,$json1);
}
 
//test the json string
var_dump($json);
 
//create file if not exists
$fo=fopen($fileName,"w");
 
//write the json string in file
$fr=fwrite($fo,$json);

?>
