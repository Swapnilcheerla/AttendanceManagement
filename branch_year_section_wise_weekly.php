<?php
session_start();
if( !isset($_SESSION["p_email"]) ){
  header("location:Principallogin.php");
  exit();
}

?>
<?php
$present_date=date("Y-m-d");
$day=date("l");
$last_week_day = date( 'Y-m-d', strtotime("".$day." -1 week"));//week 

$dbname=$_POST['department']; // select from principal
$conn = new mysqli("localhost","root","",$dbname);
//if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$year_select=$_POST['year']; // select from principal
// select from principal 
$select_hour=$_POST['hour']; // selct from principal
$year_student_count=$year_select; // selct from principal

// default values
$avg[0]=0; //A
$avg[1]=0;	//B
$avg[2]=0;  //C
$avg[3]=0;  //D



// selecting distict section in an year
$sql = "SELECT DISTINCT student_section FROM year".$year_student_count."_student_info order by student_section";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	$c=0;
    while($row = $result->fetch_assoc()) {
		$section[$c]=$row["student_section"]; // A B C D
		$c++;
    }
} else {
    echo "0 results";
}
//echo "count= ".$c."\n";

for($i=0;$i<$c;$i++)
{
// <................  section ..............>
$SECTION_sql = "SELECT count(hour".$select_hour.") FROM year".$year_select."_daily_attendance where hour".$select_hour."=1 and date BETWEEN '".$last_week_day."' AND '".$present_date."' and student_section='".$section[$i]."'";
$SECTION_result = $conn->query($SECTION_sql);
$SECTION_row = $SECTION_result->fetch_assoc();
$select_row="count(hour".$select_hour.")";
$section_avg=(float)$SECTION_row[$select_row];
//echo $section_avg."\n";

//total no of student in class

$SECTION_count = "SELECT count(student_id) FROM year".$year_student_count."_student_info where student_section='".$section[$i]."' ";
$SECTION_count_result = $conn->query($SECTION_count);
$SECTION_row_count = $SECTION_count_result->fetch_assoc();
$total_count=(float)$SECTION_row_count["count(student_id)"];
//echo "total".$total_count;

//total no of days in week
$no_days_sql = "SELECT count(DISTINCT date) FROM year".$year_select."_daily_attendance where date BETWEEN '".$last_week_day."' AND '".$present_date."'";
$no_days_result = $conn->query($no_days_sql);
$no_days_row = $no_days_result->fetch_assoc();
$no_days_count=(float)$no_days_row["count(DISTINCT date)"];




$average=($section_avg/(($total_count)*($no_days_count)))*100;
$avg[$i]=$average;
}
$dataPoints1= array( );
$dataPoints2= array( );

for ($i=0; $i <$c; $i++) {

	$dataPoints1[] = array(
		"label"=>$section[$i]." SECTION","y"=>(100-$avg[$i])
	   );
 
	$dataPoints2[] = array(
	 "label"=>$section[$i]." SECTION","y"=>$avg[$i]
	);
	  }
  	
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
                            <li><a href="principalsidenav.html">Branch-year-wise</a></li>
                            <li><a href="#" id="modal-btn">Branch-section-wise</a></li>
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
		text: "<?php echo strtoupper($dbname)?> YEAR<?php echo $year_select?> WEEKLY SECTION WISE ATTENDANCE"
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

