<?php
session_start();
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}

?>
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
<body onload="changeDisplay()">
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
                    <h4><strong><?php echo strtoupper($_SESSION["hod_name"]);?></strong> </h4>
                    <h4 id="dp">Department:   <strong><?php echo strtoupper($_SESSION["hod_department"]);?></strong> </h4>
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
<!--content-->
<div class="container" id="chktotatd">
<div class="alert alert-success" role="alert">
  <p>Check Total Attendance <strong><a href='TotalAttendance.php'>here</a></strong>.</p>
</div>
  
  <h5><strong>Check Attendance :</strong></h5><br>
  <form action="monthlyattendence.php" method="POST">
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
 <div class="form-group" id="year1" name="ysection" style="display:none">
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
<div class="form-group" id="year2" name="ysection" style="display:none">
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
<div class="form-group" id="year4"  name ="ysection" style="display:none">
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

    <div class="form-group">
      <label for="from_date">Enter date(From):</label>
      <input type="date" id="from_date" name="fromdate" class="form-control" >
    </div>
    <div class="form-group">
      <label for="to_date">Enter date(To):</label>
      <input type="date" id="to_date" name="todate" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Get Attendance</button>
  </form>
</div>
<!--content-->



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


</html>

