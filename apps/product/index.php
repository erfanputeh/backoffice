<?php

$query = $db->prepare("SELECT * FROM category ");
$query->execute();
$category = $query->fetchAll(PDO::FETCH_OBJ);

date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['ok'])) {

    $objective_dir = "D:/xampp/htdocs/backoffice/images/product/";
    $objective_file = $objective_dir . basename($_FILES["product_picture"]["name"]);
    $uploadsuccess = 1;
    $pictureFileType = pathinfo($objective_file,PATHINFO_EXTENSION);

    //ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Ymd");
    //ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['product_picture']['name'],".");
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newfilename = $date.$numrand.$type;
    $path_copy = $objective_dir.$newfilename;

    $check = getimagesize($_FILES["product_picture"]["tmp_name"]);
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
    if ($_FILES["product_picture"]["size"] > 5000000) {
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
        if (move_uploaded_file($_FILES["product_picture"]["tmp_name"], $path_copy)) {

      $query = $db->prepare('INSERT INTO product (category_id, product_name, product_detail, product_price, product_picture, newproduct_picture)
                            values(:category_name, :product_name, :product_detail, :product_price, :product_picture, :newproduct_picture)');
      $result = $query->execute([
        'category_name'=>$_POST['category_name'],
        'product_name' =>$_POST['product_name'],
        'product_detail' =>$_POST['product_detail'],
        'product_price' =>$_POST['product_price'],
        'product_picture'=>$_FILES['product_picture']['name'],
        "newproduct_picture"=> $newfilename,
          ]);
          if ($result) {
            echo "<script>
                    alert('เพิ่มข้อมูลสินค้าเรียบร้อย')
                    window.location = 'home.php?file=product/index';
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

              <form class="form-horizontal" method="post" enctype="multipart/form-data" >
              <div class="panel panel-default">
                  <div class="panel-heading ui-draggable-handle">
                      <h3 class="panel-title"><strong>ระบบจัดการข้อมูลสินค้า</strong> </h3>
                      <ul class="panel-controls">
                          <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                      </ul>
                  </div>


                  <div class="panel-body">



                    <div class="form-group">
                        <label class="col-md-3 control-label">เพิ่มข้อมูลประเภทสินค้า</label>
                        <div class="col-md-6 col-xs-12">
                          <select class="form-control select" data-live-search="true" name="category_name" onchange="check(this);">
                            <option>ทั้งหมด</option>
                            <?php foreach ($category as $value): ?>
                            <option  value="<?=$value->category_id?>"><?=$value->category_name?></option>
                          <?php endforeach; ?>
                          </select>
                        </div>

                            <a href="category/index.php" onclick="window.open(this.href, 'mywin','left=50,top=20,width=600,height=700,toolbar=1,resizable=0'); return false;"><button type="button" class="btn btn-info btn-rounded">เพิ่มประเภทสินค้า +</button></a>
                            <!-- <button class="btn btn-info btn-rounded" data-toggle="modal" data-target="#modal_basic">เพิ่มประเภทสินค้า +</button> -->

                    </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ประเภทสินค้า</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <select class="form-control" name="category_name" onchange="check(this);">
                                    <option>เลือกประเภทสินค้า</option>
                                    <?php foreach ($category as $value): ?>
                                    <option  value="<?=$value->category_id?>"><?=$value->category_name?></option>
                                  <?php endforeach; ?>
                                  </select>
                              </div>


                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ชื่อสินค้า</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" name="product_name"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รายละเอียดสินค้า</label>
                          <div class="input-group">

                                  <!-- <p>Summernote also support Codemirror code preivew, check "Code View" mode.</p> -->
                              <textarea class="summernote" name="product_detail">
                              </textarea>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ราคาสินค้า</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" name="product_price"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูป</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" title="Browse file" type="file" name="product_picture"   accept="image/*"/>
                              <!-- <span class="help-block">Input type file</span> -->
                          </div>
                      </div>


                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-default" type="reset">Clear Form</button>
                      <button class="btn btn-primary pull-right" name="ok">Submit</button>
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
                                    <h3 class="panel-title">ข้อมูลสินค้า</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>

                                <div class="panel-body">
                                    <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูป</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>ประเภทสินค้า</th>
                                                <th>รายละเอียดสินค้า</th>
                                                <th>ราคา</th>
                                                <th>จัดการ</th>
                                                <!-- <th>Salary</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $query = $db->prepare("SELECT * FROM product INNER JOIN category ON product.category_id=category.category_id");//เตรียมคำสั่ง sql
                                          $query->execute();

                                          if($query->rowCount()>0){

                                          $data = $query->fetchAll(PDO::FETCH_OBJ);
                                          foreach ($data as $k => $row ) {
                                            ?>
                                            <tr>
                                              <td><?=($k+1)?></td>
                                              <td class=""><img  class="style_prevu_kit" src="../images/product/<?=$row->newproduct_picture?>"</td>
                                              <td><?=$row->product_name?></td>
                                              <td><?=$row->category_name?></td>
                                              <td><?=$row->product_detail?></td>
                                              <td><?=$row->product_price?></td>
                                              <td>
                                                <a href="home.php?file=product/update&id=<?=$row->product_id?>"><i class='fa fa-pencil-square-o'></i></a>&nbsp;
                                                <a href="home.php?file=product/view&id=<?=$row->product_id?>"><i class='fa fa-eye'></i></a>&nbsp;
                                                <a href="home.php?file=product/del&id=<?=$row->product_id?>"><i class='fa fa-trash-o'></i></a>
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
