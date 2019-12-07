<?php
session_start();
if($_POST){
  $conn = new mysqli("localhost", "root", "", "authority");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT hod_id,hod_name,hod_email,hod_department,hod_password FROM hod_login_info where hod_email='".$_POST["username"]."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      $password=MD5($_POST["password"]);
      while($row = $result->fetch_assoc()) {
          if($row["hod_password"]==$password){
            $_SESSION["hod_name"]=$row["hod_name"];
            $_SESSION["hod_email"]=$row["hod_email"];
            $_SESSION["hod_id"]=$row["hod_id"];
            $_SESSION["hod_department"]=$row["hod_department"];
            header('Location: HODHome.php');
          }
          else
          echo "<script>window.alert('Inavlid Password');</script>";
      }
} else {
    echo "<script>window.alert('No user exists with that email id');</script>";
}
$conn->close();
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
                        <a href="index.html">Principal Login </a>
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

     <div class="container" id="hlg">
  <h4><strong>HOD LOGIN</strong></h4>
  <form method="post" >
    <div class="form-group">
      <label for="usr">Name:</label>  
      <input type="email" class="form-control" id="usr" name="username"> <!-- Username Field-->
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" name="password"><!-- Password Field-->
    </div>
    <button type="submit" class="btn btn-primary" id="hlgsub">LOGIN</button><br><br>
      <a href="forgotpassword.php?authority=hod" id="fpwd">forgot password? </a>
  </form>

</div>
<br>




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
