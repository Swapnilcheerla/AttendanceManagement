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
$sql="SELECT * from staff_subjects where `staff_id`='".$_SESSION["staff_id"]."'";
$result = $conn->query($sql);
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
  <p>Select an option to get that respective class Register.</p>     
  <form method="POST" action="staff_register.php">       
  <table class="table table-hover">
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
           echo "<div class='alert alert-danger'>";
          echo "<strong>No Subjects Found.</strong> Please contact your HOD to update your Subjects.</div>";
          exit();
        }
      ?>
    </tbody>
  </table>
  <button type="submit" class="btn btn-primary" name="submit">Get Register</button>
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

    <script>
function automaticDate() {
  function automaticDate() {
  var today = new Date();
  var date = today.getFullYear();
  if((today.getMonth()+1)<10)
    date=date+"-0"+(today.getMonth()+1);
  else
    date=date+"-"+(today.getMonth()+1);
  if((today.getDate()+1)<10)
    date=date+"-0"+today.getDate();
  else
    date=date+"-"+today.getDate()+1;
  document.getElementById("dateofattendance").value = date;
}
function validate(){
    if(document.getElementById("year").value=="0"){
        window.alert("Please Select a year.");
        return false;
    }
    return true;
}
</script>s
</body>
