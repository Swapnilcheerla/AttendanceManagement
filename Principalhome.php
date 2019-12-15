<?php
session_start();
if( !isset($_SESSION["p_email"]) ){
  header("location:Principallogin.php");
  exit();
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
                            <li><a href="branchwise.php">All Branches</a></li>
                            <li><a href="Branchyearwise.php">Branch-year-wise</a></li>
                            <li><a href="Principalselect.php">Branch-section-wise</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Weekly</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="weeklybranch.php">All Branches</a></li>
                            <li><a href="weeklybranchyear.php">Branch-year-wise</a></li>
                            <li><a href="weeklybranchyearsection.php">Branch-year-section-wise</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Monthly</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="monthlybranchwise.php">All Branches</a></li>
                            <li><a href="monthlybranchyear.php">Branch-hour-wise</a></li>
                            <li><a href="monthlybranchyearsection.php">Branch-year-wise</a></li>
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

<div class="container">
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div id="my-modal" class="modal ">
                            <div class="modal-content wow zoomIn" id="mdid">
                              <div class="modal-header">
                                <h2 id="mdlg" class="text-fluid text-center"><strong>ATTENDENCE</strong></h2>
                                <span class="close" id="closebutton">&times;</span>
                                
                              </div>
                                  <div class="modal-body">
                                            <div class="main-agileinfo">
                                              <div class="agileits-top">
                                                <form action="branch_year_section_wise.php" method="post">
                                                    <label for="department">select department</label>
                                                  <select name="department" class="select">
                                                        <option value="cse">CSE</option>
                                                        <option value="me">ME</option>
                                                        <option value="ce">CE</option>
                                                        <option value="it">IT</option>
                                                        <option value="eee">EEE</option>
                                                        <option value="ece">ECE</option>
                                                        <option value="min">MIN</option>
                                                      </select>
                                                      <br>
                                                      <label for="year">select year</label>
                                                  <select name="year" class="select">
                                                        <option value="1">year1</option>
                                                        <option value="2">year2</option>
                                                        <option value="3">year3</option>
                                                        <option value="4">year4</option>
                                                      </select>
                                                      <br>
                                                      <label for="section">select section</label>
                                                  <select name="section" class="select">
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                      </select>
                                                      <br>
                                                  
                                                  <input type="submit" value="GET LIST">
                                                </form>
                                              </div>
                                            </div>
    
                                  </div>
                                <!--  
                                 <div class="modal-footer">
                                  <a href="registration.html" class="text-fluid" target="_blank">don't have an account? Signup</a>
                                </div>  -->
                        </div>
                        </div>
                </div>
              </div>
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
    <script src="modal.js"></script>


</body>

</html>

