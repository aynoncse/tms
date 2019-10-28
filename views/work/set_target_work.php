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
            <h3 class="box-title">Set Target Work</h3>
            <?php $this->notificationShow(); ?>
          </div>
          <!-- /.box-header -->
        
          <div class="box-body" style="padding: 0">
            <form action="" method="post" class="assign-work-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">For The Month Of</label>
                    <div class="input-group date">
                      <div class="input-group-addon" style="border-radius: 5px 0 0 5px; border: 1px solid #3C868F; border-right: 0">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" name="for_month" id="datepicker2" value="<?php echo date('Y-m');?>" />
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label for="">Work For</label>
                    <select name="work_for" class="form-control select2" style="width: 100%" required>
                      <option disabled selected hidden>Click Here to Select</option>
                      <option value="4">Marketing Executive</option>
                      <option value="5">Tele-Marketing Executive</option>
                      <option value="8">Call Executive</option>
                      <option value="3">Marketing Manager</option>
                      <option value="6">Digital Marketing Executive</option>
                      <option value="7">Call Manager</option>
                      <option value="9">Programmer</option>
                    </select>
                  </div>
                  <!-- /.form-group -->                  

                  <div class="form-group clearfix">
                   <label id=''>Target Type</label>
                   <div class="radio-wrapper clearfix">
                    <div>
                      <div class="priority">
                        <input id="target_type-1" class="radio-custom" name="target_type" value="1" type="radio">
                        <label for="target_type-1" class="radio-custom-label"> <span class="radio-option">Daily</span></label>
                      </div>
                      <div  class="priority">
                        <input id="target_type-2" class="radio-custom" name="target_type" value="2" type="radio">
                        <label for="target_type-2" class="radio-custom-label"> <span class="radio-option">Monthly</span></label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.form-group -->

                <div class="form-group  clearfix" id="employee_div">
                  <label>Select Employee</label>
                  <select name="emp_id" class="form-control select2" style="width: 100%;">
                    <option disabled selected hidden>Click to Select</option>
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>Work Title</label>
                  <input list="work_titles" type="text" class="form-control" name="work_title" placeholder="Double-Click Here to Get a List" autocomplete="off"/>

                  <datalist id="work_titles">
                    <?php foreach ($work_titles as $title) {?>
                      <option value="<?= $title['work_title']; ?>"></option>
                    <?php } ?>
                  </datalist>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                  <label>Count</label>
                  <input type="text" class="form-control" onkeypress="return numbersOnly(event)" name="work_count" placeholder="Put a Number" autocomplete="off"/>
                </div>

                <div class="form-group hidden" id="daily-count">
                  <label>Daily Count</label>
                  <input type="text" class="form-control" onkeypress="return numbersOnly(event)" name="daily_count" placeholder="Put a Number" autocomplete="off"/>
                </div>
                <!-- /.form-group -->


                
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Description</label>
                  <textarea name="description" class="form-control" rows="3" id="editor1"></textarea>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="row">
                <div class="col-md-2 col-md-offset-5">
                  <button type="submit" name='submit' class="btn bg-green" style="width: 100%;">Submit</button>
                  <!-- /.submit-button -->
                </div>
              </div>
              <!-- /.row -->   
            </form>
            <!-- /.form --> 
          </div>
          <!-- /.box-body -->
        </div>
        <!-- ./box -->       
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="assets/js/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
  })
</script>
<script>
  $(document).ready(function() {
    $('#target_work').addClass('active');
    $('#vw_assign_work').addClass('active');

    $('.select2').select2()

    $('#datepicker2').datepicker({
     minViewMode: 1,
     format: 'yyyy-mm'
   });

  });

  $('select[name="work_for"]').on('change', function() {
    var designation = this.value;
    console.log(designation);
    $.post('?c=work&m=getEmployeeByDesignation', {designation: designation}, function(result) {
      $('select[name="emp_id"]').html(result);
      console.log(result);
    });
  });

  $('input[name="target_type"]').on('change', function() {
    if (this.value == 2) {
      $('#daily-count').removeClass('hidden');
    }else{
      $('#daily-count').addClass('hidden');
    }
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

</script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<?php include 'views/layouts/footer.php'; ?>