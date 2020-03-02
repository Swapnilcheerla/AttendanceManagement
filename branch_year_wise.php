<?php
session_start();
if( !isset($_SESSION["p_email"]) ){
  header("location:Principallogin.php");
  exit();
}

?>

<?php
//current date 
$date=date("Y-m-d");
$select_branch =$_POST['department']; //principal selects
$select_hour=$_POST['hour']; // principal selects

// default values
$avg[1]=0; //1
$avg[2]=0;  //2
$avg[3]=0;  //3
$avg[4]=0;  //4


$conn = new mysqli("localhost","root","",$select_branch); // cse connection $select_branches
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//<...........better to keep loop here..hahahaha..>
for($i=3;$i<=3;$i++)
{
$presenties_sql = "SELECT count(hour".$select_hour.") FROM year".$i."_daily_attendance where hour".$select_hour."=1 and date="."'".$date."'";
//echo $presenties_sql;
$presenties_result = $conn->query($presenties_sql);
$presenties_row = $presenties_result->fetch_assoc();
$total_presenties=(float)$presenties_row["count(hour".$select_hour.")"];
$count_sql = "SELECT count(student_id) FROM year".$i."_student_info";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_count=(float)$count_row["count(student_id)"];
$average=($total_presenties/$total_count)*100;
$avg[$i]=$average;

}

$conn->close();

 
$dataPoints2 = array(
    array("label"=> "FIRST_YEAR", "y"=> $avg[1]),
    array("label"=> "SECOND_YEAR", "y"=> $avg[2]),
    array("label"=> "THIRD_YEAR", "y"=> $avg[3]),
    array("label"=> "FOURTH_YEAR", "y"=> $avg[4])
);
$dataPoints1 = array(
    array("label"=> "FIRST_YEAR", "y"=> (100-$avg[1])),
    array("label"=> "SECOND_YEAR", "y"=> (100-$avg[2])),
    array("label"=> "THIRD_YEAR", "y"=> (100-$avg[3])),
    array("label"=> "FOURTH_YEAR", "y"=> (100-$avg[4]))
);
    
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MREC </title>
    <link rel="stylesheet" type="text/css" href="modal.css">
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
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Daily</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="principalsidenav.html">All Branches</a></li>
                            <li><a href="Branchyearwise.php">Branch-year-wise</a></li>
                            <li><a href="Principalselect.php">Branch-section-wise</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Weekly</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="principalsidenav.html">All Branches</a></li>
                            <li><a href="principalsidenav.html">Branch-hour-wise</a></li>
                            <li><a href="principalsidenav.html">Branch-year-wise</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Monthly</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="branch_wise_monthly.php">All Branches</a></li>
                            <li><a href="principalsidenav.html">Branch-hour-wise</a></li>
                            <li><a href="principalsidenav.html">Branch-year-wise</a></li>
                        </ul>
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
                    <h4><strong><?php echo strtoupper($_SESSION["p_name"]);?></strong> </h4>
                     </h4>
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
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "<?php echo strtoupper($select_branch) ?> YEAR WISE ATTENDANCE"
    },
    legend:{
        cursor: "pointer",
        verticalAlign: "center",
        horizontalAlign: "right",
        itemclick: toggleDataSeries
    },
    data: [{
        type: "column",
        name: "Absenties Percentage",
        indexLabel: "{y}",
        yValueFormatString: "#0.##",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    },{
        type: "column",
        name: "Presenties Percentage",
        indexLabel: "{y}",
        yValueFormatString: "#0.##",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
function toggleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else{
        e.dataSeries.visible = true;
    }
    chart.render();
}
 
}
</script>


<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
    <script src="modal.js"></script>


</body>

</html>

