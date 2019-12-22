<?php
session_start();
if(!isset($_SESSION["staff_key"])){
    header("Location: KeyVerification.php");
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
                        <a href="Principallogin.php">Principal Login </a>
                    </li>
                    <li class="active">
                        <a href="HODLogin.php">HOD Login</a>
                    </li>
                    <li class="active">
                        <a href="StaffLogin.php">Staff Login</a>
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
                        
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <?php
if(!$_POST){
?>
<div class="container">
  <h4>Staff Registration</h4>
  <form method="POST" onsubmit="return validate()" name="f1" >
  <div class="form-group">
      <label for="usr">Name:</label>
      <input type="text" class="form-control" id="usr" name="username" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="number">Mobile Number:</label>
      <input type="number" class="form-control" id="number" name="number" required>
    </div>
    <div class="form-group">
      <label for="pwd1">Password:</label>
      <input type="password" class="form-control" id="pwd1" name="pwd1" required>
    </div>
    <div class="form-group">
      <label for="pwd2">ConfirmPassword:</label>
      <input type="password" class="form-control" id="pwd2" name="pwd2" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit" >Submit</button>
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
<script>
function validate(){
    if(document.f1.number.value.length!="10"){
        window.alert("Number should be exactly 10 digits.");
        return false;
    }
    if(document.f1.pwd1.value.length<8){
        window.alert("Minimum password length is 8 characters.");
        return false;
    }
    if(document.f1.pwd1.value!=document.f1.pwd2.value){
        window.alert("Passwords did not match.");
        return false;
    }
    return true;
}
</script>
<?php
}
if(isset($_POST["submit"])){
  $staff_name=$_POST["username"];
  $staff_email=$_POST["email"];
  $staff_phone=$_POST["number"];
  $staff_password=md5($_POST["pwd1"]);
  $conn = new mysqli("localhost", "root", "", "authority");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql="select staff_name from staff_login_info where staff_email='$staff_email'";
  $result = $conn->query($sql);
  if($result->num_rows >0){
    echo "<div class='alert alert-danger'>";
    echo "<strong>A staff with the mail id:$staff_email already exists!</strong> Please enter your details once again <a href='StaffRegistration.php' class='alert-link'>here</a>.";
    echo "</div>";
    if(isset($_SESSION["staff_key"]))
      unset($_SESSION['staff_key']);
    exit();
  }
  $sql="insert into staff_login_info(`staff_name`,`staff_email`,`staff_phone`,`staff_password`) values ('$staff_name','$staff_email','$staff_phone','".$staff_password."')";
  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>";
    echo "<strong>Registration Successful!</strong> Click <a href='StaffLogin.php' class='alert-link'>here</a> to login.";
     unset($_SESSION['staff_key']);
    echo "</div>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

</body>

</html>
