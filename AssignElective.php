<?php
session_start();
error_reporting(E_ERROR);
if( !isset($_SESSION["hod_department"]) ){
    header("location:HODLogin.php");
    exit();
}
else 
if(isset($_POST["submit"])){
  $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
  $year=$_POST["year"];
  $tablename="year".$year."_subject_info";
  $sql = "SELECT `subject_name`,`subject_type` FROM $tablename where `subject_type`='P' or `subject_type`='O'";
  $result=$conn->query($sql);
  if ($result->num_rows > 0) {
  }
  else {
    echo "<div class='container'><h4>No electives found</h4>";
    echo "<a href='SelectElective.php'>Back To Assign Page</a>";
    exit();
  }
  $section=$_POST["section".$year];
  $_SESSION["year"]=$year;
  $_SESSION["section"]=$section;  
  $electiveinfo=explode(",",$_POST["year".$year."_elective_info"]);
  $elective_name=$electiveinfo[0];
  $elective_type=$electiveinfo[1];
  $_SESSION["elective_name"]=$elective_name;
  $_SESSION["elective_type"]=$elective_type;
  unset($electiveinfo);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC | Assign Elective</title>
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
<body >
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

  
<div class="container" id="assele">
    
  <form onsubmit="return validate()" method="POST">
  <h5><strong>Elective:&nbsp;<?php echo strtoupper($elective_name);?></strong></h5>
    <p>Year:&nbsp;<?php echo $year;?>&nbsp;&nbsp;Section:&nbsp;<?php echo $section;?></p>
  <form onsubmit="return validate()" method="POST">
<?php
  $tablename="year".$year."_student_info";
  if($elective_type=='O')
    $sql="select `student_id`,`student_name` from $tablename where open_elective='0' and `student_section`='$section'";
  if($elective_type=='P')
    $sql="select `student_id`,`student_name` from $tablename where professional_elective='0' and `student_section`='$section'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
?>
<label for="myInput">Search for Student ID or Student Name: </label>  <!--Create Table if there are studnets available-->
<input class="form-control" id="myInput" type="text" placeholder="Search..">
<table class='table table-borderless'>
<tbody><tr>
<td><button type='button' class='btn btn-primary' onclick='selectAll()'>Select All</button></td>
<td><button type='button' class='btn btn-danger' onclick='removeAll()'>Remove All</button></td>
<td><button type='submit' class='btn btn-success' name='submit1'>Submit</button></td>
</tr></tbody></table>
<table class="table table-bordered table-hover">
  <thead><tr>
    <th>Hall Ticket Number</th><th>Student Name</th></tr></thead><tbody id="myTable">
<?php
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td><div class='form-check'><label>";
      echo "<input type='checkbox' class='form-check-input' value='".$row["student_id"]."' name='student[]'>".$row["student_id"];
      echo "</label></div></td>";
      echo "<td>".$row["student_name"]."</td></tr>";    
    }
    echo "</tbody></table>";
    echo "<table class='table table-borderless'>";
    echo "<tbody><tr>";
    echo "<td><button type='button' class='btn btn-primary' onclick='selectAll()'>Select All</button></td>";
    echo "<td><button type='button' class='btn btn-danger' onclick='removeAll()'>Remove All</button></td>";
    echo "<td><button type='submit' class='btn btn-success' name='submit1'>Submit</button></td>";
    echo "</tr></tbody>";
  } else {
      if($elective_type=='O')
        echo "<h5><strong>Every Student of Year: $year Section: $section has been assigned an Open Elective</strong>.</h5>";
      if($elective_type=='P')
        echo "<h4><strong></strong>Every Student of Year: $year Section: $section has been assigned an Professional Elective.</h4>";
      echo "<p>Choose another Year/Section <a href='SelectElective.php'>Here.</a></p>";
      exit();
    }
}
?>
</tbody>
</table>
</form>

</form>

<?php
if(isset($_POST["submit1"])){
  $count=0;
  $year=$_SESSION["year"];
  if($_SESSION["elective_type"]=='P')
    $elective_type="professional_elective";
  else if($_SESSION["elective_type"]=='O')
    $elective_type="open_elective";
  $subject_name=$_SESSION["elective_name"];
  $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
  $tablename="year".$year."_student_info";
  $daily_attendance_table_name="year".$year."_total_attendance";
  $daily_sql="";
  foreach($_POST['student'] as $student_id){
    $sql="Update $tablename set `$elective_type`='$subject_name' where `student_id`='$student_id'";
    $daily_sql.="UPDATE $daily_attendance_table_name set `$subject_name`='0' where `student_id`='$student_id';";
    if ($conn->query($sql) === TRUE) {
      $count++;
    } 
    else {
      echo "Error updating record: " . $conn->error;
      exit();
    }
  }
  if ($conn->multi_query($daily_sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
}
  if($count>0){
    echo "<div class='Container'>";
    echo "<div class='alert alert-success'>";
    echo "<strong>$count Students Data Recorded!</strong> Back to  <a href='SelectElective.php' class='alert-link'>Assign Page</a>.";
    echo "</div>";
  }
  $conn->close();
}
?>
</div>
   

    </div><!-- /#right-panel -->
    </div>
    <!-- Left Panel -->
    <!-- Right Panel -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
var student = document.getElementsByName("student[]");
var i;
function selectAll(){
    for (i = 0; i < student.length; i++) {
        if (!student[i].checked) {
            student[i].checked=true;
        }
    }
}
function removeAll(){
    for (i = 0; i < student.length; i++) {
        if (student[i].checked) {
            student[i].checked=false;
        }
    }
}
function validate(){
  var p=0,total=0;
  var result="";
  for (i = 0; i < student.length; i++) {
    if (student[i].checked) {
      p++;
    }
    total++;
  }
  if(p==0){
    window.alert("Please Select Atleast One Student.");
    return false;
  }
  var message="Total "+p+"/"+total+" students are selected for the elective."; 
  return confirm(message);
}
</script>
