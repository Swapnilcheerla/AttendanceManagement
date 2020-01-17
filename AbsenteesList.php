<?php
session_start();
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

<div class="container" id="ablst">
    <?php
if($_GET){
    $content = '';
$content .= '<div>
<img src="mrec.jpeg" alt="logo" height="150" width="700">
</div>
';

    $conn = new mysqli('localhost','root','',$_SESSION["hod_department"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $date=$_SESSION["dateofabsentees"];
    $content.=''.$_SESSION["dateofabsentees"];
    $hour="hour".$_GET["hour"];
    $year=$_GET["year"];
    if(isset($_GET["section"])){
        $section=$_GET["section"];
        $sql="SELECT `student_id`,`student_name`,`student_phone` from `year".$year."_student_info` where student_id IN(select student_id from year".$year."_daily_attendance where `$hour`='0' and `date`='$date' and `student_section`='$section')";
        $result=$conn->query($sql);
        echo "<div class='container'><h4>Year: $year Section:$section No.of.Absentees: ".mysqli_num_rows ( $result )."</h4><br>";
        $content .= '<h4>Year:'. $year.' Section:'.$section.' No.of.Absentees: '.mysqli_num_rows ( $result ).'</h4>';

        echo "<table class='table'><thead class='thead-dark'><tr><th>Student ID</th><th>Student Name</th><th>Student Number</th></thead><tbody>";
        $content .= '<table border="1" cellspacing="0" cellpadding="3" ><tr><th>Student ID</th><th>Student Name</th><th>Student Number</th></tr>';
    }
    else{
        $sections=explode(",",$_GET["sections"]);
        $sub_sections="`student_section`='$sections[0]'";
        for($i=1;$i<count($sections)-1;$i++){
            $sub_sections.="or `student_section`='$sections[$i]'";
        }
            
        $sql="SELECT `student_id`,`student_name`,`student_section`,`student_phone` from `year".$year."_student_info` where student_id IN(select student_id from year".$year."_daily_attendance where `$hour`='0' and `date`='$date' and ($sub_sections)) ORDER BY `student_section`";
        $result=$conn->query($sql);
        echo "<div class='container'><h4>Year: $year No.of.Absentees: ".mysqli_num_rows ( $result )."</h4>";
        $content .= '<h4>Year:'. $year.' No.of.Absentees: '.mysqli_num_rows ( $result ).'</h4>';
        echo "<table class='table'><thead class='thead-dark'><tr><th>Student ID</th><th>Student Name</th><th>Student Section</th><th>Student Number</th></thead><tbody>";
        $content .= '<table border="1" cellspacing="0" cellpadding="3" ><tr><th>Student ID</th><th>Student Name</th><th>Student Section</th><th>Student Number</th></tr>';
    }
    echo "<a href='HourInput.php' id='abclk'>Choose another Year</a><br>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            $content .= '<tr>';
            echo "<td>".$row["student_id"]."</td><td>".$row["student_name"]."</td>";
            $content .= '<td>'.$row["student_id"].'</td><td>'.$row["student_name"].'</td>';
            if(!isset($_GET["section"]))
            {
                echo "<td>".$row["student_section"]."</td>";
                $content .= '<td>'.$row["student_section"].'</td>';
            }
            echo "<td>".$row["student_phone"]."</td>";
            echo "<tr>";
            $content .= '<td>'.$row["student_phone"].'</td></tr>';
        }
    } else {
        echo "<h4>O Absentees</h4>";
        $content .= '<h4>O Absentees</h4>';
    }
    echo "</tbody><table>";
    $content .= '<table>';
    $conn->close();
    ?>
    <div class="col-md-12" align="right">
<form  action="pdfgen.php" method="post"> 
<input type='hidden' value='<?php echo $content ?>' name='conte'/>

<input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
</form>  

</div>
<?php
}

?>

</div>  


     </div><!-- /#right-panel -->
    </div>
    <!-- Left Panel -->
    <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>
