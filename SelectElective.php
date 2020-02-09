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
    <title>MREC|Select Elective </title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
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

  $conn = new mysqli('localhost','root','',$_SESSION["hod_department"]);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>

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
                        <h4><strong>Department:   <?php echo $_SESSION["hod_department"];?></strong></h4>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="     false">
                            <img class="user-avatar rounded-circle" src="images/profile1.png" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>
                            <a class="nav-link" href="index.php"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
<div class='container' id="selele">
  
<form  method="POST" action="AssignElective.php" onsubmit="return validate()">
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
<div class="form-group" id="year1_elective" style="display:none">
  <label for="year1_elective_info">Select Elective:</label>
<?php
  $sql="select `subject_name`,`subject_type` from year1_subject_info where `subject_type`='P' or `subject_type`='O'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<label for='year1_elective_info'>Select Elective:</label>";
    echo "<select class='form-control' id='year1_elective_info' name='year1_elective_info'>";
    while($row = $result->fetch_assoc()) {
      echo "<option value='".$row["subject_name"].",".$row["subject_type"]."'>".$row["subject_name"]."</option>";
    }
    echo "</select>";
  } else {
    echo "<h4>No Electives found for First Year</h4>";
  }
?>
</div>
<div class="form-group" id="year2_elective" style="display:none">
<?php
  $sql="select `subject_name`,`subject_type` from year2_subject_info where `subject_type`='P' or `subject_type`='O'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<label for='year2_elective_info'>Select Elective:</label>";
    echo "<select class='form-control' id='year2_elective_info' name='year2_elective_info'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='".$row["subject_name"].",".$row["subject_type"]."'>".$row["subject_name"]."</option>";
    }
    echo "</select>";
  } else {
    echo "<h4>No Electives found for Second Year</h4>";
  }
?>
</div>
<div class="form-group" id="year3_elective" style="display:none">
<?php
 
  $sql="select `subject_name`,`subject_type` from year3_subject_info where `subject_type`='P' or `subject_type`='O'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<label for='year3_elective_info'>Select Elective:</label>";
    echo "<select class='form-control' id='year3_elective_info' name='year3_elective_info'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='".$row["subject_name"].",".$row["subject_type"]."'>".$row["subject_name"]."</option>";
    }
    echo "</select>";
  } else {
    echo "<h4>No Electives found for First Year</h4>";
  }
?>
</div>
<div class="form-group" id="year4_elective" style="display:none">
<?php
  $sql="select `subject_name`,`subject_type` from year4_subject_info where `subject_type`='P' or `subject_type`='O'";
  
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<label for='year4_elective_info'>Select Elective:</label>";
    echo "<select class='form-control' id='year4_elective_info' name='year4_elective_info'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='".$row["subject_name"].",".$row["subject_type"]."'>".$row["subject_name"]."</option>";
    }
    echo "</select>";
  } else {
    echo "<h4>No electives found for Fourth Year</h4>";
  }
?>
</div>
<button type="submit" name="submit" class="btn btn-primary">Get Student Data</button>
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

</html>

<?php
}
?>
<script>
  function changeDisplay(){
    var year=document.getElementById("year").value;
    var div_id_to_be_shown="year"+year;
    var elective_id_to_be_shown="year"+year+"_elective";
    document.getElementById("year1").style.display="none";
    document.getElementById("year2").style.display="none";
    document.getElementById("year3").style.display="none";
    document.getElementById("year4").style.display="none";
    document.getElementById("year1_elective").style.display="none";
    document.getElementById("year2_elective").style.display="none";
    document.getElementById("year3_elective").style.display="none";
    document.getElementById("year4_elective").style.display="none";
    document.getElementById(div_id_to_be_shown).style.display="block";
    document.getElementById(elective_id_to_be_shown).style.display="block";
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