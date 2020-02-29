<?php
session_start();
error_reporting(E_ERROR);
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC </title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="container-fluid " id="jumbotroncon">
             <div class="jumbotron container-fluid text-center" id="jum">
                <div id="jumleft">
                    <img src="logo" alt="logo">
                </div>
                <div >
                    <h2 class="display"><strong>MALLAREDDY ENGINNERING COLLEGE (AUTONOMOUS)</strong></h2>
                  <h6>( An Autonomous institution approved by UGC and Affiliated to JNTUH Hyderabad,</h6>
                  <h6>        Accredited by NAAC with 'A' Grade,Accredited by NBA,    </h6>
                  <h6> Maisammaguda, dhulapally,(Post, via Kompally),Secunderabad-500100 Ph:040-64634234)</h6>
                </div>
                  
             </div>
        </div>
    

    <div>
        <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">MREC</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="HourInput.php">Daily Report</a>
                    </li>
                    <li class="active">
                        <a href="Subjects.php">Subjects</a>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="StaffInfo.php">Staff Info</a></li>
                            <li><a href="StaffKey.php">Staff Key</a></li>
                            <li><a href="AssignStaff.php">Assign Subjects to Staff</a></li>
                            
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Students</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="SelectElective.php">Assign Elective</a></li>
                            <li><a href="StudentUpload.php">Upload Students List</a></li>
                            <li><a href="ChangeStudentData.php">Update Students data</a></li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="checktotalattendence.php">Total Attendence </a>
                    </li>
                     
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->
    
    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="     false">
                            <img class="user-avatar rounded-circle" src="images/profile1.png" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>
                            <a class="nav-link" href="Logout.php"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
<?php
if(!$_POST){
  $conn = new mysqli('localhost','root','','authority');
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $department=$_SESSION["hod_department"];
  $sql = "SELECT year1,year2,year3,year4,number_of_hours_per_day from department_info where department_name='".$department."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $i=0;  
    $row = $result->fetch_assoc();
    $no_of_sections[$i++]= (int)$row["year1"];
    $no_of_sections[$i++]= (int)$row["year2"];
    $no_of_sections[$i++]= (int)$row["year3"];
    $no_of_sections[$i++]= (int)$row["year4"];
    $number_of_hours_per_day=(int)$row['number_of_hours_per_day'];
          
  } 
  else {
      echo "<h4>Department Info is missing.</h4>";
      exit();
  }
?>

<div class='container' id="totad">
    <h5><strong>Department: <?php echo $_SESSION["hod_department"];?></strong></h5><br>
<form  method="POST" onsubmit="return validate()">
<div class="form-group">
    <label for='year'>Select Year :</label>
    <select class="form-control" id='year' name='year' onchange="changeDisplay()">
        <option selected disabled value='0' >Select Year</option>
        <option value='1'>First Year</option>
        <option value='2'>Second Year</option>
        <option value='3'>Third Year</option>
        <option value='4'>Fourth Year</option>
    </select>
 </div>
 <div class="form-group" id="year1" style="display:none">
  <label for="section1">Select Section:</label>
  <select class="form-control" id="section1" name="section1">
    <?php
      for($j=0;$j<$no_of_sections[0];$j++){ 
        $section=chr(65+$j);
        echo "<option value='$section'>$section</option>";
      }
    ?>
  </select>
</div> 
<div class="form-group" id="year2" style="display:none">
  <label for="section2">Select Section:</label>
  <select class="form-control" id="section2" name="section2">
    <?php
      for($j=0;$j<$no_of_sections[1];$j++){ 
        $section=chr(65+$j);
        echo "<option value='$section'>$section</option>";
      }
    ?>
  </select>
</div>
<div class="form-group" id="year3" style="display:none">
  <label for="section3">Select Section:</label>
  <select class="form-control" id="section3" name="section3">
    <?php
      for($j=0;$j<$no_of_sections[2];$j++){ 
        $section=chr(65+$j);
        echo "<option value='$section'>$section</option>";
      }
    ?>
  </select>
</div>
<div class="form-group" id="year4" style="display:none">
  <label for="section4">Select Section:</label>
  <select class="form-control" id="section4" name="section4">
    <?php
      for($j=0;$j<$no_of_sections[3];$j++){ 
        $section=chr(65+$j);
        echo "<option value='$section'>$section</option>";
      }
    ?>
  </select>
</div>
<button type="submit" class="btn btn-primary">Get Report</button>
</form></div>

</div>
</div><!-- .content -->
    </div><!-- /#right-panel -->
    </div>
    <!-- Left Panel -->
    <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>
<script>
  function changeDisplay(){
    var year=document.getElementById("year").value;
    var div_id_to_be_shown="year"+year;
    document.getElementById("year1").style.display="none";
    document.getElementById("year2").style.display="none";
    document.getElementById("year3").style.display="none";
    document.getElementById("year4").style.display="none";
    document.getElementById(div_id_to_be_shown).style.display="block";
  }
  function validate(){
    var year=document.getElementById("year").value;
    if(year==0){
      window.alert("Please Select a Year");
      return  false;
    }
    return true;
  }
