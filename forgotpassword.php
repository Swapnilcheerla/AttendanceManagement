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

<!--content-->

<div class="container">
  <h4>RESET PASSWORD</h4>

<?php
session_start();
$_SESSION["tablename"]=$_GET["authority"]."_login_info";
static $rand_number="";
if(!isset($_POST['submitmail']) and !isset($_POST['vcode']) and !isset($_POST['updatepwd']))
{
      
?>
    <form method="POST">
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" placeholder="Enter email" name="email" id="email">
  </div>
  <input type="submit" class="btn btn-primary" name="submitmail" value="Submit">
</form>
</div>




<?php
}
if(isset($_POST['submitmail']))
{
    require_once "Mail.php";
    $conn = new mysqli("localhost","root","","authority");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $tablename=$_SESSION["tablename"];
    if($tablename=="hod_login_info")
    {
    $sql = "SELECT hod_email from $tablename";
    }
    else{
        $sql = "SELECT staff_email from $tablename";
        
    }
    $result = $conn->query($sql);
    $flag=0;
    if ($result->num_rows > 0) 
    {
        if($tablename=="hod_login_info")
        {
            while( $row = $result->fetch_assoc()) 
            {
                    $hod_email=$row['hod_email'];
                    if(strcmp($hod_email,$_POST['email'])==0)
                    {   
                        $hod_email=$row['hod_email'];
                        $flag=1;
                        break;
                    }
                
            }
        }
        else{
            while( $row = $result->fetch_assoc()) 
            {
                    $hod_email=$row['staff_email'];
                    if(strcmp($hod_email,$_POST['email'])==0)
                    {   
                        $hod_email=$row['staff_email'];
                        $flag=1;
                        break;
                    }
                
            }


        }
        if($flag==1)
        {
            //mail code starts here
            $from = "cheerla.swapnilreddy@gmail.com";
            $to =$hod_email;
            $host = "ssl://smtp.gmail.com";
            $port = "465";
            $username = "mrecattendance@gmail.com";
            $password = "mrec@1234";
            $subject = "verification code ";
            for($i=0;$i<6;$i++)
            {   $X=rand(0,9);
                $GLOBALS['rand_number'] .=$GLOBALS['X'];
            }
            $_SESSION['rand']=$rand_number;
            $body="verification code:".$rand_number;
            $headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
            $smtp = Mail::factory('smtp',
            array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
            $mail = $smtp->send($to, $headers, $body);
            if (PEAR::isError($mail)) {
                echo($mail->getMessage());
                header("location:forgotpassword.php");
                
            } 
            else {

                echo"<div class='alert alert-success'>
                <strong> Success! </strong> Verification code  sent to  your mail !
              </div>";
                $_SESSION['hodmail']=$hod_email;
                //?>
                <div class="container">
                <form method="POST">
                <div class="form-group">                           
                <label for="vcode">verification code:</label>
                <input type="text" class="form-control" placeholder="Enter verification code" name="vcodetext">
                </div>
                <button type="submit" class="btn btn-primary" name="vcode">Submit</button>
                </form>
                </div>
                <br>

            
                <?php
            

                // vcode
                
                


            
            }



        }
        else{
            ?>
            <script> alert('Invalid or no user Exist');</script>
            <?php
            
            echo "<div class='alert alert-warning'>
            <strong> Warning! </strong>
          <a href='forgotpassword.php'> click here to re-enter!</a></div>";
            exit();
            
        }
    
    }


}

if(isset($_POST['vcode'])){
    $vcodetext=$_POST['vcodetext'];
    if(strcmp($vcodetext,$_SESSION['rand'])==0){
        // update password
        ?>
        <div class="container">
            <form method="POST" onsubmit="return validate()">
            <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="pwd">
            </div>
            <div class="form-group">
              <label for="pwd">Conform Password:</label>
              <input type="password" class="form-control" placeholder="Conform password" id="pwd1">
            </div>
            <div class="form-group form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember me
              </label>
            </div>
            <button type="submit" class="btn btn-primary" name="updatepwd">Submit</button>
            </form>
            </div>
            <br>




        <?php
    }
    else{
        echo"<script> window.alert('Enter correct code')</script>";
        echo "<div class='alert alert-warning'>
            <strong> Warning! </strong>
          <a href='forgotpassword.php'> click here to re-enter!</a></div>";
              exit();
            
    }

}
if(isset($_POST['updatepwd'])){
    $hod_email=$_SESSION['hodmail'];
    $pwd=$_POST['pwd'];
    $tablename=$_SESSION["tablename"];
    
    $conn = new mysqli("localhost","root","","authority");
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if($tablename=="hod_login_info")
        $sql = "UPDATE $tablename SET hod_password='".md5($pwd)."' WHERE hod_email='".$hod_email."'";
    else
        $sql="UPDATE $tablename SET staff_password='".md5($pwd)."' WHERE staff_email='".$hod_email."'";
    if ($conn->query($sql) === TRUE) {
        echo'<script> window.alert("updated successfully")</script>';
        echo "<div class='alert alert-success'>
            <strong> Success! </strong>
            <a href='HODLogin.php'>  click here login !</a></div>";
        

    } else {
        echo "<div class='alert alert-warning'>
            <strong> Warning! </strong>
          <a href='forgotpassword.php'> click here to re-enter!</a></div>";
    }

    $conn->close();

}

?>
<script>
function validate(){
    var pwd=document.getElementById("pwd").value;
    var pwd1=document.getElementById("pwd1").value;
    if(pwd!=pwd1){
        window.alert("enter correct password");
        return false;
    }
    return true;
}
</script>

<!--content-->        
        


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
