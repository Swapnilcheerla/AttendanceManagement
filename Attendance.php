<?php
session_start();
if(!$_SESSION["staff_id"]){
  echo "<script>window.alert('Please Login');</script>";
  header('Location: StaffLogin.php');
}
?>
<?php
if($_POST){
  $option=$_POST["option"];
  $department=$_POST[$option."department"];
  $start_hour=$_POST["hour"];
  $subject_name=$_POST[$option."subject"];
  $year=$_POST[$option."year"];
  $date_of_attendance=$_POST["date_of_attendance"];
  $section=$_POST[$option."section"];

  $conn = new mysqli("localhost", "root", "", "authority");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
  //To get number_of_hours_per_day_in from department_info 
  $tablename = "department_info";
  $sql = "select `number_of_hours_per_day` from $tablename where `department_name`='$department'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $number_of_hours_per_day = (int)$row["number_of_hours_per_day"];
    }
  else {
    echo "<h4>Department Info is missing</h4>"; 
    exit();
  }
  $conn = new mysqli("localhost", "root", "", $department);

  //Number of hours associated to that subject
  $tablename = "year".$year."_subject_info";
  $sql="select `number_of_hours_assigned`,`subject_type` from $tablename where `subject_name`='$subject_name'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $number_of_hours_assigned = (int)$row["number_of_hours_assigned"];
    $subject_type=$row["subject_type"];
  }
  else {
    echo "<h4>$tablename data is missing</h4>"; 
    echo "<p>Please Select Hour once again <a href='SelectSubject.php'>here.</a>";
    exit();
  }

  //Check Whether it exceeds the daily limit or not
  if(($start_hour+$number_of_hours_assigned-1)>$number_of_hours_per_day){
    echo "<div class='container'><h4>The attendance for the Hour:".($start_hour+$number_of_hours_assigned-1)." exceeds the daily Hour Limit:$number_of_hours_per_day</h4>";
    echo "<p>Please Select Hour once again <a href='SelectSubject.php'>here.</a>";
    exit();
  }

  //Check whether the attendance for that hour is already taken or not
  $tablename = "year".$year."_hourwise";
  $sql="select `hour_subject`,`hour`,`subject_type` from $tablename where `hour_year`='$year' and `hour_section`='$section' and  `date`='$date_of_attendance' and ( `hour`='$start_hour' ";
  for($i=$start_hour+1;$i<($start_hour+$number_of_hours_assigned);$i++)
    $sql.=" OR `hour`='$i'";
  $sql.=")";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["subject_type"];
    echo $subject_type;
    if(($subject_type!='P' && $subject_type !='O') || $row["subject_type"]!=$subject_type || $row["hour_subject"]==$subject_name ){
      echo "<div class='container'>";
      echo "<h4>Attendance is already taken.Here are the details:";
      echo "<p>Hour: ".$row["hour"]." is taken by ".$row["hour_subject"]." faculty</p>";
      while($row=$result->fetch_assoc())
        echo "<p>Hour: ".$row["hour"]." is taken by ".$row["hour_subject"]." faculty</p>";
      echo "<p>Please Select Hour once again <a href='SelectSubject.php'>here.</a>";
      exit();
    }
  }
  
  //After successfull validation we create sessions
  $_SESSION["subject_department"]=$department;
  $_SESSION["section"]=$section;
  $_SESSION["year"]=$year;
  $_SESSION["subject_type"]=$subject_type;
  $_SESSION["number_of_hours_assigned"]=$number_of_hours_assigned;
  $_SESSION["subject_name"]=$subject_name;
  $_SESSION["date_of_attendance"]=$date_of_attendance;
  $_SESSION["hour"]=$start_hour;

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
                        <a href="SelectSubject.php">Take Attendence</a>
                    </li>
                    <li class="active">
                        <a href="Staffregister.php">Staff Register</a>
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
                    <h6><strong>Year: <?php echo $year;?>&nbsp;&nbsp;&nbsp;Section:<?php echo $section?><br>Subject:<?php echo $subject_name;?></strong></h6>
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

  
<div class="container">
  <p><strong>Selected Student Will Get Attendance</strong></p> 
  <p >Search for Student ID or  Student name:</p>  
  <input class="form-control" id="myInput" type="text" placeholder="Search..">       
  <form onsubmit="return getConfirmation()" method="POST" action="UpdateAttendance.php">
  <input type="text" name="total_count" style="display:none;" id="total_count" value="">
  <table class='table table-borderless'>
  <tbody><tr>
  <td><button type='button' class='btn btn-primary' onclick='selectAll()'>Select All</button></td>
  <td><button type='button' class='btn btn-danger' onclick='removeAll()'>Remove All</button></td>
  <td><button type='submit' class='btn btn-success' name='submit'>Submit</button></td>
  </tr></tbody>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Hall Ticket Number</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
  //Extract Student Data
  $tablename="year".$year."_student_info";
  if($subject_type=='P'){
    $sql = "SELECT student_id,student_name FROM $tablename where `student_section`='$section' and `professional_elective`='$subject_name';";
  }
  else if ($subject_type=='O'){
    $sql = "SELECT student_id,student_name FROM $tablename where `student_section`='$section' and `open_elective`='$subject_name';";
  }
  else{
    $sql = "SELECT student_id,student_name FROM $tablename where `student_section`='$section';";
  }
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr><td><div class='form-check'>";
      echo "<label class='form-check-label' for='".$row["student_id"]."'>";
      echo "<input type='checkbox' class='form-check-input' id='".$row["student_id"]."' name='student[]' value='".$row["student_id"].",".$row["student_name"]."' >".$row["student_id"]."</label></td>";
      echo "<td>".$row["student_name"]."</td>";
      echo "</div>";
      echo "<tr>";    
    }
    echo "</tbody></table>";
    echo "<table class='table table-borderless'>";
    echo "<tbody><tr>";
    echo "<td><button type='button' class='btn btn-primary' onclick='selectAll()'>Select All</button></td>";
    echo "<td><button type='button' class='btn btn-danger' onclick='removeAll()'>Remove All</button></td>";
    echo "<td><button type='submit' class='btn btn-success' name='submit'>Submit</button></td>";
    echo "</tr></tbody>";
  } 
  else {
    echo "<h4>Year $year student data is not available or the electives are not yet assigned.</h4>";
    echo "<p>Please Select Year once again <a href='SelectSubject.php'>here.</a>";
  }
?>
</tbody></table></div></form>
<?php 
  $conn->close();
}
?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 


</body>
<script type='text/javascript'>
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
var i=0;
function selectAll(){
  var student = document.getElementsByName("student[]");
  for (i = 0; i < student.length; i++) {
    if (!student[i].checked) {
      student[i].checked=true;
    }
  }
}
function removeAll(){
  var student = document.getElementsByName("student[]");
  for (i = 0; i < student.length; i++) {
    if (student[i].checked) {
        student[i].checked=false;
    }
  }
}
function getConfirmation(){
  var student = document.getElementsByName("student[]");
  var p=0,total=0; 
  for (i = 0; i < student.length; i=i+1){
    if(student[i].checked)
      p++;
    total++;
  }
  document.getElementById("total_count").value=p+"/"+total;
  return confirm("No.of students present: "+p+"/"+total+"\nAre you sure you want to Submit?");
}
</script>
