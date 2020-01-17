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
    <title>MREC|Assign Staff </title>
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
<!---content-->
<div class="container-fluid" id="asnstf">
    
<?php
if(!$_POST)
{
    $conn = new mysqli("localhost", "root", "", "authority");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT `staff_id`,`staff_name`,`staff_phone` FROM staff_login_info";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        
?>
<div class="alert alert-primary">
  <strong>Assign classes in next page.</strong> 
</div>
<div class="container">
    
    <p>Search for Staff Name or Staff Number:</p>  
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
</div>
<form method="POST">
<div class="container">
<table class="table table-bordered">
<thead>
<th>Staff Name</th>
<th>Staff Mobile</th>
</thead>
<tbody id="myTable">
<?php    
    while($row = $result->fetch_assoc()) {
            echo "<tr><td>";
            echo "<div class='form-check'>";
            echo "<label class='form-check-label' for='".$row["staff_id"]."'>";
            echo "<input type='radio' class='form-check-input' id='".$row["staff_id"]."' name='staff_id' value='".$row["staff_id"]."' required>".$row['staff_name'];
            echo "</label>";
            echo "</div></td>";
            echo "<td>".$row["staff_phone"]."</td></tr>";
        }
    echo "</tbody></table>";
    echo "<div class='form-group'>";
    echo "<label for='number_of_subjects'>No.of Sections handled by the faculty:</label>";
    echo "<input type='number' class='form-control' id='number_of_subjects' name='number_of_subjects' min='1' required placeholder='Ex: If staff goes for Third year A section and Third year B section input is 2'>";
    echo "</div>";
    echo "<div class='container'>";
    echo "<button type='submit' class='btn btn-primary'>Select Classes</button>";
    echo "</div>";
    } else {
        echo "<h4>No Staff Data Available</h4>";
    }
}
?>
</tbody>
</table>
</div>
</form>
<?php
if($_POST){
    $conn = new mysqli("localhost", "root", "", "authority");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT `staff_id`,`staff_name`,`staff_phone` FROM staff_login_info where `staff_id`='".$_POST["staff_id"]."' limit 1;";
    $result = $conn->query($sql);
    $staff_name="";
    if ($result->num_rows > 0) 
        while($row = $result->fetch_assoc())
            $staff_name=$row["staff_name"];
    $_SESSION["staff_id"]=$_POST["staff_id"];
    $_SESSION["staff_name"]=$staff_name;
    $_SESSION["number_of_subjects"]=$_POST["number_of_subjects"];
?>

<div class='container-fluid' id="asnstf2">
    <div class="alert alert-primary">
    <strong>Note:</strong> Subject1 and Subject2 might be same but for different classes
  </div>
<form action="UpdateStaffSubjects.php" method="POST" onsubmit="return validate()">
<?php
    for($i=1;$i<=$_POST["number_of_subjects"];$i++){
        $subject_id="subject".$i;
        echo "<h5><strong>Subject$i:</strong?</h5>";
?>
<div class="form-group">
    <label for='<?php echo $subject_id;?>'>Select Year :</label>    
    <select class="form-control" id='<?php echo $subject_id;?>' name='<?php echo $subject_id;?>'>
        <option selected value='0'>Select Year</option>
        <option value='1'>First Year</option>
        <option value='2'>Second Year</option>
        <option value='3'>Third Year</option>
        <option value='4'>Fourth Year</option>
    </select>
</div> 
<div class="form-group">
    <label for='<?php echo "section_for_".$subject_id;?>'>Select Section :</label>
    <select class="form-control" id='<?php echo "section_for_".$subject_id;?>' name='<?php echo "section_for_".$subject_id;?>'>
        <option selected disabled value='0' required>Select Section</option>
        <option value='A'>A</option>
        <option value='B'>B</option>
        <option value='C'>C</option>
        <option value='D'>D</option>
    </select>
</div>
<?php
    }
    echo "<button type='submit' name='submit' class='btn btn-primary'>Get Subject Data</button><form></div>";

}
?>
</form>
</div>
<script>
function validate() {
    var number_of_subjects='<?php echo $_SESSION["number_of_subjects"]; ?>';
    for(var i=1;i<=number_of_subjects;i++){
        if(document.getElementById("subject"+i).value=='0' || document.getElementById("section_for_subject"+i).value=='0'){
            alert("Subject"+i+" data is missing.");
            return false;
        }
        for(var j=1;j<i;j++){
            if(document.getElementById("subject"+j).value==document.getElementById("subject"+i).value && document.getElementById("section_for_subject"+i).value==document.getElementById("section_for_subject"+j).value){
                alert("Same Section has been assigned two or more times for the same Year.");
                return false;
            }
        }
    }
    
    return true;
}
</script>




</div>
<!--content-->

    </div><!-- /#right-panel -->
    </div>
    <!-- Left Panel -->
    <!-- Right Panel -->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

</html>

