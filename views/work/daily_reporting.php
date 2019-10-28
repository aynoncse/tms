 <?php include 'views/layouts/header.php';?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <form action="" method="post">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Daily Reporting</h3>
              <?php $this->notificationShow(); ?>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">

              <div class="col-md-6 col-md-offset-3 col-sm-12 form-div-style">
                <div class="form-group">
                  <label for="">Date</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="report_date" id="datepicker" value="<?php echo date('Y-m-d');?>" />
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form-group -->
                <input type="hidden" value="<?= $this->user_empId?>" name='emp_id'/> 
                <!-- textarea -->
                <div class="form-group">
                  <label>Description</label>
                  <textarea name="description" class="form-control" rows="3" placeholder="Describe in Detail....." required></textarea>
                </div>
                <!-- /.form-group -->

                <?php if ($w_type == 'sw'): ?>                  
                  <div class="form-group">
                    <label for="">Todays Count</label>
                    <div class="input-group">
                      <input type="text" name='count' onkeypress="return numbersOnly(event)" class="form-control" required/>
                      <span class="input-group-addon">#</span>
                    </div>
                  </div>
                  <!-- /.form-group -->
                <?php endif ?>
                
                <!-- /.form-group -->
                <div class="form-group">
                  <label for="">Todays Progress</label>
                  <div class="input-group">
                    <input type="text" name='completion_percent' onkeypress="return numbersOnly(event)" class="form-control" required/>
                    <span class="input-group-addon">%</span>
                  </div>
                </div>
                <!-- /.form-group -->
                
                <div style="margin: 0 auto;display: table;">
                  <button type="submit" name='submit' class="btn btn-success">Submit</button>
                </div>

              </div>

            </div>
            <!-- ./box-body -->
            
          </div>
          <!-- /.box -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

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
  $(document).ready(function () {
    $('#daily_reporting').addClass('active');
    $('#vw_assign_work').addClass('active');
  });


</script>
<?php include 'views/layouts/footer.php'; ?>