<?php
session_start();
if(!$_SESSION["staff_id"]){
  echo "<script>window.alert('Please Login');</script>";
  header('Location: StaffLogin.php');
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
                        <a href="SelectSubject.php">Take Attendence</a>
                    </li>
                    <li class="active">
                        <a href="Take Attendence.php">Change Subject</a>
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
<!--- update attendence---->

<?php
if($_POST){
  
  $department=$_SESSION["subject_department"];
  $section=$_SESSION["section"];
  $year=(int)$_SESSION["year"];
  $subject_type=$_SESSION["subject_type"];
  $number_of_hours_assigned=(int)$_SESSION["number_of_hours_assigned"];
  $subject_name=$_SESSION["subject_name"];
  $date_of_attendance=$_SESSION["date_of_attendance"];
  $start_hour=(int)$_SESSION["hour"];
  checkAttendance($department,$section,$year,$subject_name,$subject_type,$date_of_attendance,$start_hour,$number_of_hours_assigned);
  //Extract Student data
  $conn = new mysqli("localhost", "root", "", $department);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $tablename="year".$year."_student_info";
  if($subject_type=='O')
    $sql = "SELECT student_id,student_name,student_phone from $tablename where student_section='$section' and `open_elective`='$subject_name'";
  else if($subject_type=='P')
    $sql = "SELECT student_id,student_name,student_phone from $tablename where student_section='$section' and `professional_elective`='$subject_name'";
  else
  $sql = "SELECT student_id,student_name,student_phone from $tablename where student_section='$section'";
  $result = $conn->query($sql);
  $i=0;
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $j=0;
      $studentinfo[$i][$j++]=$row["student_id"];
      $studentinfo[$i][$j++]=$row["student_name"];
      $studentinfo[$i][$j++]=$row["student_phone"];
      $i++;
    }
  } 
  else {
    echo "<h4>Year $year Section $section Student data is not available</h4>";
    echo "<p>Please Select another year once again <a href='SelectSubject.php'>here.</a>";
    exit();
  }
  $number_of_students=$i;
  $number_of_absentees=0;
  $number_of_presentees=0;
  //If 0 students are present the the it will return false
  //insert into year_daily_attendance
  $tablename="year".$year."_daily_attendance";
  if(isset($_POST["student"])){
    $i=0;
    $k=0;
    foreach($_POST['student'] as $selected){
      $temp=explode(',',$selected);
      $presentees_id[$i]=$temp[0];
      $presentees_name[$i]=$temp[1];
      $i++;
    }
    $number_of_presentees=$i;
    for($i=0;$i<$number_of_students;$i++)
    if(!in_array($studentinfo[$i][0],$presentees_id)){
      $absentees_id[$k]=$studentinfo[$i][0];
      $absentees_name[$k]=$studentinfo[$i][1];
      $absentees_phone_number[$k]=$studentinfo[$i][2];
      $k++;
    }
    $number_of_absentees=$k;
  }
  if($number_of_presentees>0){
    for($i=0;$i<$number_of_presentees;$i++){
      for($j=$start_hour;$j<($number_of_hours_assigned+$start_hour);$j++){
        $hour="hour".$j;
        $sql="insert into $tablename(`student_id`,`student_name`,`student_section`,`date`,$hour) 
        values ('".$presentees_id[$i]."','".$presentees_name[$i]."','$section','$date_of_attendance','1')
        ON DUPLICATE KEY UPDATE `$hour` = '1';";
        if ($conn->query($sql) === TRUE) {
          //
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          exit();
        }
      }
    }

  }
  if($number_of_absentees>0){
    for($i=0;$i<$number_of_absentees;$i++){
      for($j=$start_hour;$j<($number_of_hours_assigned+$start_hour);$j++){
        $hour="hour".$j;
        $sql="insert into $tablename(`student_id`,`student_name`,`student_section`,`date`,`$hour`) 
        values ('".$absentees_id[$i]."','".$absentees_name[$i]."','$section','$date_of_attendance','0')
        ON DUPLICATE KEY UPDATE `$hour` = '0';";
        if ($conn->query($sql) === TRUE) {
          //
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          exit();
        }
      }
    }
  }
  else if($number_of_presentees==0 && $number_of_absentees==0){//If 0 members are present the this loop will execute
    $sql="";
    for($i=0;$i<$number_of_students;$i++){
      for($j=$start_hour;$j<($number_of_hours_assigned+$start_hour);$j++){
        $hour="hour".$j;
        $sql="insert into $tablename(student_id,student_name,student_section,`date`,$hour) 
        values ('".$studentinfo[$i][0]."','".$studentinfo[$i][1]."','$section','$date_of_attendance','0')
        ON DUPLICATE KEY UPDATE `$hour` = '0'";
        if ($conn->query($sql) === TRUE) {
          //
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          exit();
        }
      }
    }
  }

  

  //Update hourwise
  $tablename="year".$year."_hourwise";
  $total_count=$_POST["total_count"];
  for($i=$start_hour;$i<($start_hour+$number_of_hours_assigned);$i++){
    $sql = "insert into $tablename(hour_year,hour_section,hour,hour_subject,`subject_type`,`date`,hour_count) values ('$year','$section','$i','$subject_name','$subject_type','$date_of_attendance','$total_count')";
    if ($conn->query($sql) === TRUE) {//later
    } 
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  
  //Update year_subject_info
  $tablename="year".$year."_subject_info";
  $sql="UPDATE  $tablename SET `$section` = `$section` + ".(int)$number_of_hours_assigned." WHERE subject_name = '$subject_name'";
  if ($conn->query($sql) === TRUE) {//later
  } 
  else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  //Update year3_total_attendance
  $tablename="year".$year."_total_attendance";
  $subject_type=$_SESSION["subject_type"];
  $subject_name=$_SESSION["subject_name"];
  if(isset($_POST['student']))
  foreach($_POST['student'] as $student){
      $student_id=explode(",",$student);
      if($subject_type=='P'){
        $sql = "UPDATE  $tablename SET `$subject_name` = `$subject_name` + ".(int)$number_of_hours_assigned." WHERE student_id = '$student_id[0]'";
      }
      else if ($subject_type=='O'){
        $sql = "UPDATE  $tablename SET `$subject_name` = `$subject_name` + ".(int)$number_of_hours_assigned." WHERE student_id = '$student_id[0]'";
      }
      else
        $sql="UPDATE  $tablename SET `$subject_name` = `$subject_name` + ".(int)$number_of_hours_assigned." WHERE student_id = '$student_id[0]'";
      if ($conn->query($sql) === TRUE) {//later
      } 
      else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          exit();
      }
  }
  //SMS
  if(($start_hour=='1' || $start_hour=='5') && $number_of_absentees>0)//Should be changed later: afternoon start hour
    sendSMS($absentees_phone_number);
}
?>
<div class="alert alert-success">
  <strong>Attendance Recorded Successfully!</strong> 
