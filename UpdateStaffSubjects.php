<?php
session_start();
error_reporting(E_ERROR);
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
else 
if (isset($_POST['submit'])){
    $flag=1;
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC|Update Staff Subjects</title>
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
                    <h5><strong>Department: <?php echo strtoupper($_SESSION["hod_department"]);?></strong></h5>

                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

<div class="container">
<h5>Assigning subjects for Staff: <?php echo $_SESSION["staff_name"];?></h5>

<form method="POST" onsubmit="return validate()">
<?php
    $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    for($i=1;$i<=$_SESSION["number_of_subjects"];$i++){
        $name="subject".$i;
        $tablename="year".$_POST["subject".$i]."_subject_info";
        $_SESSION["assigned_year".$i]=$_POST["subject".$i];
        $_SESSION["section_for_subject".$i]=$_POST["section_for_subject".$i];
        $sql="select `subject_name` from $tablename ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<div class='form-group'>";
            echo "<label for='$name'>Select Subject for Year:".$_POST["subject".$i]."  Section:".$_POST["section_for_subject".$i]."</label>";
            echo "<select class='form-control' id='$name' name='$name'>";
            echo "<option selected value='0'>Select Subject</option>";
            while($row = $result->fetch_assoc()) {
                $subject_name=$row["subject_name"];
                echo "<option value='$subject_name'>$subject_name</option>";
            }
            echo "</select></div>";
        } else {
            $flag=0;
            echo "<h4>No Subjects Available for the year ".$_POST["subject".$i]."</h4>";
            echo "<a href='Subjects.php'>Please Upload Your Subjects Here</a>";
        }
        
    }
    if($flag)
    echo "<button type='submit' name='submit1' class='btn btn-primary'>Assign Staff</button>";
}
?>
</form>
</div>
<script>
function validate() {
    var number_of_subjects='<?php echo $_SESSION["number_of_subjects"]; ?>';
    for(var i=1;i<=number_of_subjects;i++)
    if(document.getElementById("subject"+i).value=='0' || document.getElementById("section_for_subject"+i).value=='0'){
        alert("Subject"+i+" data is missing.");
        return false;
    }
    return true;
}
</script>
<?php
    if (isset($_POST['submit1'])){
        checkAvailability();
        $conn = new mysqli("localhost", "root", "","authority");
        $tablename="staff_subjects";
        for($i=1;$i<=$_SESSION["number_of_subjects"];$i++){
            $tablename="staff_subjects";
            $staff_id=$_SESSION["staff_id"];
            $staff_name=$_SESSION["staff_name"];
            $staff_year=$_SESSION["assigned_year".$i];
            $staff_section=$_SESSION["section_for_subject".$i];
            $staff_subject=$_POST["subject".$i];
            $staff_department=$_SESSION["hod_department"];
           
            $sql="insert into $tablename values('$staff_id','$staff_name','$staff_year','$staff_section','$staff_subject','$staff_department')";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                exit();
            }
        }
        echo "<div class='alert alert-success'>";
        echo "<strong>Staff Subjects Recorded Successfully!</strong> Back To <a href='AssignStaff.php' class='alert-link'>Assign Page</a>.";
        echo "</div>";
        $conn->close();
    }
    function checkAvailability(){
        $conn = new mysqli("localhost", "root", "","authority");
        $tablename="staff_subjects";
        for($i=1;$i<=$_SESSION["number_of_subjects"];$i++){
            $staff_year=$_SESSION["assigned_year".$i];
            $staff_section=$_SESSION["section_for_subject".$i];
            $staff_subject=$_POST["subject".$i];
            $staff_department=$_SESSION["hod_department"];
            $sql="select * from $tablename where `staff_year`='$staff_year'  and `staff_section`='$staff_section' and `staff_subject`='$staff_subject' and `staff_department`='$staff_department'";
            $result=$conn->query($sql);
            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                echo "<div class='container'><h4>Subject: $staff_subject is already assigned for ".$row["staff_name"]."</h4>";
                echo "<p>Please Upload staff data <a href='AssignStaff.php'>here.</p>";
                exit();
            }
            else{
                return ;
            }
        }
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


</body>
