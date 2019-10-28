<?php include 'views/layouts/header.php';?>
<!-- Content Wrapper. Contains page content -->
<style>
  .panel-heading {
    padding: 5px 10px;
  }
  .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    padding-right: 10px;
    padding-left: 10px;
  }
</style>
<div class="content-wrapper"> 
</section>

<!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fas fa-project-diagram"></i></span>

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
        <span class="info-box-icon bg-red"><i class="fas fa-network-wired"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Completed Projects</span>
          <span class="info-box-number"><?= sizeof($comp_projects); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fas fa-exclamation-circle"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Deadline: Today</span>
          <span class="info-box-number"><?= sizeof($today_deadline_works); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Employee</span>
          <span class="info-box-number"><?= sizeof($employee); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <?php foreach ($not_programmers as $emp) {
      $emp_present = $this->empIsPresent($emp['emp_id']);
      ?>
      <div class="col-md-3 col-sm-6">
       <!-- Widget: user widget style 1 -->
       <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-purple">
          <div class="widget-user-image">
            <img class="img-circle db-emp-profile-img" src="<?php if (empty($emp['emp_img'])){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $emp['emp_img'];} ?>" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username"><?= $emp['emp_name'] ?></h3>
          <h5 class="widget-user-desc"><?= $this->empDesignation($emp['emp_designation'])?></h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li>
              <a href="#">Tasks in Hand
                <span class="pull-right badge bg-aqua"><?= sizeof($this->getTasksInHand($emp['emp_id']))?>
              </span>
            </a>
          </li>
          <li>
            <a href="#">Completed Tasks
              <span class="pull-right badge bg-green">
                <?= sizeof($this->getTasksCompleted($emp['emp_id']))?>
              </span>
            </a>
          </li>
          <li>
            <a href="#">Overdue Task
              <span class="pull-right badge bg-red">
                <?= sizeof($this->getTasksOverdue($emp['emp_id']))?>                    
              </span>
            </a>
          </li>
          <li>
            <a href="#">Rating
              <span class="pull-right badge bg-purple">
                8.0/10
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.widget-user -->
  </div>
<?php } ?>
</div>
<div class="row">
  <?php foreach ($programmers as $emp) {
    $emp_present = $this->empIsPresent($emp['emp_id']);
    ?>
    <div class="col-md-3 col-sm-6">
     <!-- Widget: user widget style 1 -->
     <div class="box box-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-navy">
        <div class="widget-user-image">
          <img class="img-circle db-emp-profile-img" src="<?php if (empty($emp['emp_img'])){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $emp['emp_img'];} ?>" alt="User Avatar">
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username"><?= $emp['emp_name'] ?></h3>
        <h5 class="widget-user-desc"><?= $this->empDesignation($emp['emp_designation'])?></h5>
      </div>
      <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
          <li>
            <a href="#">Projects in Hand
              <span class="pull-right badge bg-blue">
                <?= sizeof($this->getProjectsInHand($emp['emp_id']))?>
              </span>
            </a>
          </li>
          <li>
            <a href="#">Tasks in Hand
              <span class="pull-right badge bg-aqua">
                <?= sizeof($this->getTasksInHand($emp['emp_id']))?>
              </span>
            </a>
          </li>

          <li>
            <a href="#">Overdue Tasks
              <span class="pull-right badge bg-red">
                <?= sizeof($this->getTasksOverdue($emp['emp_id']))?> 
              </span>
            </a>
          </li>

          <li>
            <a href="#">Overdue Project
              <span class="pull-right badge bg-red">
                <?= sizeof($this->getProjectsOverdue($emp['emp_id']))?>
              </span>
            </a>
          </li>

          <li>
            <a href="#">Completed Tasks
              <span class="pull-right badge bg-green">
                <?= sizeof($this->getTasksCompleted($emp['emp_id']))?>
              </span>
            </a>
          </li>

          <li>
            <a href="#">Completed Projects
              <span class="pull-right badge bg-red">
                <?= sizeof($this->getProjectsCompleted($emp['emp_id']))?>
              </span>
            </a>
          </li>
          <li>
            <a href="#">Rating
              <span class="pull-right badge bg-purple">
                8.0/10
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.widget-user -->
  </div>
<?php } ?>
</div>
<!-- /.box-body -->
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
    $('#vw_dashboard').addClass('active');
  });
</script>
<?php include 'views/layouts/footer.php'; ?>