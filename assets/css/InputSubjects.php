<?php
session_start();
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
else
$_SESSION["year"]=$_POST["year"];
$_SESSION["number_of_hours"]=$_POST["number_of_hours"];
$_SESSION["number_of_core_subjects"]=$_POST["number_of_core_subjects"];
$_SESSION["number_of_labs"]=$_POST["number_of_labs"];
$_SESSION["number_of_professional_electives"]=$_POST["number_of_professional_electives"];
$_SESSION["number_of_open_electives"]=$_POST["number_of_open_electives"];
$_SESSION["number_of_other_subjects"]=$_POST["number_of_other_subjects"];
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC | Input Subjects</title>
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
                     <h5><strong>Department:   <?php echo strtoupper($_SESSION["hod_department"])."    Year:".$_POST["year"];?></strong>  </h5>
                </div>

                <<div class="col-sm-5">
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

 <div class="alert alert-primary">
      <strong>Note: Two Subjects cant have Same Name</strong> 
 </div>
<body>
<div class="container" id="hins">
 
  <form action="UpdateSubjects.php" method="POST">
    <?php
      createTextFields("Core Subject",$_POST["number_of_core_subjects"]);

      if($_POST["number_of_labs"]>0)
      createTextFields("Lab",$_POST["number_of_labs"]);

      if($_POST["number_of_professional_electives"]>0){
        createTextFields("Professional Elective",$_POST["number_of_professional_electives"]);
        echo "<div class='form-group'>";
        echo "<label for='number_of_hours_for_professional_elective'>Number of hours for Professional Elective in a Day :</label>";
        echo "<input type='text' class='form-control' name='number_of_hours_for_professional_elective' placeholder='Number of hours for Professional Elective in a Day' min='1' id='number_of_hours_for_professional_elective' required>";
        echo "</div><br>";
      }
      
      if($_POST["number_of_open_electives"]>0){
        createTextFields("Open Elective",$_POST["number_of_open_electives"]);
        echo "<div class='form-group'>";
        echo "<label for='number_of_hours_for_professional_elective'>Number of hours for Open Elective in a Day :</label>";
        echo "<input type='text' class='form-control' name='number_of_hours_for_open_elective' placeholder='Number of hours for Open Elective in a Day' min='1' id='number_of_hours_for_open_elective' required>";
        echo "<div><br>";
      }
      
      if($_POST["number_of_other_subjects"]>0)
      createTextFields("Other Subject",$_POST["number_of_other_subjects"]);
    ?>
    <button type="submit" class="btn btn-primary">Submit</button>
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
<?php
function createTextFields($base_name,$no_of_fields){
  if($base_name=="Other Subject")
    echo "<h4>$base_name(SoftSkills,Technical Seminars,Dashboards,etc....):</h4>";
  else
    echo "<h4>$base_name:</h4>";
  
  for($i=1;$i<=$no_of_fields;$i++){
    $fieldname=$base_name.$i;
    $name=str_replace(" ","_",$fieldname);
    if($base_name!="Other Subject"){
      echo "<div class='form-group'>";
      echo "<label for='$fieldname'>$fieldname:</label>";
      echo "<input type='text' class='form-control' id='$fieldname' name='$name' placeholder='$fieldname Name' required>";
      echo "</div><br>";
    }
    if($base_name=="Other Subject"){
      echo "<div class='input-group mb-3'>";
      echo "<div class='input-group-prepend'>";
      echo "<span class='input-group-text'>$fieldname</span>";
      echo "</div>";
      echo "<input type='text' class='form-control' id='$fieldname' name='$name' placeholder='$fieldname Name' required>";
      echo "<input type='number' min='1' class='form-control' id='number_of_hours_for_$name' name='number_of_hours_for_$name' placeholder='Number of hours for $fieldname' required>";
      echo "</div>";
    }
  }
}
?>