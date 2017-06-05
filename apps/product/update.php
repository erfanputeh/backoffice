<?php

$query = $db->prepare("SELECT * FROM category ");
$query->execute();
$category = $query->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['ok'])){
  if ($_FILES["product_picture"]["name"]){ //เช็คว่ามีการเปลี่ยนรูปหรือไม่
  //สำหรับอัพโหลดภาพ
  $target_dir = "D:/xampp/htdocs/backoffice/images/product/";
  $target_file = $target_dir . basename($_FILES["product_picture"]["name"]);
  $uploadOK = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  //วันที่
  date_default_timezone_set('Asia/Bangkok');
  $date = date("Ymd");
  //สุ่มตัวเลข
  $numrand = (mt_rand());
  //เอาชื่อไฟล์เก่าออกเหลือแต่นามสกุล
  $type = strrchr($_FILES['product_picture']['name'],".");
  //ตั้งชื่อไฟล์ใหม่
  $newfilename = $date.$numrand.$type;
  $path_copy = $target_dir.$newfilename;

  $check = getimagesize($_FILES["product_picture"]["tmp_name"]);
  if($check !== false){
    echo "File is an images " . $check["mime"] . ".";
    $uploadOK = 1;
  }else {
    echo "File is not an images.";
    $uploadOK = 0;
  }

  //Check if file already exists
  if(file_exists($target_file)){
    echo "Sorry, file already exists.";
    $uploadOK = 0;
  }
  //Check file size
  if($_FILES["product_picture"]["size"] > 500000) {
    echo "Sorry,your file is too large.";
    $uploadOK = 0;
  }
  //Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" &&  $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "JPG" && $imageFileType != "gif" ){
    echo "Sorry, only JPG,JPEG,PNG & GIF file are allowed.";
    $uploadOK = 0;
  }
  //check if uploadOK is set to 0 by an error
  if($uploadOK == 0) {
    echo "Sorry,your file was not uploaded.";
    //if everything is ok,try to upload file
  }else {
    // unlink($target_dir.$_POST["images"]);//ลบรูป
    if(move_uploaded_file($_FILES["product_picture"]["tmp_name"],$path_copy)){
      echo "The file" . basename($_FILES["product_picture"]["name"])."has been uploaded.";

      $query = $db->prepare("UPDATE product SET
        category_id = :category_id,
        product_name = :product_name,
        product_detail = :product_detail,
        product_price = :product_price,
        product_picture = :product_picture,
        newproduct_picture = :newproduct_picture
        WHERE product.product_id = :id;");

        $result = $query->execute([
          "id"=>$_GET["id"],
          "category_id"=> $_POST["category_name"],
          "product_name"=> $_POST["product_name"],
          "product_detail"=> $_POST["product_detail"],
          "product_price"=> $_POST["product_price"],
          "product_picture"=> $_FILES["product_picture"]["name"],
          "newproduct_picture"=> $newfilename
        ]);

        if($result){
          echo "<script>
          alert('Update Successfully');
          window.location ='home.php?file=product/index';
          </script>";
        }else{
          echo "<script>alert('Update fail!'".$query->errorInfo()[2].");
          </script>";
        }
      }
    }
}else { //ไม่มีการเปลี่ยนรูป

  $query = $db->prepare("UPDATE product SET
    category_id = :category_id,
    product_name = :product_name,
    product_detail = :product_detail,
    product_price = :product_price
    WHERE product.product_id = :id ;");

    $result = $query->execute([
      "id"=>$_GET["id"],
      'category_id' => $_POST["category_name"],
      'product_name' => $_POST["product_name"],
      'product_detail' => $_POST["product_detail"],
      'product_price' => $_POST["product_price"]
    ]);


    if($result){
      echo "<script>
      alert('Update Successfully');
      window.location ='home.php?file=product/index';
      </script>";
    }else{
      echo "<script>alert('Update fail!'".$query->errorInfo()[2].");
      </script>";
    }
  }
}

if(isset($_GET['id'])){

$query = $db->prepare("SELECT * FROM product WHERE product_id = :id");
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
                          <label class="col-md-3 col-xs-12 control-label">ประเภทสินค้า</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <select class="form-control" name="category_name" onchange="check(this);">

                                  <option>-เลือกประเภทสินค้า-</option>
                                   <?php foreach ($category as $value): ?>
                                     <?php
                                      $s='';
                                     if(['category_id']==$value->category_id){
                                      // $s='';
                                      // $s='+1';
                                       $s = 'selected';
                                     }
                                     ?>
                                    <option value="<?=$value->category_id?>" <?=$s?>> <?=$value->category_name?></option>
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
                                  <input type="text" class="form-control" name="product_name" value="<?=$data->product_name?>"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รายละเอียดสินค้า</label>
                          <div class="input-group">

                                  <!-- <p>Summernote also support Codemirror code preivew, check "Code View" mode.</p> -->
                              <textarea class="summernote" name="product_detail" >
                              <?=$data->product_detail?>
                              </textarea>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ราคาสินค้า</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" name="product_price" value="<?=$data->product_price?>"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูป</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" title="Browse file" type="file" name="product_picture" accept="image/*"/>
                              <span class="help-block"><?=$data->newproduct_picture?></span>
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
