<?php include 'views/layouts/header.php';?>
<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Content Wrapper. Contains page content -->
<style>
  .radio-wrapper,.form-group input, .form-group select, .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single, .select2-container--default .select2-selection--multiple {
    border-radius: 5px;
    border: 1px solid #3C868F;
  }
</style>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
            <h3 class="box-title">Assign Work To Employee</h3>

          </div>
          <!-- /.box-header -->

          <div class="box-body" style="padding: 0">
            <form action="" method="post" enctype="multipart/form-data" class="assign-work-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group clearfix">
                    <label for="">Work For</label>
                    <select name="work_for" class="form-control select2" style="width: 100%" required>
                      <option disabled selected hidden>Click Here to Select</option>
                      <option value="9">Programmer</option>
                      <option value="4">Marketing Executive</option>
                      <option value="5">Tele-Marketing Executive</option>
                      <option value="8">Call Executive</option>
                      <option value="3">Marketing Manager</option>
                      <option value="6">Digital Marketing Executive</option>
                      <option value="7">Call Manager</option>
                    </select>
                  </div>
                  <div class="form-group  clearfix">
                    <label for="">Work Type</label>
                    <select name="work_type" class="form-control select2" style="width: 100%" required>
                      <!-- <option disabled selected hidden>Click Here to Select</option>-->
                      <option selected value="1">Single</option>
                      <option value="2">Group</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div id="project_div" style="display: none;">
                    <div class="form-group">
                      <label for="">Group Title</label>
                      <input type="text" class="form-control" name="group_name" placeholder="Give a Name for This Group"/>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label>Select Programmers</label>
                      <select name="group_members[]" class="form-control select2" multiple="multiple" data-placeholder='Click to Pick' style="width: 100%;">
                        <option disabled hidden>Click to Pick</option>
                        <?php foreach ($programmers as $programmer) { ?>
                          <option value="<?= $programmer['emp_id'] ?>"><?= $programmer['emp_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label>Project Manager</label>
                      <select name="project_manager" class="form-control select2" style="width: 100%;">
                        <option disabled selected hidden>Click to Select</option>
                        <?php foreach ($programmers as $programmer) { ?>
                          <option value="<?= $programmer['emp_id'] ?>"><?= $programmer['emp_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.project_div -->

                  <div class="form-group  clearfix" id="employee_div">
                    <label>Select Employee</label>
                    <select name="emp_id" class="form-control select2" style="width: 100%;">
                      <option disabled selected hidden>Click to Select</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div id="single_project_div" style="display: none;">
                    <div class="form-group clearfix">
                      <label id='' style="width: 100%;">Project Type</label>
                      <div class="radio-wrapper clearfix">
                        <div class="priority col-md-6 col-sm-6 col-xs-12" style="padding: 0">
                          <input id="project_type-1" class="radio-custom" name="project_type" value="1" type="radio">
                          <label for="project_type-1" class="radio-custom-label"> <span class="radio-option">Existing</span></label>
                        </div>

                        <div class="priority col-md-6 col-sm-6 col-xs-12" style="padding: 0">
                          <input id="project_type-2" class="radio-custom" name="project_type" value="2" type="radio">
                          <label for="project_type-2" class="radio-custom-label"> <span class="radio-option">New</span></label>
                        </div>
                      </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- single_project_div -->
                  <div class="form-group hidden  clearfix" id='existing_project' >
                    <label>Select Project</label>
                    <select name="project_id" class="form-control select2" placeholder='Click to Pick' style="width: 100%;">
                      <option selected disabled hidden>Click to Pick</option>
                      <?php foreach ($projects as $project) { ?>
                        <option value="<?= $project['id'] ?>"><?= $project['project_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="hidden" id='new_project'>
                    <div class="form-group">
                      <label>Project Title</label>
                      <input type="text" class="form-control" name="project_name" placeholder="Project Name" autocomplete="off"/>
                    </div>
                  </div>

                  <div class="hidden" id="work-title">
                    <div class="form-group">
                      <label>Work Title</label>
                      <input list="work_titles" type="text" class="form-control" name="work_title"placeholder="Double-Click Here to Get a List" autocomplete="off"/>
                      <datalist id="work_titles"><?php foreach ($work_titles as $title) {?>
                        <option value="<?= $title['work_title']; ?>"><?php } ?>
                      </datalist>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label>Count</label>
                      <input type="text" class="form-control" onkeypress="return numbersOnly(event)" name="work_count" placeholder="Put a Number" autocomplete="off"/>
                    </div>
                  </div>
                  <!-- /#work-title -->

                  <!-- radio -->
                  <div class="form-group clearfix">
                    <label for=''>Deadline for</label>
                    <div class="radio-wrapper clearfix">
                      <div>
                        <div class="priority col-md-4 col-sm-6 col-xs-12" style="padding: 0">
                          <input id="deadline-1" class="radio-custom" name="deadline" value="1" type="radio">
                          <label for="deadline-1" class="radio-custom-label"> <span class="radio-option">Short Time</span></label>
                        </div>
                        <div  class="priority col-md-4 col-sm-6 col-xs-12" style="padding: 0">
                          <input id="deadline-2" class="radio-custom" name="deadline" value="2" type="radio">
                          <label for="deadline-2" class="radio-custom-label"> <span class="radio-option">Long Time</span></label>
                        </div>
                        <div  class="priority col-md-4 col-sm-6 col-xs-12" style="padding: 0">
                          <input id="deadline-3" class="radio-custom" name="deadline" value="3" type="radio">
                          <label for="deadline-3" class="radio-custom-label"> <span class="radio-option">Daily</span></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-group -->

                  

                  <div id="longtime" style="display: none;">
                    <div class="form-group">
                      <label for="">Date of Start</label>
                      <div class="input-group date">
                        <div class="input-group-addon" style="border-radius:5px 0px 0px 5px;border:1px solid #3C868F; border-right: 0;">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="start_date" id="datepicker" placeholder="Click to Pick a Date"/>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form-group -->


                    <div class="form-group">
                      <label for="">Date of End</label>

                      <div class="input-group date">
                        <div class="input-group-addon" style="border-radius:5px 0px 0px 5px;border:1px solid #3C868F; border-right: 0;">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="end_date" id="datepicker2" placeholder="Click to Pick a Date" />
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form-group -->
                  </div>

                  <div id="short_time" style="display: none;">
                    <div class="form-group">
                      <label>Submit at</label>
                      <div class="input-group">
                        <input type="text" name='submit_at' class="form-control timepicker">

                        <div class="input-group-addon" style="border-radius:0 5px 5px 0; border: 1px solid #3C868F; border-left: 0;">
                          <i class="fa fa-clock-o"></i>
                        </div>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form-group -->                   
                  </div>

                  <div class="form-group clearfix">
                    <label for="priority">Prioritry </label>
                    <div class="radio-wrapper clearfix">
                      <div id="priority">
                        <div class="priority col-md-3 col-sm-6 col-xs-12" style="margin:0; padding: 0">
                          <input id="radio-1" class="radio-custom" name="priority" value="1" type="radio">
                          <label for="radio-1" class="radio-custom-label"> <span class="radio-option">Urgent</span></label>
                        </div>
                        <div class="priority col-md-3 col-sm-6 col-xs-12" style="margin:0; padding: 0">
                          <input id="radio-2" class="radio-custom" name="priority" value="2" type="radio">
                          <label for="radio-2" class="radio-custom-label"> <span class="radio-option">High</span></label>
                        </div>
                        <div class="priority col-md-3 col-sm-6 col-xs-12" style="margin:0; padding: 0">
                          <input id="radio-3" class="radio-custom" name="priority" value="3" type="radio">
                          <label for="radio-3" class="radio-custom-label"> <span class="radio-option">Medium</span></label>
                        </div>
                        <div class="priority col-md-3 col-sm-6 col-xs-12" style="margin:0; padding: 0">
                          <input id="radio-4" class="radio-custom" name="priority" value="4" type="radio">
                          <label for="radio-4" class="radio-custom-label"> <span class="radio-option">Low</span></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="attachment_file">Attachment</label>
                    <div class="upload-btn-wrapper">
                      <button class="upbtn btn btn-flat btn-danger"><i class="fas fa-upload"></i> Upload</button>
                      <input id="upload-btn" type="file" name="attachment" />
                    </div>
                    <p class="help-block"></p>
                  </div>
                  <!-- /.form-group -->

                </div>



                <div class="col-md-6">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" id="editor1"></textarea>
                  </div>
                  <!-- /.form-group -->

                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-5">
                  <button type="submit" name='submit' class="btn bg-green" style="width: 100%;"><i class="fas fa-hand-pointer"></i> Submit</button>
                </div>
              </div>
              <!-- /.row -->   
            </form>
          </div>
          <!-- ./box-body -->
        </div>
        <!-- .col-md-12-->               
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="assets/js/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
  
    CKEDITOR.replace('editor1')
  })
</script>
<script>

  $(document).ready(function() {
    $('#assign_work').addClass('active');
    $('#vw_assign_work').addClass('active');

    $('.select2').select2()
    $('#datepicker2').datepicker({
      format:'yyyy-mm-dd',
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      minuteStep:1
    })
  });

  function numbersOnly(e) // Numeric Validation
  {
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 && e.key !='.')
    {
      if ((unicode<2534||unicode>2543)&&(unicode<48||unicode>57))
      {
        return false;
      }
    }
  }

  $('#upload-btn').on('change', function() {
    var i = $(this).prev('label').clone();
    var file = $('#upload-btn')[0].files[0].name;
    $('.help-block').text(file);
  });

  $('select[name="work_type"]').on('change', function() {
    if (this.value == '2') {
      /*$('#local input[name="supplier_name"]').attr('required', 'required');
      $('#local input[name="mobile_no"]').attr('required', 'required');
      $('#local input[name="address"]').attr('required', 'required');*/
      $('#project_div').show();
      $('#new_project').removeClass('hidden');
      $('#employee_div').hide();
      $('#existing-p').attr('disabled','disabled');
      $('#new-p').attr('checked','checked');


    } else {
     /* $('#local input[name="supplier_name"]').removeAttr('required');
      $('#local input[name="mobile_no"]').removeAttr('required');
      $('#local input[name="address"]').removeAttr('required');*/
      $('#project_div').hide();
      $('#new_project').addClass('hidden');
      $('#employee_div').show();
      
    }

  });

  $('select[name="work_for"]').on('change', function() {
    var work_type = $('select[name="work_type"]').val();
    var designation = this.value;
    console.log(designation);
    $.post('?c=work&m=getEmployeeByDesignation', {designation: designation}, function(result) {
      $('select[name="emp_id"]').html(result);
    });
    if (this.value != '9') {

      $('#single_project_div').hide();
      $('#work-title').removeClass('hidden');
    }else{

      $('#work-title').addClass('hidden');
    }

    if (this.value == '9' && work_type == '1') {
      //console.log('hello');
      $('#single_project_div').show();
    }else{

      $('#new_project').addClass('hidden');
      $('#existing_project').addClass('hidden');
    }


  });

  $('input[name="deadline"]').on('change', function() {
    if (this.value == 1) {
      $('#short_time').show();
    }else{
      $('#short_time').hide();
    }

    if (this.value == 2 || this.value == 3) {
      $('#longtime').show();
    }else{
      $('#longtime').hide();
    }
  });


  $('input[name="project_type"]').on('change', function() {
    if (this.value == 1) {
      $('#existing_project').removeClass('hidden');
      $('#new_project').addClass('hidden');
      $('#work-title').removeClass('hidden');
    }else{
      $('#existing_project').addClass('hidden');
      $('#work-title').addClass('hidden');
    }

    if (this.value == 2) {
      $('#new_project').removeClass('hidden');
    }else{
     $('#new_project').addClass('hidden');
   }
 });
</script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<?php include 'views/layouts/footer.php'; ?>