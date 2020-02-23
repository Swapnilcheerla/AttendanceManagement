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
    <title>MREC|Change Student Data</title>
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
<?php
if(!$_POST){
?>

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
                    <h4 id="dp">Department:   <strong><?php echo strtoupper($_SESSION["hod_department"]);?></strong> </h4>
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


<div class='container' id="chstdt">
    <h5><strong>Change Student Info :</strong></h5><br>
<form  method="POST" onsubmit="return validate()" target="_blank">
<div class="form-group">
    <label for='year'>Select Year :</label>
    <select class="form-control" id='year' name='year' >
        <option selected disabled value='0' >Select Year</option>
        <option value='1'>First Year</option>
        <option value='2'>Second Year</option>
        <option value='3'>Third Year</option>
        <option value='4'>Fourth Year</option>
    </select>
</div>
<p><strong>Search for Student ID or Student Name</strong></p>
<div class="form-group">
      <label for="student_id">Enter Student ID:</label>
      <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student Id">
    </div>
    <div class="form-group">
      <label for="student_name">Enter Student Name:</label>
      <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Student Full Name">
    </div>
<button type="submit" class="btn btn-primary">Get Student Data</button>
</form></div>




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
  function validate(){
    var year=document.getElementById("year").value;
    if(year==0){
      window.alert("Please Select a Year");
      return  false;
    }
    if(document.getElementById("student_name").value=="" && document.getElementById("student_id").value==""){
        window.alert("Please enter Student ID or Student Name");
        return false;
    }
    if(document.getElementById("student_id").value!="")
        if(document.getElementById("student_id").value.length!=10){
            window.alert("Student ID must have 10 alphanumeric values");
            return false;
        }
    return true;
  }
</script>
<?php
}
?>
<?php
if($_POST){
    $year=$_POST["year"];
    $_SESSION["year"]=$year;
    $student_id=$_POST["student_id"];
    $student_name=$_POST["student_name"];
    $tablename="year".$year."_student_info";
    $sql="select student_id,student_name,student_section,student_phone from $tablename where ";    
    $sql.="student_id='$student_id' OR student_name='$student_name'";
    $conn = new mysqli("localhost", "root", "", $_SESSION["hod_department"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i=1;
        $_SESSION["number_of_rows"]=mysqli_num_rows ( $result );
        echo "<div class='container'><h4>No.of Students Found:".mysqli_num_rows ( $result )."</h4><p>Student ID and Student Section are not Editable.</p>";
        echo "<form method='POST' action='UpdateStudentInfo.php'  onsubmit='return validateFields()' >";
        echo "<table class='table table-bordered'><thead>";
        echo "<th>Student ID</th><th>Student Name</th><th>Student Section</th><th>Contact Info</th></tr></thead>";
        echo "<tbody><tr>";
        while($row = $result->fetch_assoc()) {
            $student_name="student_name".$i;
            $student_number="student_phone".$i;
            $student_id="student_id".$i;
            echo "<div class='form-group'><td><input type='text'  name='$student_id' readonly style='text-transform: uppercase'class='form-control-plaintext' value='".$row["student_id"]."' name='$year'></td></div>";
            echo "<div class='form-group'><td><input type='text' id='$student_name' name='$student_name' style='text-transform: uppercase'class='form-control' value='".$row["student_name"]."' name='$year'></td></div>";
            echo "<div class='form-group'><td><input type='text' style='text-transform: uppercase' class='form-control-plaintext' value='".$row["student_section"]."'  readonly></td></div>";
            echo "<div class='form-group'><td><input type='number' id='$student_number' name='$student_number' class='form-control' value='".$row["student_phone"]."' name='$year'></td></div>";
            $i++;
        }
        echo "</tr></tbody></table>";
        echo "<button type='submit' class='btn btn-primary' name='submit1'>Update Student Data</button>";
        echo "</form></div>";
    }
    else{
        if($student_name=="")
            echo "<h4>No data Found matching Student ID:$student_id</h4>";
        else if($student_id=="")
            echo "<h4>No data Found matching Student Name:$student_name</h4>";
        else    
            echo "<h4>No data Found matching Student ID:$student_id or Student Name:$student_name</h4>";
        echo "<p>Please contact Admin or Select another student <a href='ChangeStudentData.php'>here</a>.</p>";
        exit();
    }
}
?>
<script>
function validateFields(){
    var number_of_rows=parseInt('<?php echo $_SESSION["number_of_rows"];?>');
    for(var i=1;i<=number_of_rows;i++){
        var student_name=document.getElementById("student_name"+i).value;
        var student_phone=document.getElementById("student_phone"+i).value;
        if(student_name==""){
            window.alert("Student name can\'t be Null");
            return false;
        }
        if(student_phone==""){
            window.alert("Student phone can\'t be Null");
            return false;
        }
        if(student_phone.length!=10){
            window.alert("Student phone number must conatin 10 digits");
            return false;
        }
    }
}    
</script>

</html>

