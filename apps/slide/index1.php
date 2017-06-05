<? include "../../libs/Db.php";?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Setting Slide</title>
</head>

<body>

 <!-- ############################### save -->
<?php
if(isset($_GET['ok'])){
  $query = $db->prepare("UPDATE slide SET
    slide_no = :slide_no,
    slide_alt = :slide_alt,
    slide_link = :slide_link
  WHERE slide.slide_id = :id ;");

  $result = $query->execute([
  "id" => $_GET["id"],
  'slide_no' => $_POST["slide_no"],
  'slide_alt' => $_POST["slide_alt"],
  'slide_link' => $_POST["slide_link"],
  ]);
if($result){
    echo "<script>alert('Update Successfully')
          window.location = 'home.php?file=personal/index1';
          </script>";
}else{
    echo "<script>
          alert('Update fail! '".$query->errorInfo()[2].");
          </script>";
}
}

 ?>
 <?php
 if(isset($_GET['id'])){
 $query = $db->prepare("SELECT * FROM personal WHERE id_personal = :id");
 $query->execute([
 'id'=>$_GET['id']
 ]);//รัน sql
     $data = $query->fetch(PDO::FETCH_OBJ);
   }
 ?>


<!-- ############################### edit -->

<form action="" method="post" id="form_type">
<table width="400" cellspacing="0" cellpadding="0"  class="card" style="margin:10px; width:400px;">

  <tr>
    <td align="left" bgcolor="#0099FF" style="border:solid 0px #ccc; padding:5px;"><strong><span style="color:#fff;">ลำดับการแสดงผล. :</span></strong><span style="color:#FF3;">
      <select class="txt" name="slide_no" style="width:70%;">
        <option value="<?=$data->slide_no?>">:::::::::::::::::::::::::
          <?=$data->slide_no?>
          :::::::::::::::::::::::::</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td>


    <img src="images/slide/<?=$data->slide_img?>" width="100%" />


    <a href="" onclick="window.open(this.href, 'mywin','left=20,top=20,width=600,height=700,toolbar=1,resizable=0'); return false;">
    <div style="background-color: #F00; opacity:0.7; position: relative; top:0; color:#fff; padding:5px; width:97%;" class=" hov_slide" align="center">เปลี่ยนรูป</div>
    </a>
    </td>
  </tr>
  <tr>
    <td style="border:solid 1px #ccc; padding:5px;"><strong><span style="color:#09F;">ALT</span></strong> :
&nbsp;<span style="color:#F30;"><input type="text" name="slide_alt" class="txt" value="<?=$data->slide_alt?>" style="width:97%;" /></span></td>
  </tr>
   <tr>
    <td style="border:solid 1px #ccc; padding:5px;"><strong><span style="color:#09F;">Link</span></strong> :
&nbsp;<span style="color:#F30;"><input type="text" name="slide_link" class="txt" value="<?=$data->slide_link?>" style="width:97%;" /></span></td>
  </tr>
   <tr>
     <td align="center" style="padding-top:5px; padding-bottom:5px;">

       <a href="">
        <button type="submit" class="fab green" style="border:none;" name="ok"> save </button>
      </a></td>
   </tr>
</table>
</form>


<? ############################### ch_img
if(isset($_GET['ok']))
	{
	if($_FILES["slide_img"]["name"] != "")
	{

		if(move_uploaded_file($_FILES["slide_img"]["tmp_name"],"img/".$_FILES["slide_img"]["name"]))
		{

			//*** Delete Old File ***//
			@unlink("img/".$_POST["hdnOldFile"]);

			//*** Update New File ***//
      $query = $db->prepare("UPDATE slide SET
        slide_img = :slide_img
      WHERE slide.slide_id = :id ;");

      $result = $query->execute([
      "id" => $_GET["id"],
      'slide_img' => $_FILES["slide_img"]["name"],
      ]);
    if($result){
        echo "<script>alert('Update Successfully')
              window.location = 'home.php?file=slide/index1';
              </script>";
    }else{
        echo "<script>
              alert('Update fail! '".$query->errorInfo()[2].");
              </script>";
    }
    }
			?>
<div align="center"><button type="button" onClick="window.open('', '_self', ''); window.close();" class="myButton" name="ok">Close</button></div>


<?
############################### ch_img
if(isset($_GET['ok']))
	{
	$query = $db->("SELECT * FROM slide WHERE slide_id = :id ");
  $query->execute([
  'id'=>$_GET['id']
  ]);//รัน sql
      $data = $query->fetch(PDO::FETCH_OBJ);
    }
  ?>

<form action="?Action=save_img&amp;slide_id=<?=$objResult["slide_id"];?>" method="post" enctype='multipart/form-data' id="form_type">
<table width="450" cellspacing="0" cellpadding="0"  class="card" style="margin:10px; width:450px;">

  <tr>
    <td align="center" bgcolor="#0099FF" style="border:solid 0px #ccc; padding:5px;"><strong><span style="color:#fff;">No. :</span></strong> <span style="color:#FF3;"><?=$data->slide_no?></span></td>
  </tr>

  <tr>
    <td align="center">
    <img src="img/<?=$data->slide_img?>" width="100%" />
    <p><input class="form-control" type="file" id="exampleInputFile"  name="slide_img" ></p>
    </td>
  </tr>

   <tr>
     <td align="center" style="padding-top:5px; padding-bottom:5px;">
       <button type="submit" class="fab green" style="border:none;" name="ok">
         save
        </button>
     </td>
    </tr>

</table>
</form>


<? ############################### del <input type="submit" icon="create" class="fab green" value=""/>
if($_GET["Action"]=="del")
	{
	$strSQL = "DELETE FROM slide ";
	$strSQL .="WHERE slide_id = '".$_GET["slide_id"]."' ";
	$objQuery = mysql_query($strSQL);
	echo "<div align='center'><span style='color:#F00;'><img src='../img/load.gif'><br>ลบข้อมูลเรียบร้อย กรุณารอสักครู่</span></div>";
	echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=?Action=show">';
	}
?>
<? ############################### add
if($_GET["Action"]=="add")
	{
	if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],"img/".$_FILES["filUpload"]["name"]))
	{
		echo "&nbsp;";
	}else{
		echo "ยังไม่อัพรูป!<br>";
		exit();
	}
	$strSQL = "SELECT * FROM slide WHERE slide_no = '".trim($_POST['slide_no'])."' ";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if($objResult)
	{
			echo "ลำดับการแสดงผลนี่มีอยู่แล้ว กรุณากรอกใหม่อีกครั้ง!<br>";
	}
	else
	{
		$strSQL = "INSERT INTO slide";
		$strSQL .="(slide_alt, slide_no, slide_link, slide_img) ";
		$strSQL .="VALUES ";
		$strSQL .="('".$_POST["slide_alt"]."','".$_POST["slide_no"]."','".$_POST["slide_link"]."','".$_FILES["filUpload"]["name"]."') ";
		$objQuery = mysql_query($strSQL);
	echo "<div align='center'><span style='color:#F00;'><img src='../img/load.gif'><br>เพิ่มข้อมูลเรียบร้อย กรุณารอสักครู่</span></div>";
	echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=?Action=show">';
	}
 } ?>
<? ############################### plus
if($_GET["Action"]=="plus")
	{
?>
<br />
<div class="dialog" style="height: auto;">
<form action="" role="form" method="post" enctype='multipart/form-data'>

      <div class="form-group">
        <input type="text" class="form-control" id="exampleInputEmail1" name="slide_alt" required>
        <span class="form-highlight"></span>
        <span class="form-bar"></span>
        <label class="float-label" for="exampleInputEmail1" style="color: #09F;">*ชื่อสไลด์ หรือ คำอธิบาย (alt)</label>
      </div>

      <div class="zero-clipboard"><span class="btn-clipboard with-example" style="font-size:18px; color:#09F;">ลำดับที่ต้องการให้แสดง</span></div><div class="bs-example">

      <select class="form-control" name="slide_no">
      	<option value="#"></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select>

  </div>

      <div class="form-group">
      <div class="float-label" for="exampleInputEmail1" style="color:#09F;">Link</div>
        <input type="text" class="form-control" id="exampleInputEmail1" name="slide_w" value="#" required>
        <span class="form-highlight"></span>
        <span class="form-bar"></span>

    </div>


    <div class="form-group">
        <input class="form-control" type="file" id="exampleInputFile"  name="filUpload" >
      </div>


      <input type="submit" value="บันทึก" class="button_m raised green" style="border:none; font-family:Conv_thaisanslite_r1;"/>

    </form>
</div>
<? } ?>

<?  ############################### show
if($_GET["Action"]=="show")
	{
?>
<?
$strSQL = "SELECT * FROM slide order by slide_no ASC";
$objQuery = mysql_query($strSQL)  or die(mysql_error());
$objQuery  = mysql_query($strSQL);
$i = 1;
?>

<div style="width:<?=$objResult["tem_weight"];?>">


 <?
  while($objResult = mysql_fetch_array($objQuery))
  {
	$slide_id = $objResult["slide_id"];
  ?>
<table width="250" cellspacing="0" cellpadding="0"  class="card" style="margin:10px; float:left;">

  <tr>
    <td colspan="2" align="center" bgcolor="#0099FF" style="border:solid 0px #ccc; padding:5px;"><strong><span style="color:#fff;">No. :</span></strong> <span style="color:#FF3;"><?=$objResult["slide_no"];?></span></td>
  </tr>
  <tr>
    <td colspan="2">

      <paper-ripple class="recenteringTouch" fit></paper-ripple>
    <img src="img/<?=$objResult["slide_img"];?>" width="100%" height="111" />


    <a href="?Action=ch_img&slide_id=<? echo $slide_id;?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=550,height=700,toolbar=1,resizable=0'); return false;">
    <div style="background-color: #F00; opacity:0.7; position: relative; top:0; color:#fff; padding:5px; width:97%;" class=" hov_slide" align="center">เปลี่ยนรูป</div>
    </a>

     <a href="<?=$objResult["slide_link"];?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=800,height=700,toolbar=1,resizable=0'); return false;">
    <div style="background-color: #090; opacity:0.7; position: relative; top:0; color:#fff; padding:5px; width:97%;" class=" hov_slide" align="center">LINK</div>
    </a>
    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center" style="border:solid 1px #ccc; padding:5px;"><strong><span style="color:#09F;">ALT</span></strong> :
&nbsp;<span style="color:#F30;"><?=$objResult["slide_alt"];?></span></td>
  </tr>
   <tr>
    <td align="center" style="padding-top:5px; padding-bottom:5px;">
    <a href="?Action=edit&slide_id=<?=$objResult["slide_id"];?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=600,height=700,toolbar=1,resizable=0'); return false;">
    <img src="../img/Icon_WriteArticles.png" width="40" />
    </a>
    </td>
    <td align="center">
    <a href="?Action=del&slide_id=<?=$objResult["slide_id"];?>"  OnClick="return chkdel();">
    <img src="../img/deleteNews.png" width="40" />
    </a>
    </td>
  </tr>
</table>
<? } ?>

<? } ?>

</body>
</html>