</div>
<?php
function checkAttendance($department,$section,$year,$subject_name,$subject_type,$date_of_attendance,$start_hour,$number_of_hours_assigned){
  $tablename="year".$year."_hourwise";
  $conn = mysqli_connect("localhost", "root", "", $department);
  $sql="select subject_type,hour_subject,hour_count from $tablename where `hour_year`='$year' and `hour_section`='$section' and `hour`='$start_hour' and `date`='$date_of_attendance' ";
  $result=$conn->query($sql);
  if ($result->num_rows > 0) {
      $row=$result->fetch_assoc();
      if($subject_type==$row["subject_type"] && $subject_name!=$row["hour_subject"])
        return;
      echo "<h4>The attendance for the Hour:$start_hour is already taken.Total Count:".$row["hour_count"]."</h4>";
      echo "<h4>Back to Attendance <a href='SelectSubject.php'>Page</a></h4>";
      exit();
  }
  else {
    return;
  }
}
function sendSMS($absentees_phone_number){
$c=0;
$dbname="cse"; //create a session
$hour = date('H');
$dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
$apiKey = urlencode("Y30BN7zVIcw-wqs4o1mpWybAlYiWq8kVeSuxTYthBK");
$sender = urlencode("TXTLCL");
$message="MREC:".$dayTerm."- Attendance details: You have been marked absent for the ".$dayTerm." session on ".date('d-F-Y');
echo $message;
$message = rawurlencode($message);
 
$numbers = implode(",", $absentees_phone_number);
//print_r $numbers;
 
// Prepare data for POST request
$data = array("apikey" => $apiKey, "numbers" => $numbers, "sender" => $sender, "message" => $message);
// Send the POST request with cURL
$ch = curl_init("https://api.textlocal.in/send/");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Process your response here
echo $response;
}
?>

<!--- update attedence --->



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
