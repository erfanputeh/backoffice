<?php
$db_host = 'localhost'; // Sever database
$db_name = 'backoffice_db'; // ฐานข้อมูล
$db_user = 'root'; // ชื่อผู้ใช้
$db_pass = ''; // รหัสผ่าน
$db = null;

try { // ให้พยายามทำงานคำสั่งต่อไปนี้
  $db = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
  $db->exec("SET CHARACTER SET utf8"); // ให้รองรับภาษาไทย
  // echo "ติดต่อฐานข้อมูลได้แล้ว เย้!";
}catch (PDOException $e) { //กรณีทำงานผิดพลาด
  echo "พบปัญหา : ".$e->getMessage(); //แสดง Error
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
     <head>
         <!-- META SECTION -->
         <title>Back Office</title>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="X-UA-Compatible" content="IE=edge" />
         <meta name="viewport" content="width=device-width, initial-scale=1" />

         <link rel="icon" href="../../favicon.ico" type="image/x-icon" />
         <!-- END META SECTION -->



         <!-- CSS INCLUDE -->
         <link rel="stylesheet" type="text/css" id="theme" href="../../css/theme-default.css"/>
         <!-- EOF CSS INCLUDE -->
         <!-- font -->
         <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
         <!-- font -->
     </head>
     <body>


       <?php
       if(isset($_POST['update'])){
         $query = $db->prepare("UPDATE category SET
           category_name = :category_name
         WHERE category.category_id = :id ;");

         $result = $query->execute([
         "id" => $_GET["id"],
         'category_name' => $_POST["category_name"]
         ]);
       if($result){
           echo "<script>alert('Update Successfully')
                 window.location = 'index.php';
                 </script>";
       }else{
           echo "<script>
                 alert('Update fail! '".$query->errorInfo()[2].");
                 </script>";
       }
       }

       if(isset($_GET['id'])){
       $query = $db->prepare("SELECT * FROM category WHERE category_id = :id");
       $query->execute([
       'id'=>$_GET['id']
       ]);//รัน sql
           $data = $query->fetch(PDO::FETCH_OBJ);
         }
       ?>



  <section class="content">
    <!-- <div class="page-content-wrap"> -->

        <div class="row">
            <div class="col-md-12">

                <form class="form-horizontal" method="post" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title"><strong>แก้ไขข้อมูลประเภทสินค้า</strong> </h3>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">ชื่อประเภทสินค้า</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control" name="category_name" value="<?=$data->category_name?>"/>
                                </div>
                                <!-- <span class="help-block">This is sample of text field</span> -->
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default" type="reset">Clear Form</button>
                        <button class="btn btn-primary pull-right" type="submit" name="update">Submit</button>
                    </div>
                </div>
                </form>

            </div>
        </div>

    <!-- </div> -->

  </section>


  <section class="content">
  <div class="row">
          <div class="col-md-12">

                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">ข้อมูลประเภทสินค้า</h3>
                                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                </ul>
                            </div>

                           <div class="panel-body">
                             <table class="table table-hover" id="" role="grid" >
                                 <thead>
                                     <tr>
                                         <th>ลำดับ</th>
                                         <th>ประเภทสินค้า</th>
                                         <th>จัดการ</th>

                                     </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                   $query = $db->prepare("SELECT * FROM category");
                                   $query->execute();

                                   if($query->rowCount()>0){

                                   $data = $query->fetchAll(PDO::FETCH_OBJ);
                                   foreach ($data as $k => $row ) {
                                     ?>
                                     <tr>
                                       <td><?=($k+1)?></td>
                                       <td><?=$row->category_name?></td>
                                       <td>
                                         &nbsp;&nbsp;<a href="update.php?id=<?=$row->category_id?>"><i class='fa fa-pencil-square-o'></i></a>&nbsp;
                                         <a href="index.php?id=<?=$row->category_id?>"><i class='fa fa-trash-o'></i></a>
                                       </td>
                                     </tr>
                                     <?php
                                       }
                                     }
                                   ?>
                                 </tbody>
                             </table>
                           </div> <!--panel-body-->

     </div>  <!--panel panel-default-->
<!-- END DEFAULT DATATABLE -->

   </div> <!--col-->
 </div> <!--row-->

</script>
</section>



  <!-- START PRELOADS -->
  <audio id="audio-alert" src="../../audio/alert.mp3" preload="auto"></audio>
  <audio id="audio-fail" src="../../audio/fail.mp3" preload="auto"></audio>
  <!-- END PRELOADS -->

<!-- START SCRIPTS -->
  <!-- START PLUGINS -->
  <script type="text/javascript" src="../../js/plugins/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/plugins/jquery/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../../js/plugins/bootstrap/bootstrap.min.js"></script>
  <!-- END PLUGINS -->

  <!-- START THIS PAGE PLUGINS-->
  <script type='text/javascript' src='../../js/plugins/icheck/icheck.min.js'></script>
  <script type="text/javascript" src="../../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
  <script type="text/javascript" src="../../js/plugins/scrolltotop/scrolltopcontrol.js"></script>
  <script type="text/javascript" src="../../js/plugins/datatables/jquery.dataTables.min.js"></script>

  <script type="text/javascript" src="../../js/plugins/morris/raphael-min.js"></script>
  <script type="text/javascript" src="../../js/plugins/morris/morris.min.js"></script>
  <script type="text/javascript" src="../../js/plugins/rickshaw/d3.v3.js"></script>
  <script type="text/javascript" src="../../js/plugins/rickshaw/rickshaw.min.js"></script>
  <script type='text/javascript' src='../../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
  <script type='text/javascript' src='../../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
  <script type='text/javascript' src='../../js/plugins/bootstrap/bootstrap-datepicker.js'></script>
  <script type="text/javascript" src="../../js/plugins/bootstrap/bootstrap-file-input.js"></script>
  <script type="text/javascript" src="../../js/plugins/bootstrap/bootstrap-select.js"></script>
  <script type="text/javascript" src="../../js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
  <script type="text/javascript" src="../js/plugins/owl/owl.carousel.min.js"></script>

  <script type="text/javascript" src="../../js/plugins/moment.min.js"></script>
  <script type="text/javascript" src="../../js/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- END THIS PAGE PLUGINS-->

  <!-- START TEMPLATE -->
  <script type="text/javascript" src="../../js/settings.js"></script>

  <script type="text/javascript" src="../../js/plugins.js"></script>
  <script type="text/javascript" src="../../js/actions.js"></script>

  <script type="text/javascript" src="../../js/demo_dashboard.js"></script>



  <script type="text/javascript" src="../js/plugins/summernote/summernote.js"></script>

  <!-- dataTables -->

  <!-- dataTables -->

  <!-- END TEMPLATE -->
<!-- END SCRIPTS -->

</body>
</html>
