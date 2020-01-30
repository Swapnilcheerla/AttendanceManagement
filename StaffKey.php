<?php
session_start();
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
$conn = new mysqli("localhost", "root", "", "authority");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT staff_key FROM hod_login_info where hod_department='".$_SESSION["hod_department"]."' limit 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $staff_key=$row["staff_key"];
    }
} else {
    echo "<h4>No Data Found</h4>";
    exit();
}
$conn->close();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC|Staff Key</title>
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
                    <h4><strong><?php echo strtoupper($_SESSION["hod_name"]);?></strong> </h4>
                    <h5 id="dp">Department:   <strong><?php echo strtoupper($_SESSION["hod_department"]);?></strong> </h5>
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

<div class="container" id="stfky">
  
  <form method="POST">
  <div class="form-group">
    <label for="usr">Staff Key:</label>
    <input type="text" class="form-control" id="key" value='<?php echo $staff_key;?>' readonly>
  </div>
  <input type="submit" class="btn btn-primary" name="submit1" value="Regenerate Key">
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
<?php
if(isset($_POST["submit1"])){
    $department=$_SESSION["hod_department"];
    $conn = new mysqli("localhost", "root", "", "authority");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $key="";
    for($i=1;$i<=8;$i++)
        $key.=rand(0,9);
    $sql = "UPDATE hod_login_info SET `staff_key`='$key' WHERE `hod_department`='$department'";
    echo $sql;
    if ($conn->query($sql) === TRUE){
        header('Location: StaffKey.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}
?>

</body>

</html>

