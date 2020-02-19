<?php
session_start();
$count=0;
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
else 
if($_POST){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $number_of_sections=0;
  $dbname = $_SESSION["hod_department"];
  //To get data of no.of sections
  $conn = new mysqli($servername, $username, $password, "authority");
  $sql="select year".$_SESSION["year"]." from department_info where department_name='".$_SESSION["hod_department"]."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $number_of_sections=$row["year".$_SESSION["year"]];
    }
  }
  //To update no.of hours per day in authority database
  $sql="UPDATE `department_info` SET `number_of_hours_per_day` = '".$_SESSION["number_of_hours"]."' WHERE `department_info`.`department_name` = '".$_SESSION["hod_department"]."'; ";
  if ($conn->query($sql) === TRUE) {
   //later
  } 
  else {
    echo "Error updating record: " . $conn->error;
  }
  //updation of no.of hours per day in authority database ended
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //create table year?_daily_attendance
  $tablename="year".$_SESSION["year"]."_daily_attendance";
  deleteTable($tablename,$conn);
  $sql="create table $tablename(`student_id` varchar(30),`student_name` varchar(320),`student_section` varchar(20),`date` date";
  for($i=1;$i<=$_SESSION["number_of_hours"];$i++){
    $columnname="hour".$i;
    $sql=$sql.",`$columnname` int DEFAULT 0";
  }
  $sql=$sql.",UNIQUE (student_id,date));";
  if ($conn->query($sql) === TRUE) {
      //later
  } 
  else {
      echo "Error creating table: " . $conn->error;
  }
  //creating table year?_hourwise ended

  //create table year?_hourwise
  $tablename="year".$_SESSION["year"]."_hourwise";
  deleteTable($tablename,$conn);
  $sql="create table $tablename (`hour_year` int,`hour_section` varchar(20),`hour` int,`hour_subject` varchar(320),`subject_type` varchar(10),`date` date,`hour_count` varchar(40),PRIMARY KEY(`hour_year`,`hour_section`,`hour`,`date`))";
  if ($conn->query($sql) === TRUE) {
      //later
  } 
  else {
      echo "Error creating table: " . $conn->error;
  }
  //creating table year?_hourwise ended
  //create table year?_subject_info
  $tablename="year".$_SESSION["year"]."_subject_info";
  deleteTable($tablename,$conn);
  $sql="create table $tablename (`subject_id` int AUTO_INCREMENT,`subject_name` varchar(320),`subject_type` varchar(20),`number_of_hours_assigned` int";
  for($i=65;$i<(65+$number_of_sections);$i++)
  $sql.=",`".chr($i)."` int default 0";
  $sql.=",PRIMARY KEY(subject_id),UNIQUE(subject_name))";
  if ($conn->query($sql) === TRUE) {
      //later
  } 
  else {
      echo "Error creating table: " . $conn->error;
  }
   //creating table year?_subject_info ended
   //creating table year?_total_attendance 
  $tablename="year".$_SESSION["year"]."_total_attendance";
  deleteTable($tablename,$conn);
  $sql="create table $tablename (`student_id` varchar(50) PRIMARY KEY,`student_name` varchar(320),`student_section` varchar(10)";
  for($i=1;$i<=$_SESSION["number_of_core_subjects"];$i++)//To insert Core subjects data
    $sql.=",`".$_POST["Core_Subject".$i]."` int default 0";

  if($_SESSION["number_of_labs"]>0)//To insert Labs data
  for($i=1;$i<=$_SESSION["number_of_labs"];$i++)
    $sql.=",`".$_POST["Lab".$i]."` int default 0";

  if($_SESSION["number_of_other_subjects"]>0)//To insert other subjects data
    for($i=1;$i<=$_SESSION["number_of_other_subjects"];$i++)
      $sql.=",`".$_POST["Other_Subject".$i]."` int default 0";

  if($_SESSION["number_of_professional_electives"]>0)
    for($i=1;$i<=$_SESSION["number_of_professional_electives"];$i++)
      $sql.=",`".$_POST["Professional_Elective".$i]."` int default -1";
    
  if($_SESSION["number_of_open_electives"]>0)
    for($i=1;$i<=$_SESSION["number_of_open_electives"];$i++)
      $sql.=",`".$_POST["Open_Elective".$i]."` int default -1";
  
  $sql.=");";
  if ($conn->query($sql) === TRUE) {
    //later
  } 
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  //Insert into year?_subject_info
  $tablename="year".$_SESSION["year"]."_subject_info";
  $sql="";
  for($i=1;$i<=$_SESSION["number_of_core_subjects"];$i++)//To insert Core subjects data
    $sql.="insert into $tablename(`subject_name`,`subject_type`,`number_of_hours_assigned`) values('".$_POST["Core_Subject".$i]."','C','1');";

  if($_SESSION["number_of_labs"]>0)//To insert Labs data
  for($i=1;$i<=$_SESSION["number_of_labs"];$i++)
    $sql.="insert into $tablename(`subject_name`,`subject_type`,`number_of_hours_assigned`) values('".$_POST["Lab".$i]."','L','3');";

  if($_SESSION["number_of_professional_electives"]>0)//To insert Pofessional Electives data
    for($i=1;$i<=$_SESSION["number_of_professional_electives"];$i++)
      $sql.="insert into $tablename(`subject_name`,`subject_type`,`number_of_hours_assigned`) values('".$_POST["Professional_Elective".$i]."','P','".$_POST["number_of_hours_for_professional_elective"]."');";
  
  if($_SESSION["number_of_open_electives"]>0)//To insert Open electives data
    for($i=1;$i<=$_SESSION["number_of_open_electives"];$i++)
      $sql.="insert into $tablename(`subject_name`,`subject_type`,`number_of_hours_assigned`) values('".$_POST["Open_Elective".$i]."','O','".$_POST["number_of_hours_for_open_elective"]."');";

  if($_SESSION["number_of_other_subjects"]>0)//To insert other subjects data
    for($i=1;$i<=$_SESSION["number_of_other_subjects"];$i++)
      $sql.="insert into $tablename(`subject_name`,`subject_type`,`number_of_hours_assigned`) values('".$_POST["Other_Subject".$i]."','N','".$_POST["number_of_hours_for_Other_Subject".$i]."');";
  if ($conn->multi_query($sql) === TRUE) {
    //later
  } 
  else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  //Insert into year?_subject_info ended..

  
}

function deleteTable($tablename,$conn)
{
  $sql = "DROP TABLE IF EXISTS $tablename;";  //This is useful as we need to update for every semester
  if ($conn->query($sql) === TRUE);
  else 
  {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC|Update Subjects </title>
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
                            <a class="nav-link" href="index.php"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
<div class="container">
  <div class="alert alert-success">
    <strong>Subjects Data Recorded.</strong>If you dont see all the subjects here try updating <a href="Subjects.php" class="alert-link">here</a>.
  </div>
<?php
  $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
  $tablename="year".$_SESSION["year"]."_subject_info";
  $sql="select `subject_name`,`number_of_hours_assigned` from $tablename";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $i=1;
    echo "<div class='container'><table class='table table-bordered'><thead><tr><th>S.No</th><th>Subject Name</th><th>No.of Hours</th></tr></thead><tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".($i++)."</td>";
        echo "<td>".$row["subject_name"]."</td>";
        echo "<td>".$row["number_of_hours_assigned"]."</td>";
        echo "</tr>";
    }
    echo "<tbody></tr></table>";
  } else {
    echo "0 results";
  }
  $conn->close();
?>
</div>  



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

