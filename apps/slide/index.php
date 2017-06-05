<?php
date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['ok'])) {
    $objective_dir = "D:/xampp/htdocs/backoffice/images/slide/";
    $objective_file = $objective_dir . basename($_FILES["slide_img"]["name"]);
    $uploadsuccess = 1;
    $pictureFileType = pathinfo($objective_file,PATHINFO_EXTENSION);

    //ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Ymd");
    //ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['slide_img']['name'],".");
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newfilename = $date.$numrand.$type;
    $path_copy = $objective_dir.$newfilename;

    $check = getimagesize($_FILES["slide_img"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadsuccess = 1;
    } else {
      echo "File is not an image.";
      $uploadsuccess = 0;
    }

    // เช็คไฟล์เมื่อไฟล์นั่นมีอยู่แล้ว
    if (file_exists($objective_file)) {
        echo "Sorry, file already exists.";
        $uploadsuccess = 0;
    }
    // เช็คขนาดรูป
    if ($_FILES["slide_img"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadsuccess = 0;
    }
    // อนุญาติไฟล์ชนิดใดบ้างที่สามารถใช้ได้
    //
    if($pictureFileType != "jpg" && $pictureFileType != "png" && $pictureFileType != "gif" && $pictureFileType != "jpeg" && $pictureFileType != "JPG" && $pictureFileType != "PNG" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadsuccess = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadsuccess == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["slide_img"]["tmp_name"], $path_copy)) {

      $query = $db->prepare('INSERT INTO slide (slide_no, slide_alt, slide_img, newslide_img)
                            values(:slide_no ,:slide_alt ,:slide_img ,:newslide_img )');
      $res = $query->execute([
        'slide_no' =>$_POST['slide_no'],
        'slide_alt' =>$_POST['slide_alt'],
        'slide_img'=>$_FILES['slide_img']['name'],
        "newslide_img"=> $newfilename,
          ]);
          if ($res) {
            echo "<script>
                    alert('เพิ่มข้อมูลบุคลากรเรียบร้อย')
                    window.location = 'home.php?file=slide/index';
                  </script>";
          }else {
            echo "<script>
                    alert('ผิดพลาด '".$query->errorInfo()[2].");
                  </script>";
      } // else
    } //move_uploaded_file
  }
} //ok
?>


<section class="content">
  <!-- <div class="page-content-wrap"> -->

      <div class="row">
          <div class="col-md-12">

              <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="panel panel-default">
                  <div class="panel-heading ui-draggable-handle">
                      <h3 class="panel-title"><strong>จัดการข้อมูลสไลด์</strong> </h3>
                      <ul class="panel-controls">
                          <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                      </ul>
                  </div>
                  <!-- <div class="panel-body">
                      <p>This is non libero bibendum, scelerisque arcu id, placerat nunc. Integer ullamcorper rutrum dui eget porta. Fusce enim dui, pulvinar a augue nec, dapibus hendrerit mauris. Praesent efficitur, elit non convallis faucibus, enim sapien suscipit mi, sit amet fringilla felis arcu id sem. Phasellus semper felis in odio convallis, et venenatis nisl posuere. Morbi non aliquet magna, a consectetur risus. Vivamus quis tellus eros. Nulla sagittis nisi sit amet orci consectetur laoreet. Vivamus volutpat erat ac vulputate laoreet. Phasellus eu ipsum massa.</p>
                  </div> -->
                  <div class="panel-body">

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ชื่อสไลด์</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" name="slide_alt"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>


                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ลำดับที่ต้องการแสดง</label>
                          <div class="col-md-6 col-xs-12">
                              <select class="form-control select" name="slide_no">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                              </select>
                              <!-- <span class="help-block">Select box example</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูปสไลด์</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" name="slide_img" id="filename" title="Browse file"/>
                              <span class="help-block">Input type file</span>
                          </div>
                      </div>

                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-default">Clear Form</button>
                      <button class="btn btn-primary pull-right" name="ok" >Submit</button>
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
                                                    <h3 class="panel-title">ข้อมูลสไลด์</h3>
                                                    <ul class="panel-controls">
                                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                                    </ul>
                                                </div>

                                                <?php
                                                $query = $db->prepare("SELECT * FROM slide");
                                                $query->execute();

                                                if($query->rowCount()>0){

                                                $data = $query->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($data as $k => $row ) {
                                                  ?>
                                                <div class="col-md-4 picture_slide">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">

                                                        <div class="panel-title-box">

                                                            <h3>ลำดับรูปที่แสดง : <?=$row->slide_no?></h3>
                                                            <span>ชื่อสไลด์ : <?=$row->slide_alt?></span>

                                                        </div>

                                                        <ul class="panel-controls" style="margin-top: 2px;">
                                                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                                            <!-- <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li> -->
                                                            <li class="dropdown">
                                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> แก้ไข</a></li>
                                                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> ลบ</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="panel-body padding-0">


                                                    <div class="chart-holder" id="dashboard-bar-1" style="height: 100%;" ><img src="../images/slide/<?=$row->newslide_img?>" style="width: 100%;" /></div>
                                                    </div>

                                                </div>

                                              </div>
                                              <?php
                                                }
                                              }
                                            ?>


                                            </div>  <!--panel panel-default-->
                                            <!-- END DEFAULT DATATABLE -->

                                        </div> <!--col-->
                                    </div> <!--row-->

                                </section>
