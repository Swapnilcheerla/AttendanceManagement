<?php
session_start();
if(!$_SESSION["staff_id"]){
  echo "<script>window.alert('Please Login');</script>";
  header('Location: StaffLogin.php');
}
else{

$option=$_POST["option"];
$select_year=$_POST[$option."year"];
$select_section=$_POST[$option."section"];
$select_department=$_POST[$option."department"];;
$select_subject=$_POST[$option."subject"];
$conn = new mysqli("localhost","root","", $select_department);
$sub_type_sql="select subject_type,number_of_hours_assigned from year".$select_year."_subject_info where subject_name='".$select_subject."'";
$sub_type_result = $conn->query($sub_type_sql);
$sub_type_row = $sub_type_result->fetch_assoc();
$sub_type=$sub_type_row['subject_type'];
$number_of_hours_assigned=$sub_type_row['number_of_hours_assigned'];

$no_of_dates=0;

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
                    <h5>Welcome <strong><?php echo $_SESSION["staff_name"];?></strong></h5>
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

  <!------->
 <div class="container" id="irr">
<?php

echo "<table border=1 id='register' class='table table-bordered' ><thead>";
//select student


// date for head of table
echo "<tr><th>student_id</th><th>student_name</th>";
if($sub_type=='L' or $sub_type=='N')
{
$date_sql = "select distinct(date) from year".$select_year."_hourwise  where hour_section='".$select_section."' and hour_subject='".$select_subject."'";
    $date_result = $conn->query($date_sql);
    while($date_row = $date_result->fetch_assoc()){
        
      echo "<th>".$date_row['date']."</th>";
      $dat[$no_of_dates]=$date_row['date'];
      $no_of_dates++;

    }
    echo "</tr></thead>";
}
else{
    $date_sql = "select date from year".$select_year."_hourwise  where hour_section='".$select_section."' and hour_subject='".$select_subject."'";
    $date_result = $conn->query($date_sql);
    while($date_row = $date_result->fetch_assoc()){
        
      echo "<th>".$date_row['date']."</th>";
      $dat[$no_of_dates]=$date_row['date'];
      $no_of_dates++;
    }
    echo "</tr></thead>";
}

if($sub_type=='L' or $sub_type=='N')
{
    
    $select_student_sql = "select student_id,student_name from year".$select_year."_student_info where student_section='".$select_section."'";
    $select_student_result = $conn->query($select_student_sql);
    while($select_student_row = $select_student_result->fetch_assoc())
    {
        echo "<tbody><tr>";
        $student_id=$select_student_row['student_id'];
        $student_name=$select_student_row['student_name'];
        echo "<td>".$student_id."</td>";
        echo "<td>".$student_name."</td>";
        
//select hour 
        for($i=0;$i<$no_of_dates;$i++)
        {
            $select_hour_sql = "select hour from year".$select_year."_hourwise  where hour_section='".$select_section."' and hour_subject='".$select_subject."' and date='".$dat[$i]."'";
            $select_hour_result = $conn->query($select_hour_sql);
            $select_hour_row = $select_hour_result->fetch_assoc();
            $select_hour=$select_hour_row['hour'];
    // check student present or absent 
            $check_sql = "select hour".$select_hour." from year".$select_year."_daily_attendance  where student_section='".$select_section."' and date='".$dat[$i]."' and student_id='".$student_id."'";

            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            echo "<td>".$check_row["hour".$select_hour]."</td>";
        
    

        }
    echo "</tr>";
    }
}


else
{
    $select_student_sql = "select student_id,student_name from year".$select_year."_student_info where student_section='".$select_section."'";
    $select_student_result = $conn->query($select_student_sql);
    while($select_student_row = $select_student_result->fetch_assoc())
    {
        echo "<tbody><tr>";
        $student_id=$select_student_row['student_id'];
        $student_name=$select_student_row['student_name'];
        echo "<td>".$student_id."</td>";
        echo "<td>".$student_name."</td>";
        $select_hour_sql = "select hour,date from year".$select_year."_hourwise  where hour_section='".$select_section."' and hour_subject='".$select_subject."'";
        $select_hour_result = $conn->query($select_hour_sql);

        while($select_hour_row = $select_hour_result->fetch_assoc())
        {
            $select_hour=$select_hour_row['hour'];
            $select_date=$select_hour_row['date'];
        // check student present or absent 
            $check_sql = "select hour".$select_hour." from year".$select_year."_daily_attendance  where student_section='".$select_section."' and date='".$select_date."' and student_id='".$student_id."'";
            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            echo "<td>".$check_row["hour".$select_hour]."</td>";
        }
        


    }
    echo "</tr>";


}
echo"<tbody></table>";




?>
<script src="assets/js/bootstrap.min_1.js" type="text/javascript"></script>
<script src="assets/js/FileSaver.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/tableexport.min.js" type="text/javascript"></script>

    
               
</div>
  <!---------------->
<div id="iv">
<script type="text/javascript">
$('#register').tableExport();
</script>
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
