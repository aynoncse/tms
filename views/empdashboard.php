<?php include 'views/layouts/header.php';?>
<!-- Content Wrapper. Contains page content -->
<style>
  .widget-user-2 .widget-user-header {
    padding: 5px 0 !important;
    height: 40px;
  }

</style>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <!-- Info boxes -->
    <div class="row">      
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg bg-red" style="padding: 5px !important;"><img src="assets/img/deadline-icon.png" alt="" height="" width="65" class="deadline-icon" style="margin-top: -15px;"></span>

          <div class="info-box-content">
            <span class="info-box-text">Deadline: Today</span>
            <span class="info-box-number"><?= sizeof($today_deadline_works) + sizeof($today_deadline_projects); ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple" style="padding: 10px !important;"><img src="assets/img/spinner.png" alt="" height="" width="65" style="margin-top: -25px;" class="spinner"></span>          
          <div class="info-box-content">
            <span class="info-box-text">Tasks in Hand</span>
            <span class="info-box-number"><?= sizeof($on_works);?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      
      <?php if ($this->user_designation==9): ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-spinner loader"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Ongoing Projects</span>
              <span class="info-box-number"><?= sizeof($on_projects); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-navy" style="padding: 5px !important;">
              <img src="assets/img/accomplishment_2.png" alt="" height="" width="65" style="margin-top: -15px;">
              <img src="assets/img/arrow.png" class="arrow-icon">
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Accomplishment</span>
              <span class="info-box-number"><?= sizeof($projects_accomplished); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      <?php endif ?>
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-4 col-sm-6">
           <!-- Widget: user widget style 1 -->
           <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple">
              <img src="assets/img/pin-3.png" alt="" class="pin-icon" />
              <h1 class="widget-user-username" style="font-size: 18px; font-family: 'Arial Black';"> To Do List </h1>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php                     
                $i=0;
                
                foreach ($on_works_all as $on_work) {?>
                  <li>
                    <a href="
                    <?php
                    if($on_work['project_id']!=0){
                    $this->url('work', 'single_project_list', "&id=".$on_work['project_id']);
                    }
                    if($on_work['sw_id']!=0){
                    $this->url('work', 'single_work_list', "&id=".$on_work['sw_id']);
                    }
                    ?>">
                      <?= $on_work['project_name'].$on_work['work_title'];?>

                    <span class="pull-right badge bg-aqua">
                      <?= $on_work['sw_completion'].$on_work['project_completion'];?>%
                    </span>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <!-- /.widget-user -->
      </div>
      <div class="col-md-8">
        
      </div>

    </div>
    <!-- /.row -->
  </div>

  <div class="col-md-3">
    <div class="paper">
      <img src="assets/img/pin.png" alt=""/>
      <div>
        <i class="fa fa-plus add-note-btn"></i>
        <i class="fas fa-minus hidden" id="minus_button"></i>
        <h3>Note</h3>
        <form action="" method="post" class="hidden" id="note-form">
          <div class="form-group">
            <textarea name="note" class="form-control note-textarea" style="height: 150px;width: 100%;" id="note-text">

            </textarea>
          </div>
          <!-- /.form-group -->
          <button type="button" name='submit' id='note_submit' class="btn btn-sm bg-navy" style="width: 60px;right: 0px;position: absolute; bottom:1px;height: 25px;">Update</button>
        </form>  
        <p id='text_emp_note'>
        </p>
      </div>  

    </div>
  </div>

</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

  $('#data-table').DataTable( {
    responsive: true,
    searching: true,
    bLengthChange: false,
    bSort:false
  } )
  $(document).ready(function () {

    function getNoteData(){
      $.get('?c=dashboard&m=getEmpNote', function(result) {
        $('#text_emp_note').html(result);
      });
    }
    getNoteData();

    $('#vw_dashboard').addClass('active');

    $('.add-note-btn').on('click', function(){
      $('#note-form').removeClass('hidden');
      $('.add-note-btn').addClass('hidden');
      $('#minus_button').removeClass('hidden');
      $('#note-text').val($('#text_emp_note').html());
    });

    $('#minus_button').on('click', function(){
      $('.add-note-btn').removeClass('hidden');
      $('#minus_button').addClass('hidden');
      $('#note-form').addClass('hidden');
    });

    $('#note_submit').on('click', function(){
      var note = $('#note-text').val();

      $.get('?c=dashboard&m=updateEmpNote', {note: note}, function(result) {
        getNoteData();
      });
    });
  });
</script>
<?php include 'views/layouts/footer.php'; ?>