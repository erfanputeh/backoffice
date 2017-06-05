<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../libs/Db.php'); //ติดต่อฐานข้อมูล
if(!empty($_SESSION['user'])){

?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <?php
          include_once('../libs/Db.php');
        ?>

        <?php
          $query = $db->prepare("SELECT DATE FROM counter LIMIT 0,1");
          $query->execute();
          $query1=$query->rowCount();
          if($query1["DATE"] != date("Y-m-d")){
              //*** บันทึกข้อมูลของเมื่อวานไปยังตาราง daily ***//
              $query = $db->prepare (" INSERT INTO daily
                (DATE,NUM) SELECT '".date('Y-m-d',strtotime("-1 day"))."',COUNT(*) AS intYesterday FROM  counter WHERE 1 AND DATE = '".date('Y-m-d',strtotime("-1 day"))."'");
              $query->execute();

              $query = $db->prepare (" DELETE FROM counter WHERE DATE != '".date("Y-m-d")."' ");
              $query->execute();
            }

              $query = $db->prepare (" INSERT INTO counter (DATE,IP) VALUES ('".date("Y-m-d")."','".$_SERVER["REMOTE_ADDR"]."') ");
              $query->execute();

              ?>
        <!-- START PAGE CONTAINER -->
        <div class="page-content-wrap">
          <!-- START WIDGETS -->
          <div class="row">

              <div class="col-md-3">
                  <!-- START WIDGET SLIDER -->
                  <div class="widget widget-default widget-carousel">
                      <div class="owl-carousel" id="owl-example">

                        <div>
                          <?php
                              $query = $db->prepare(" SELECT COUNT(DATE) AS CounterToday FROM counter WHERE DATE = '".date("Y-m-d")."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                              foreach ($data as $k => $row ) {
                                ?>


                            <div class="widget-title">ผู้เข้าชมวันนี้</div>
                            <div class="widget-subtitle">จำนวน</div>
                            <div class="widget-int"><?=$row->CounterToday?></div>

                            <?php
                              }
                            }
                            ?>
                        </div>

                        <div>

                          <?php
                              //yesterday//
                              $query = $db->prepare(" SELECT NUM FROM daily WHERE DATE = '".date('Y-m-d',strtotime("-1 day"))."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($data as $k => $row ) {
                            ?>

                            <div class="widget-title">ผู้เข้าชมเมื่อวาน</div>
                            <div class="widget-subtitle">จำนวน</div>
                            <div class="widget-int"><?=$row->NUM?></div>
                            <?php
                              }
                            }
                            ?>
                        </div>

                        <div>
                          <?php
                              //This Month//
                              $query = $db->prepare(" SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m')."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                              foreach ($data as $k => $row ) {
                            ?>
                            <div class="widget-title">ผู้เข้าชมเดือนนี้</div>
                            <div class="widget-subtitle">จำนวน</div>
                            <div class="widget-int"><?=$row->CountMonth?></div>
                            <?php
                              }
                            }
                            ?>
                        </div>


                        <div>
                          <?php
                              //last Month//
                              $query = $db->prepare(" SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m',strtotime("-1 month"))."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                              foreach ($data as $k => $row ) {
                            ?>
                              <div class="widget-title">ผู้เข้าชมเดือนที่แล้ว</div>
                              <div class="widget-subtitle">จำนวน</div>
                              <div class="widget-int"><?=$row->CountMonth?></div>
                            <?php
                              }
                            }
                            ?>
                        </div>

                        <div>
                          <?php
                              //this year//
                              $query = $db->prepare(" SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y')."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                              foreach ($data as $k => $row ) {
                            ?>
                              <div class="widget-title">ผู้เข้าชมปีนี้</div>
                              <div class="widget-subtitle">จำนวน</div>
                              <div class="widget-int"><?=$row->CountYear?></div>
                            <?php
                              }
                            }
                            ?>
                        </div>

                        <div>
                          <?php
                              //last year//
                              $query = $db->prepare(" SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y',strtotime("-1 year"))."' ");
                              $query->execute();
                              if($query->rowCount()>0){
                              $data = $query->fetchAll(PDO::FETCH_OBJ);
                              foreach ($data as $k => $row ) {
                            ?>
                              <div class="widget-title">ผู้เข้าชมปีที่แล้ว</div>
                              <div class="widget-subtitle">จำนวน</div>
                              <div class="widget-int"><?=$row->CountYear?></div>
                            <?php
                              }
                            }
                            ?>
                        </div>

                      </div>
                      <div class="widget-controls">
                          <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                      </div>
                  </div>
                  <!-- END WIDGET SLIDER -->
              </div>

              <div class="col-md-3">
                  <!-- START WIDGET MESSAGES -->
                  <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                      <div class="widget-item-left">
                          <span class="fa fa-envelope"></span>
                      </div>
                      <div class="widget-data">
                          <div class="widget-int num-count">48</div>
                          <div class="widget-title">New messages</div>
                          <div class="widget-subtitle">In your mailbox</div>
                      </div>
                      <div class="widget-controls">
                          <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                      </div>
                  </div>
                  <!-- END WIDGET MESSAGES -->

              </div>

              <div class="col-md-3">
                  <!-- START WIDGET REGISTRED -->
                  <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                      <div class="widget-item-left">
                          <span class="fa fa-user"></span>
                      </div>
                      <?php
                        $query = $db->prepare("SELECT * FROM member_dp WHERE level = 2");
                        $query->execute();//รัน sql
                        $rowcount=$query->rowCount();
                       ?>
                      <div class="widget-data">
                          <div class="widget-int num-count"><?php echo $rowcount?></div>
                          <div class="widget-title">Registred users</div>
                          <div class="widget-subtitle">On your website</div>
                      </div>

                      <div class="widget-controls">
                          <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                      </div>
                  </div>
                  <!-- END WIDGET REGISTRED -->
              </div>

              <div class="col-md-3">
                  <!-- START WIDGET CLOCK -->
                  <div class="widget widget-info widget-padding-sm">
                      <div class="widget-big-int plugin-clock">00:00</div>
                      <div class="widget-subtitle plugin-date">Loading...</div>
                      <div class="widget-controls">
                          <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                      </div>
                      <div class="widget-buttons widget-c3">
                          <div class="col">
                              <a href="#"><span class="fa fa-clock-o"></span></a>
                          </div>
                          <div class="col">
                              <a href="#"><span class="fa fa-bell"></span></a>
                          </div>
                          <div class="col">
                              <a href="#"><span class="fa fa-calendar"></span></a>
                          </div>
                      </div>
                  </div>
                  <!-- END WIDGET CLOCK -->
              </div>
          </div>
          <!-- END WIDGETS -->

          <div class="row">
              <div class="col-md-4">

                  <!-- START USERS ACTIVITY BLOCK -->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="panel-title-box">
                              <h3>Users Activity</h3>
                              <span>Users vs returning</span>
                          </div>
                          <ul class="panel-controls" style="margin-top: 2px;">
                              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                              <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                      <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                      <div class="panel-body padding-0">
                          <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
                      </div>
                  </div>
                  <!-- END USERS ACTIVITY BLOCK -->

              </div>

              <div class="col-md-4">

                  <!-- START VISITORS BLOCK -->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="panel-title-box">
                              <h3>Visitors</h3>
                              <span>Visitors (last month)</span>
                          </div>
                          <ul class="panel-controls" style="margin-top: 2px;">
                              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                              <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                      <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                      <div class="panel-body padding-0">
                          <div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
                      </div>
                  </div>
                  <!-- END VISITORS BLOCK -->

              </div>

              <div class="col-md-4">

                  <!-- START PROJECTS BLOCK -->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="panel-title-box">
                              <h3>ประวัติการเข้าใช้งานของผู้ใช้</h3>
                              <span>ผู้ใช้งาน</span>
                          </div>
                          <ul class="panel-controls" style="margin-top: 2px;">
                              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                              <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                      <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                      <div class="panel-body"  style="height: 230px;">


                          <div class="table-responsive">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="50%">ผู้ใช้งาน</th>
                                          <th width="20%">IP address</th>
                                          <th width="30%">วัน เวลา ที่เข้าใช้งาน</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $query = $db->prepare("SELECT * FROM member_dp INNER JOIN counter WHERE level = 1 ");//เตรียมคำสั่ง sql
                                    $query->execute();

                                    if($query->rowCount()>0){

                                    $data = $query->fetchAll(PDO::FETCH_OBJ);
                                    // foreach ($data as $k => $row ) {
                                      ?>
                                      <tr role="row" class="odd">
                                        <td><?=$_SESSION['user']['name'];?>&nbsp;&nbsp;<?=$_SESSION['user']['surname'];?></td>
                                        <td><span class="label label-success"><?=$_SESSION['ip'];?></span></td>
                                        <td><?=$_SESSION['date'];?></td>
                                      </tr>
                                      <?php
                                      }
                                    ?>
                                  </tbody>
                              </table>
                          </div>

                      </div>
                  </div>
                  <!-- END PROJECTS BLOCK -->

              </div>
          </div>

          <div class="row">
            <div class="col-md-8">

                  <!-- START SALES BLOCK -->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="panel-title-box">
                              <h3>Sales</h3>
                              <span>Sales activity by period you selected</span>
                          </div>
                          <ul class="panel-controls panel-controls-title">
                              <li>
                                  <div id="reportrange" class="dtrange">
                                      <span></span><b class="caret"></b>
                                  </div>
                              </li>
                              <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
                          </ul>

                      </div>
                      <div class="panel-body">
                          <div class="row stacked">
                              <div class="col-md-4">
                                  <div class="progress-list">
                                      <div class="pull-left"><strong>In Queue</strong></div>
                                      <div class="pull-right">75%</div>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">75%</div>
                                      </div>
                                  </div>
                                  <div class="progress-list">
                                      <div class="pull-left"><strong>Shipped Products</strong></div>
                                      <div class="pull-right">450/500</div>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">90%</div>
                                      </div>
                                  </div>
                                  <div class="progress-list">
                                      <div class="pull-left"><strong class="text-danger">Returned Products</strong></div>
                                      <div class="pull-right">25/500</div>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">5%</div>
                                      </div>
                                  </div>
                                  <div class="progress-list">
                                      <div class="pull-left"><strong class="text-warning">Progress Today</strong></div>
                                      <div class="pull-right">75/150</div>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                      </div>
                                  </div>
                                  <p><span class="fa fa-warning"></span> Data update in end of each hour. You can update it manual by pressign update button</p>
                              </div>
                              <div class="col-md-8">
                                  <div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END SALES BLOCK -->

              </div>
  <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
      <ul class="list-inline item-details">
        <li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
        <li><a href="http://themescloud.org">Bootstrap themes</a></li>
      </ul>
    </div>
  </div>

              <div class="col-md-4">

                  <!-- START SALES & EVENTS BLOCK -->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="panel-title-box">
                              <h3>Sales & Event</h3>
                              <span>Event "Purchase Button"</span>
                          </div>
                          <ul class="panel-controls" style="margin-top: 2px;">
                              <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                              <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                      <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                      <div class="panel-body padding-0">
                          <div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
                      </div>
                  </div>
                  <!-- END SALES & EVENTS BLOCK -->

              </div>
          </div>

          <!-- START DASHBOARD CHART -->
        <!-- <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div> -->
        <div class="block-full-width">

          </div>
          <!-- END DASHBOARD CHART -->

        </div>
        <!-- END PAGE CONTAINER -->



    </body>
</html>





<?php
 } else{
   header('location: ../index.php');
}?>
