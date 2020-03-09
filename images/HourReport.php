<?php
session_start();
if( !isset($_SESSION["hod_email"]) ){
  header("location:HODLogin.php");
  exit();
}
  
?>
<?php
if($_POST){
    $select_year=$_POST["year"];
    $department=$_SESSION["hod_department"];
    $select_date=$_POST["dateofattendance"];
    $_SESSION["dateofabsentees"]=$select_date;
    $conn = new mysqli('localhost','root','','authority');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT year".$select_year.",number_of_hours_per_day from department_info where department_name='".$department."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
            $no_of_sections= (int)$row["year".$select_year];
            $number_of_hours_per_day=(int)$row['number_of_hours_per_day'];
    } 
    else {
        echo "<h4>Department Info is missing.</h4>";
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
                        <a href="HourInput.php">Daily Report</a>
                    </li>
                    <li class="active">
                        <a href="Subjects.php">Subjects</a>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="AssignStaff.php">Assign Subjects to Staff</a></li>
                            <li><a href="StaffInfo.php">Staff Info</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Students</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="SelectElective.php">Assign Elective</a></li>
                            <li><a href="StudentUpload.php">Upload Students List</a></li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="TotalAttendance.php">Total Attendence </a>
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
                            <a class="nav-link" href="Logout.php"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
<div class='container' id="hrp">
<h4>Department: <?php echo $department;?></h4>
<h5>Year: <?php echo $select_year;?>  Hourwise Data</h5>
<div class="table-responsive">
<table class='table table-bordered'>
<thead class='thead-dark'>
<tr>
<th>Sections</th>
<?php
for($i=1;$i<=$number_of_hours_per_day;$i++)
{
    echo "<th>Hour".$i."</th>";
}
?>
</tr>
</thead>
<tbody>
<?php
$display_conn = new mysqli('localhost','root','',$_SESSION["hod_department"]);
// Check connection
if ($display_conn->connect_error) {
    die("Connection failed: " . $display_conn->connect_error);
}

for($j=0;$j<$no_of_sections;$j++){ 
    $sec=chr(65+$j);
    echo "<tr>";
    echo "<td>".$sec."</td>";
    for($i=1;$i<=$number_of_hours_per_day;$i++){
        $display_sql = "SELECT hour_count from year".$select_year."_hourwise where date='".$select_date."'and hour=".$i." and hour_section='".$sec."'";
        $display_result = $display_conn->query($display_sql);
        if($display_result->num_rows>0){
            $display_row = $display_result->fetch_assoc();
            echo "<td><a target='_blank' href='AbsenteesList.php?section=$sec&hour=$i&year=$select_year'>".$display_row["hour_count"]."</a></td>";
            $temporary=explode("/",$display_row["hour_count"]);
            $presentees[$j][$i-1]=(int)$temporary[0];
            $absentees[$j][$i-1]=(int)$temporary[1];
        }
        else{
            echo "<td>NA</td>";
            $presentees[$j][$i-1]="NA";
            $absentees[$j][$i-1]="NA";
        }
    }
    echo "</tr>";
}
echo "<tr><th>Total</th>";
for($j=0;$j<$number_of_hours_per_day;$j++){
    $count=0;
    $temp1=0;   //to store presentees;
    $temp2=0;   //to store Absentees;
    for($i=0;$i<$no_of_sections;$i++){
        if($presentees[$i][$j]=="NA")
            $count++;
        else{
            $temp1+=$presentees[$i][$j];
            $temp2+=$absentees[$i][$j];
        }
    }
    $temp=$j+1;
    if($count==$no_of_sections)
        echo "<td>NA</td>";
    else
        echo "<td><a target='_blank' href='AbsenteesList.php?hour=$temp&year=$select_year'>".$temp1."/".$temp2."</a></td>";
}
echo "</tr>";
?>
</tbody>
</table>
</div>
    <a href="HourInput.php">Back to Select Year Page</a>
</div>
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


</body>

</html>
