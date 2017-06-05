<?php
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

      $query = $db->prepare('INSERT INTO product (category_id, product_name, product_detail, product_picture, 	newproduct_picture)
                            values(category_name ,:product_name ,:product_detail ,:product_picture ,:newproduct_picture)');
      $res = $query->execute([
        'category_name'=>$_POST['category_name'],
        'product_name' =>$_POST['product_name'],
        'product_detail' =>$_POST['product_detail'],
        'product_picture'=>$_FILES['product_picture']['name'],
        "newproduct_picture"=> $newfilename,
          ]);
          if ($res) {
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

$isNewRecord = true;

include_once('form.php');
?>
