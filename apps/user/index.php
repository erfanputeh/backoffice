<section class="content">
      <div class="row">
              <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลสินค้า</h3>
                                    <!-- <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul> -->
                                </div>

                                <div class="panel-body">
                                    <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <!-- <th>Salary</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $query = $db->prepare("SELECT * FROM member_dp WHERE level=2 ");//เตรียมคำสั่ง sql
                                          $query->execute();

                                          if($query->rowCount()>0){

                                          $data = $query->fetchAll(PDO::FETCH_OBJ);
                                          foreach ($data as $k => $row ) {
                                            ?>
                                            <tr>
                                              <td><?=($k+1)?></td>
                                              <td><?=$row->student_id?></td>
                                              <td><?=$row->name?>&nbsp;&nbsp;&nbsp;<?=$row->surname?></td>
                                              <td><?=$row->email?></td>
                                              <td>
                                                &nbsp;&nbsp;<a href="home.php?file=member/view&id=<?=$row->member_id?>"><i class='fa fa-eye'></i></a>&nbsp;
                                                <a href="home.php?file=member/del&id=<?=$row->member_id?>"><i class='fa fa-trash'></i></a>
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

                    <script>
                      $(function(){
                        //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
                        $('#datatable').dataTables();
                      });
                    </script>
                    </script>
                </section>
