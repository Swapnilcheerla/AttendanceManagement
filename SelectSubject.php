<?php
session_start();
if(!$_SESSION["staff_id"]){
  echo "<script>window.alert('Please Login');</script>";
  header('Location: StaffLogin.php');
}
else
$conn = mysqli_connect("localhost", "root", "", "authority") or die("mysql_error()");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
$sql="select number_of_hours_per_day from department_info where `department_name`='CSE'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc())
    $number_of_hours_per_day=$row["number_of_hours_per_day"];
}
$sql="SELECT * from staff_subjects where `staff_id`='".$_SESSION["staff_id"]."'";
$result = $conn->query($sql);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC|Select Subject</title>
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
<body onload="automaticDate()">
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
        if ($result->num_rows > 0) {
        ?>
        <div class="container" id="ssub">
  <h4>Your Subjects:</h4>
  <p>Select an option to give attendance to that respective class.</p>     
  <form method="POST" action="Attendance.php">       
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Select One</th>
        <th>Subject</th>
        <th>Year</th>
        <th>Section</th>
        <th>Department</th>
      </tr>
    </thead>
    <tbody>
<?php
          $i=1;
          while($row = $result->fetch_assoc()) {
              $option="option".$i++;
              $subject=$option."subject";
              $year=$option."year";
              $section=$option."section";
              $department=$option."department";
              echo "<tr><td><div class='form-check'>";
              echo "<input type='radio' name='option' value='$option' class='form-check-input' required>";
              echo "</div></td>";
              echo "<td><div class='form-group'>";
              echo "<input type='text' class='form-control-plaintext' value='".$row["staff_subject"]."' name='$subject' readonly>";
              echo "</div></td>";
              echo "<td><div class='form-group'><input type='text' class='form-control-plaintext' value='".$row["staff_year"]."' name='$year' readonly></div></td>";
              echo "<td><div class='form-group'><input type='text' class='form-control-plaintext' value='".strtoupper($row["staff_section"])."' name='$section' readonly></div></td>";
              echo "<td><div class='form-group'><input type='text' class='form-control-plaintext' value='".strtoupper($row["staff_department"])."' name='$department' readonly></div></td>";
              echo "</tr>";
          }
        } 
        else {
          echo "<div class='container'><p><strong>No Subjects Available.Please contact your HOD and update Subject Info.</strong><p>";
          exit();
        }
      ?>
    </tbody>
  </table>
  <div class="form-group">
    <label for="hour">Hour:</label>
    <input type="number" class="form-control" id="hour" min='1' max='<?php echo $number_of_hours_per_day; ?>' name="hour" required placeholder="Period">
  </div>
  <div class="form-group"> <!-- Div to display hours started-->
    <label for="date_of_attendance">Today's Attendance(mm/dd/yy): </label>
        <input type="date" name="date_of_attendance" id="date_of_attendance" value="<?php echo date('d-m-Y'); ?>">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Get Student Data</button>
  </form>
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
<script>
function automaticDate() {
  var today = new Date();
  var date = today.getFullYear();
  if((today.getMonth()+1)<10)
    date=date+"-0"+(today.getMonth()+1);
  else
    date=date+"-"+(today.getMonth()+1);
  if((today.getDate())<10)
    date=date+"-0"+today.getDate();
  else
    date=date+"-"+today.getDate();
  document.getElementById("date_of_attendance").value = date;
}
</script>
</html>