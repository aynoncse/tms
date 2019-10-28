<?php include 'views/layouts/header.php';?>
<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Content Wrapper. Contains page content -->
<style>
  .radio-wrapper,.form-group input, .form-group select, .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single, .select2-container--default .select2-selection--multiple {
    border-radius: 5px;
    border: 1px solid #3C868F;
  }
  
  .option_select_all {
    text-align: center;
    font-size: 16px;
    position: absolute;
    top: 0;
    right: 38px;
  }

  .option_select_all input[type='checkbox']{
    margin-right: 12px;
    overflow: hidden;
  }
</style>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
            <h3 class="box-title">Send Notice</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
        </div>

        <div class="col-md-8 col-md-offset-2">
          <div class="box-body">
            <form action="" method="post" enctype="multipart/form-data" class="assign-work-form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>To :</label>

                    <div class="form-group option_select_all hidden">
                      <input type="checkbox" id="checkbox">Select All
                    </div>

                    <select name="group_members[]" class="form-control select2" multiple="multiple" data-placeholder='Click to Pick' style="width: 100%;">

                      <?php foreach ($employee_list as $emp) { ?>
                        <option value="<?= $emp['emp_id'] ?>"><?= $emp['emp_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Notice Body</label>
                    <textarea name="notice" class="form-control" rows="3" id="editor1"></textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-12">
                  <div class="col-md-2 col-md-offset-5">
                    <button type="submit" name='submit' class="btn bg-green" style="width: 100%;">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
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
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
  })
</script>
<script>

  $(document).ready(function() {
    $('#send_notice').addClass('active');
    $('#vw_notice').addClass('active');

    $('.select2').select2();

    $('.select2').on('click',function(){
      $('.option_select_all').removeClass('hidden');
    });

    $("#checkbox").on('click', function(){
      if($("#checkbox").is(':checked')){
        $(".select2 > option").prop("selected","selected");
        $(".select2").trigger("change");
      }else{
        $(".select2 > option").removeAttr("selected");
        $(".select2").trigger("change");
      }
    });


    $('#datepicker2').datepicker({
      format:'yyyy-mm-dd',
    });

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,

      minuteStep:1
    });

    
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