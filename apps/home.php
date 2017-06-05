<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
require_once('../libs/Db.php'); //ติดต่อฐานข้อมูล
if(!empty($_SESSION['user'])){

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title>Back Office</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="../favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->



        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="../css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->
        <!-- font -->
        <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
        <!-- font -->
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.html">Back Office</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="../images/admin/<?=$_SESSION['user']['picture']?>" alt=""/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="../images/admin/<?=$_SESSION['user']['picture']?>" alt=""/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-title"><h5><?=$_SESSION['user']['name'];?>&nbsp;<?=$_SESSION['user']['surname'];?></h5></div>
                                <div class="profile-data-title"><h5><?=$_SESSION['user']['email'];?></h5></div>
                            </div>
                            <div class="profile-controls">
                                <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                        </div>
                    </li>

                    <li class="xn-title">Admin</li>
                    <li class="active">
                        <a href="home.php"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
                    </li>


                    <li class="xn-openable">
                      <a href="#">
                        <i class="fa fa-users"></i> <span><b>จัดการข้อมูลเนื้อหา</b></span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="home.php?file=activity/index"><i class="fa fa-circle-o"></i>จัดการข้อมูลสินค้า</a></li>
                        <li><a href="home.php?file=activity/add"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลกิจกรรม</a></li>
                      </ul>
                    </li>

                    <li class="xn-openable">
                      <a href="#">
                        <i class="fa fa-users"></i> <span><b>ระบบจัดการสินค้า</b></span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="home.php?file=product/index"><i class="fa fa-circle-o"></i>จัดการข้อมูลสินค้า</a></li>
                        <!-- <li><a href="home.php?file=product/form"><i class="fa fa-circle-o"></i>เพิ่มข้อมูลสินค้า</a></li> -->
                        <!-- <li><a href="home.php?file=activity/add"><i class="fa fa-circle-o"></i></a></li> -->
                      </ul>
                    </li>

                    <li class="xn-openable">
                      <a href="#">
                        <i class="fa fa-users"></i> <span><b>จัดการข้อมูลสไลด์</b></span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="home.php?file=slide/index"><i class="fa fa-circle-o"></i>เพิ่มข้อมูลสไลด์</a></li>
                        <!-- <li><a href="home.php?file=slide/add"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลกิจกรรม</a></li> -->
                      </ul>
                    </li>

                    <li class="xn-openable">
                      <a href="#">
                        <i class="fa fa-users"></i> <span><b>จัดการข้อมูลผู้ใช้</b></span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="home.php?file=user/index"><i class="fa fa-circle-o"></i>ข้อมูลผู้ใช้</a></li>
                        <li><a href="home.php?file=user/form"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลกิจกรรม</a></li>
                      </ul>
                    </li>

                    <li class="xn-openable">
                      <a href="#">
                        <i class="fa fa-users"></i> <span><b>จัดการข้อมูล FB</b></span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="home.php?file=facebook/index"><i class="fa fa-circle-o"></i>จัดการข้อมูล link facebook</a></li>
                        <!-- <li><a href="home.php?file=user/form"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลกิจกรรม</a></li> -->
                      </ul>
                    </li>


                    <li class="xn-text">
                      <a href="home.php?file=password/index&id=<?=$_SESSION['user']['member_id'];?>">
                        <i class="fa fa-lock"></i> <span><b>เปลี่ยนรหัสผ่าน</b></span>
                      </a>
                    </li>


                    <!-- <li class="xn-title">Components</li> -->

                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->

                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>
                    <!-- END SEARCH -->

                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                    </li>
                    <!-- END SIGN OUT -->
                    <!-- MESSAGES -->
                    <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-comments"></span></a>
                        <?php
                          $query = $db->prepare("SELECT * FROM booking INNER JOIN member_dp ON (booking.member_id=member_dp.member_id)

                             WHERE booking_status = 2");
                           $query->execute();//รัน sql
                           $notifi=$query->rowCount();
                          //  $notifi1=$query->rowCount();
                         ?>
                        <div class="informer informer-danger"><?php echo $notifi?></div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-bell"></span> Notifications</h3>
                                <div class="pull-right">
                                  <?php
                                    $query = $db->prepare("SELECT * FROM booking INNER JOIN member_dp ON (booking.member_id=member_dp.member_id)
                                                                                 INNER JOIN dorm ON (booking.dorm_id=dorm.dorm_id)
                                       WHERE booking_status = 2");
                                     $query->execute();//รัน sql
                                     $notifi=$query->rowCount();
                                    //  $notifi1=$query->rowCount();
                                   ?>
                                    <span class="label label-danger"><?php echo $notifi?> new</span>
                                </div>
                            </div>
                            <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                  <?php
                                    $query = $db->prepare("SELECT * FROM booking INNER JOIN member_dp ON (booking.member_id=member_dp.member_id)
                                                                                 INNER JOIN dorm ON (booking.dorm_id=dorm.dorm_id) WHERE booking_status = 2");
                                     $query->execute();//รัน sql
                                     if($query->rowCount()>0){
                                     $data = $query->fetchAll(PDO::FETCH_OBJ);
                                     foreach ($data as $k => $row ) {
                                       ?>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-online"></div>
                                    <!-- <img src="assets/images/users/user2.jpg" class="pull-left" alt="John Doe"/> -->
                                    <span class="contacts-title"><?=$row->name?> <?=$row->surname?></span>
                                    <p>จองหอพัก <?=$row->dorm_name?></p>
                                </a>
                                <?php
                                    }
                                  }
                                 ?>
                            </div>
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">Show all messages</a>
                            </div>

                        </div>
                    </li>
                    <!-- END MESSAGES -->
                    <!-- TASKS -->
                    <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-tasks"></span></a>
                        <div class="informer informer-warning">3</div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>
                                <div class="pull-right">
                                    <span class="label label-warning">3 active</span>
                                </div>
                            </div>
                            <div class="panel-body list-group scroll" style="height: 200px;">
                                <a class="list-group-item" href="#">
                                    <strong>Phasellus augue arcu, elementum</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 25 Sep 2014 / 50%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Aenean ac cursus</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
                                    </div>
                                    <small class="text-muted">Dmitry Ivaniuk, 24 Sep 2014 / 80%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Lorem ipsum dolor</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">95%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 23 Sep 2014 / 95%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Cras suscipit ac quam at tincidunt.</strong>
                                    <div class="progress progress-small">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 21 Sep 2014 /</small><small class="text-success"> Done</small>
                                </a>
                            </div>
                            <div class="panel-footer text-center">
                                <a href="pages-tasks.html">Show all tasks</a>
                            </div>
                        </div>
                    </li>
                    <!-- END TASKS -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                  <section class="content">
                    <div class="row">
                      <div class="col-md-12">
                        <?php
                        if(isset($_GET['file'])){
                         $app_file = $_GET['file'].'.php';
                          if(is_file($app_file)){
                            include_once($app_file);
                          }else{
                            echo 'ไม่พบเนื้อหา 404!!!';
                          }
                        }else {
                          include_once('dashboard.php');
                        }
                        ?>
                      </div>
                    </div>
                  </section>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="../audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="../audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src='../js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="../js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        <script type="text/javascript" src="../js/plugins/datatables/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="../js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="../js/plugins/morris/morris.min.js"></script>
        <script type="text/javascript" src="../js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="../js/plugins/rickshaw/rickshaw.min.js"></script>
        <script type='text/javascript' src='../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
        <script type='text/javascript' src='../js/plugins/bootstrap/bootstrap-datepicker.js'></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="../js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="../js/plugins/owl/owl.carousel.min.js"></script>

        <script type="text/javascript" src="../js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="../js/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="../js/settings.js"></script>

        <script type="text/javascript" src="../js/plugins.js"></script>
        <script type="text/javascript" src="../js/actions.js"></script>

        <script type="text/javascript" src="../js/demo_dashboard.js"></script>



        <script type="text/javascript" src="../js/plugins/summernote/summernote.js"></script>

        <!-- dataTables -->

        <!-- dataTables -->

        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->




    </body>
</html>

<?php
 } else{
   header('location: ../index.php');
}?>
