<section class="content">
  <!-- <div class="page-content-wrap"> -->

      <div class="row">
          <div class="col-md-12">

              <form class="form-horizontal">
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
                                  <input type="text" class="form-control"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Password</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                  <input type="password" class="form-control"/>
                              </div>
                              <!-- <span class="help-block">Password field sample</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Datepicker</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                  <input type="text" class="form-control datepicker" value="2014-11-01">
                              </div>
                              <!-- <span class="help-block">Click on input field to get datepicker</span> -->
                          </div>
                      </div>

                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Textarea</label>
                          <div class="col-md-6 col-xs-12">
                              <textarea class="form-control" rows="5"></textarea>
                              <span class="help-block">Default textarea field</span>
                          </div>
                      </div> -->

                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Tags</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="text" class="tagsinput" value="First,Second,Third"/>
                              <span class="help-block">Default textarea field</span>
                          </div>
                      </div> -->

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Select</label>
                          <div class="col-md-6 col-xs-12">
                              <select class="form-control select">
                                  <option>Option 1</option>
                                  <option>Option 2</option>
                                  <option>Option 3</option>
                                  <option>Option 4</option>
                                  <option>Option 5</option>
                              </select>
                              <!-- <span class="help-block">Select box example</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">File</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" name="filename" id="filename" title="Browse file"/>
                              <span class="help-block">Input type file</span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Checkbox</label>
                          <div class="col-md-6 col-xs-12">
                              <label class="check"><input type="checkbox" class="icheckbox" checked="checked"/> Checkbox title</label>
                              <!-- <span class="help-block">Checkbox sample, easy to use</span> -->
                          </div>
                      </div>

                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-default">Clear Form</button>
                      <button class="btn btn-primary pull-right">Submit</button>
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
                                    <h3 class="panel-title">Default</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
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
                                </div>
                            </div>
                            <!-- END DEFAULT DATATABLE -->

                        </div>
                    </div>

                </section>
