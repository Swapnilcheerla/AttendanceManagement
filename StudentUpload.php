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
    <title>MREC|Student Upload </title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
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
                        <h4><strong>Department:   <?php echo $_SESSION["hod_department"];?></strong></h4>
                </div>

                <div class="col-sm-5">
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



<div class="loader" id='load' style='display: none'>Loading...!</div>
<div class="container" id="hstup">
  <h5><strong>Upload Student Data :</strong></h5><br>
  <div class="alert alert-info">
    <strong>NOTE: </strong> Please update Subject Info before uploading Student Info.Update Subjects Info <a href="Subjects.php" class="alert-link">here.</a>.
  </div><br>

  <p class="text-center"><strong>Please Follow This Format in the CSV file.Example:</strong></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Student Hallticket</th><th>Student Name</th>
        <th>Student Year</th><th>Student Section</th>
        <th>Parent Number</th>
      </tr>
    </thead>
    <tbody>
      <td>17J41A0XXX</td><td>John</td><td>3</td><td>A</td><td>9090989765</td>
    </tbody>
  </table><br>
  <form method="POST" onsubmit="return validate()" enctype="multipart/form-data">
    <div class="form-group">
      <label for="year">Select Year: </label>
      <select class="form-control" id="year" name="year">
      <option value='0' selected>Select Year</option>
        <option value='1'>First Year</option>
        <option value='2'>Second year</option>
        <option value='3'>Third Year</option>
        <option value='4'>Fourth Year</option>
      </select>
    </div>
    <div class="form-group">
      <label>Select CSV File:</label>
      <input type="file" name="file" />
    </div>
    <input type="submit" name="submit" id="ubtn" value="Import" class="btn btn-success" />
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

</html>

<?php  
$conn = mysqli_connect("localhost", "root", "", $_SESSION["hod_department"]);
if(isset($_POST["submit"]))
{
 if($_FILES['file']['name'])
 {
  $filename = explode(".", $_FILES['file']['name']);
  if($filename[1] == 'csv')
  {
   $flag1=0; //Flag1 is for professional elective
   $flag2=0; //Flag2 is for open elective
   deleteTable("year".$_POST["year"]."_student_info",$conn);
   $tablename="year".$_POST["year"]."_subject_info";
   $sql="SELECT DISTINCT subject_type FROM $tablename where subject_type='O' or subject_type='P'";
   $result=$conn->query($sql);
   if ($result->num_rows >0){
     while($row=$result->fetch_assoc()){
       if($row["subject_type"]=='O')
         $flag2=1;
       if($row["subject_type"]=='P')
         $flag1=1;
     }
   }
   else
     echo "Error: " . $conn->error;
    $tablename="year".$_POST["year"]."_student_info";
   $sql="create table $tablename (student_id varchar(50) PRIMARY KEY,student_name varchar(320),student_year int,student_section varchar(10),student_phone varchar(50)";
   if($flag1)
    $sql.=",professional_elective varchar(320) default 0";
  if($flag2)
    $sql.=",open_elective varchar(320) default 0";
  $sql.=")";
   $daily_attendance_table_name="year".$_POST["year"]."_total_attendance";
   if ($conn->query($sql) === TRUE) {
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $i=0;
    
    while($data = fgetcsv($handle))
    {
       $item1 = mysqli_real_escape_string($conn, $data[0]);  
       $item2 = mysqli_real_escape_string($conn, $data[1]);
       $item3 = mysqli_real_escape_string($conn, $data[2]);  
       $item4 = mysqli_real_escape_string($conn, $data[3]);
       $item5 = mysqli_real_escape_string($conn, $data[4]);
       $query = "INSERT into $tablename(student_id,student_name,student_year,student_section,student_phone) values('$item1','$item2',$item3,'$item4','$item5')";
       mysqli_query($conn, $query);
       $query = "INSERT into $daily_attendance_table_name(student_id,student_name,student_section) values('$item1','$item2','$item4')";
       mysqli_query($conn, $query);
       $i++;
    }
    fclose($handle);
    echo "<script>alert('$i students data uploaded successfully.');</script>";
  }
  else {
    echo "Error creating table: " . $conn->error;
  }
}
  else{
    echo "<script>alert('Upload CSV files only');</script>";
  } 
}
}
function deleteTable($tablename,$conn)
{
  $sql = "DROP TABLE IF EXISTS $tablename;";  //This is useful as we need to update for every semester
  if ($conn->query($sql) === TRUE);
  else 
  {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>  
<script>
function validate(){
  if(document.getElementById("year").value=='0'){
    alert("Please Select a Year");
    return false;
  }
  return true;
}
</script>