</script>
<?php
}
?>
<?php

if($_POST){
  static $content = '';
$content .= '
<div>
<img src="mrec.jpeg" alt="logo" height="150" width="700">
</div>
';

  $year=$_POST["year"];
  $section=$_POST["section".$year];
  $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  ?>
  
  <?php
  $tablename="year".$year."_subject_info";
  $sql = "SELECT subject_name,subject_type,$section FROM $tablename ORDER BY subject_type";
  $result = $conn->query($sql);
  $tablename="year".$year."_total_attendance";
  $sql="select student_id,student_name";
  if ($result->num_rows > 0) {
    echo "<div class='container' id='totp2'><h4>Department: ".$_SESSION["hod_department"]." Date:".date("d-m-Y")."</h4>";
    $content .= '<h4>Department: '.$_SESSION["hod_department"].' Date:'.date("d-m-Y").'</h4>';
    echo "<h4>Year: $year Section:$section</h4>";
    $content .= '<h4>Year:'.$year.' Section:'.$section.'</h4>';
    echo "<div class='table-responsive'><table class='table table-bordered table-hover'><thead><tr><th>S.NO</th><th>HT.NO</th><th>Student Name</th>";
    $content .= '<table border="1" cellspacing="0" cellpadding="3" ><tr><th width="4%">S.NO</th><th width="10%">HT.NO</th><th width="15%" >Student Name</th>';
    $i=0;
    $total=0;
    $flag1=0; //PE
    $flag2=0; //OE
    while($row = $result->fetch_assoc()) {
        echo "<th>".$row["subject_name"]."</th>";
        $content .= '<th width="5%">'.$row["subject_name"].'</th>';
        $subject_name[$i]=$row["subject_name"];
        $number_of_classes_held[$i++]=(int)$row[$section];
        $total+=(int)$row[$section];
        if($flag1==1 && $row["subject_type"]=='P')
          $total-=(int)$row[$section];
        if($flag2==2 && $row["subject_type"]=='O')
          $total-=(int)$row[$section];
        if($row["subject_type"]=='P'){
          $flag1=1;
        }
        if($row["subject_type"]=='O'){
          $flag2=1;
        }
        $sql.=",`".$row["subject_name"]."`";
    }
  } else {
      echo "<div class='container'><h4>Year:$year data not found.</h4>";
      echo "<p>Please Select Another year <a href='TotalAttendance.php'>Here.</a>";
      exit();
  }
  echo "<th>Total</th><th rowspan='2'>%</th></tr><tr><th colspan='3'>Number of Classes Held</th>";
  $content .= '<th>Total</th><th rowspan="2">%</th></tr><tr><th colspan="3">Number of Classes Held</th>';
  for($i=0;$i<count($number_of_classes_held);$i++)
  {
    echo "<th>".$number_of_classes_held[$i]."</th>";
    $content .= '<th>'.$number_of_classes_held[$i].'</th>';
  }
  echo "<th>$total</th></tr></thead>";
  $content .= '<th>'.$total.'</th></tr>';
  $sql.=" from $tablename where student_section='$section'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $serial_number=1;
    while($row = $result->fetch_assoc()) {
      $temp1=0; //to store the total hours of students;
      $j=0;
      $content .= '<tr><td>'.$serial_number.'</td><td>'.$row["student_id"].'</td><td>'.$row["student_name"].'</td>';
      echo "<tr><td>".($serial_number++)."</td><td>".$row["student_id"]."</td><td>".$row["student_name"]."</td>";
      
      for($i=0;$i<count($subject_name);$i++){
        if($row[$subject_name[$i]]==-1){
          echo "<td>-</td>";
          $content .= '<td>-</td>';
        }
        else{
          echo "<td>".$row[$subject_name[$i]]."</td>";
          $content .= '<td>'.$row[$subject_name[$i]].'</td>';
          $temp1+=(int)$row[$subject_name[$i]];
        }
        $j++;
      }
      if($total==0)
      {
        echo "<td>$temp1</td><td>0.00</td></tr>";
        $content .= '<td>'.$temp1.'</td><td>0.00</td></tr>';
      }
      else
      {
        echo "<td>$temp1</td><td>".sprintf('%0.2f', ($temp1/$total)*100)."</td></tr>"; 
        $content .= '<td>'.$temp1.'</td><td>'.sprintf("%0.2f", ($temp1/$total)*100).'</td></tr>';
      }
    }
  } else {
    echo "<h4>Year:$year data not found.</h4>";
    exit();
  }
  echo "<tbody></table></div>";
  $content .= '</table>';
  ?>
  <div class="col-md-12" align="right">
<form  action="ppdfgen.php" method="post" target="_blank"> 
<input type='hidden' value='<?php echo $content ?>' name='conte'/>

<input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
</form>  

</div>
  <?php
  function pdf(){
    return $content;
  }

}
?>

</html>