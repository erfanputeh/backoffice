
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php
    if(isset($_POST['ok'])){
            $query = $db->prepare("UPDATE member_dp SET
                password = :password
                WHERE member_dp.member_id = :id;");

              $result = $query->execute([
              'id'=>$_GET['id'],
              'newpassword' => $_POST["newpassword"],
              'password' => $_POST["password"]
              ]);

            if($result){
                echo "<script>alert('Chang Password Successfully')
                      window.location = 'home.php?file=dashboard';
                      </script>";
            }
            else if($_POST['newpassword'] != $_POST['password']){
                echo "<script>";
                echo "alert('ยืนยันรหัสผ่านไม่ตรงกัน');";
                echo "window.location='home.php?file=password/index'";
                echo "</script>";
            }
            else{
                echo "<script>
                      alert('Update fail! '".$query->errorInfo()[2].");
                      </script>";
            }
            }


            if(isset($_GET['id'])){
            $query = $db->prepare("SELECT * FROM member_dp WHERE member_dp.member_id = :id");
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
                          <h3 class="panel-title"><strong>เปลี่ยนรหัสผ่าน</strong> </h3>
                          <ul class="panel-controls">
                              <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                          </ul>
                      </div>


                      <div class="panel-body">

                        <!-- <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">รหัสผ่านเดิม</label>
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="password" class="form-control" name="password"/>
                                </div>

                            </div>
                        </div> -->

                          <div class="form-group">
                              <label class="col-md-3 col-xs-12 control-label">รหัสผ่านใหม่</label>
                              <div class="col-md-6 col-xs-12">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input type="password" class="form-control" name="newpassword"/>
                                  </div>
                                  <!-- <span class="help-block">This is sample of text field</span> -->
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-3 col-xs-12 control-label">ยืนยันรหัสผ่าน</label>
                              <div class="col-md-6 col-xs-12">
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                      <input type="password" class="form-control" name="password"/>
                                  </div>
                                  <!-- <span class="help-block">This is sample of text field</span> -->
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


  </body>
</html>
