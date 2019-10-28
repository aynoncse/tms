<?php include 'views/layouts/header.php';?>
<link rel="stylesheet" href="assets/css/work_list_style.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <nav class="navbar navbar-default">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar">
              </span>
              <span class="icon-bar">
              </span>
              <span class="icon-bar">
              </span>
            </button>
            <a class="navbar-brand" href="<?php $this->url('work', 'work_list');?>">List of Works
            </a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right my-nav">                        
              <li class="see_all_li">
                <a href="#" id="see_all" >
                  <i class="fas fa-sync-alt">
                  </i>
                </a>
              </li>
              
              <li class="dropdown ongoing_li">
                <a class="dropdown-toggle " data-toggle="dropdown" href="#">Ongoing
                  <span class="caret">
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id='on_projects'>Projects
                    </a>
                  </li>
                  <li>
                    <a href="#" id='on_sw'>Single Works
                    </a>
                  </li>
                  <li>
                    <a href="#" id='on_all'>All
                    </a>
                  </li>
                </ul>
              </li>
              <li class="dropdown pending_li">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pending
                  <span class="caret">
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id='pending_projects'>Projects
                    </a>
                  </li>
                  <li>
                    <a href="#" id='pending_sw'>Single Works
                    </a>
                  </li>
                  <li>
                    <a href="#" id='pending_all'>All
                    </a>
                  </li>
                </ul>
              </li>

              <li class="dropdown canceled_li">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Canceled
                  <span class="caret">
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id='canceled_projects'>Projects
                    </a>
                  </li>
                  <li>
                    <a href="#" id='canceled_sw'>Single Works
                    </a>
                  </li>
                  <li>
                    <a href="#" id='canceled_all'>All
                    </a>
                  </li>
                </ul>
              </li>

              <li class="dropdown completed_li">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Completed
                  <span class="caret">
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" id='comp_projects'>Projects
                    </a>
                  </li>
                  <li>
                    <a href="#" id='comp_sw'>Single Works
                    </a>
                  </li>
                  <li>
                    <a href="#" id='comp_all'>All
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-default">

          <div class="box-header with-border">
            <input type="hidden" id="active-li" value="">
            <input type="hidden" id="filter_type" value="see_all">
            <input type="hidden" id="filter_assign" value="">
            <input type="hidden" id="emp-id" value="">
            <div class="col-md-6 pull-right">
              <div class="col-md-4 col-sm-6">
                <?php if ($this->user_ty==1): ?>
                  <button class="dropdown btn btn-success">
                  <a class="dropdown-toggle filter_by text-white" data-toggle="dropdown" href="#">Pick Employee
                    <span class="caret">
                    </span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" data-toggle="collapse" data-target="#emp_div_assigned_by" class="filter_assigned_by">Assigned By
                      </a>
                    </li>
                    <li>
                      <a href="#" class="filter_assigned_to" data-toggle="collapse" data-target="#emp_div_assigned_to">Assigned To
                      </a>
                    </li>
                  </ul>
                </button>
                <?php else: ?>
                  <button class="dropdown btn btn-success">
                  <a class="dropdown-toggle filter_by text-white" data-toggle="dropdown" href="#">Filter
                    <span class="caret">
                    </span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="#" class="assigned_by_me">Assigned By Me
                      </a>
                    </li>
                    <li>
                      <a href="#" class="assigned_to_me">Assigned To Me
                      </a>
                    </li>
                  </ul>
                </button>
                <?php endif ?>
                

              </div>
              <div class="col-md-8  col-sm-6">
                <div class='collapse' id="emp_div_assigned_by">
                  <?php $employee = $this->db->view_all_by_cond('tbl_employee','emp_status=1'); ?>
                  <select name="emp_assigned_by" class="select2 select_field" style="width: 100%;">
                    <option class="selected_option" disabled selected hidden>Select Employee
                    </option>
                    <?php foreach ($employee as $emp) { ?>
                    <option value="<?= $emp['emp_id'].'-'.$emp['emp_name']?>">
                      <?= $emp['emp_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                <!-- /.form-group -->
                </div>
              </div>
              <div class="col-md-8  col-sm-6">
                <div class='collapse' id="emp_div_assigned_to">
                  <?php $employee = $this->db->view_all_by_cond('tbl_employee','emp_status=1'); ?>
                  <select name="emp_assigned_to" class="select2 select_field" style="width: 100%;">
                    <option disabled selected hidden>Select Employee
                    </option>
                    <?php foreach ($employee as $emp) { ?>
                    <option value="<?= $emp['emp_id'].'-'.$emp['emp_name']?>">
                      <?= $emp['emp_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                  <!-- /.form-group -->
                </div>
              </div>
            </div>  
            <button type="button" class="btn btn-danger pull-right" id="daterange-btn">
              <span><i class="fa fa-calendar"></i> Pick Date </span>
              <i class="fa fa-caret-down"></i>
            </button>
            <div class="col-md-12"><h3 style="margin:0"><span class="box-title">All Works</span> <span class="assign_title"></span> <span class="date_title"></span></h3></div>
               
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="data-table" class="table table-bordered table-striped " style="width: 100%">
                <thead class="data-table-head">
                  <tr class="data-table-head-row bg-green">
                    <th width="1%">SN.
                    </th>
                    <th width="14%">Title
                    </th>                    
                    <th width="15%">Assigned To
                    </th>
                    <th width="10%">Assigned By
                    </th>
                    <th width="10%">Starts On
                    </th>
                    <th width="10%">Deadline On
                    </th>
                    <th width="5%">Remaining
                    </th>
                    <th width="5%">Status
                    </th>
                    <th width="5%">Progress
                    </th>
                    <th width="5%">Rating
                    </th>
                    <th class="text-center" width="20%">Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=0;?>
                  <?php foreach ($on_works_all as $on_work):?>
                  <?php
                  $i++;
                  if($on_work['project_id']!=0){
                  $w_type= 'np';
                  }
                  if($on_work['sw_id']!=0){
                  if ($on_work['sw_pid']!=0) {
                  $w_type= 'ep';
                  }else{
                  $w_type= 'sw';
                  }
                  }
                  $task_id=($on_work['project_id'] !=0)?$on_work['project_id']:$on_work['sw_id'];
                  $percent = $on_work['completion_percent'];
                  $submit_date = (empty($on_work['submit_date']))?$on_work['sw_submit_date']:$on_work['submit_date'];
                  ?>
                  <tr class="<?php if($on_work['priority']==1){echo 'bg-danger';}elseif($on_work['priority']==2){echo 'bg-info';}elseif($on_work['priority']==3){echo 'bg-warning';} ?>">
                    <td>
                      <?= $i; ?>
                    </td>
                    <td>
                      <?php if ($on_work['sw_pid']!=0 || $on_work['sw_pid']!=NULL) {
                        $project = $this->db->details_by_cond('tbl_projects','id='.$on_work['sw_pid']);?>
                      <a href="<?php $this->url('work', 'single_work_list', "&id=".$on_work['sw_id']);?>">
                        <?= $on_work['work_title']?>
                        <?php if($on_work['sw_pid'] !=0){
                          echo ' - '. $project['project_name'];
                        } else {
                          echo ' - '. $on_work['count'];
                        }
                        ?>
                      </a>
                      <?php }else{?>
                      <a href="<?php $this->url('work', 'single_project_list', "&id=".$on_work['project_id']);?>">
                        <?= $on_work['work_title'];?>
                      </a>
                      <?php } ?>                           
                    </td>
                    <td>
                      <?= ($this->user_empId!=$on_work['emp_id'])?$this->empName($on_work['emp_id']):'Myself';?>
                    </td>
                    <td>
                      <?php
                        if($on_work['emp_id']==$on_work['assigned_by']){
                        echo 'Self-Assigned';
                        }else{
                        echo $this->empName($on_work['assigned_by']);
                        }
                      ?>
                    </td>
                    <td>
                      <?= date('d, M Y', strtotime($on_work['start_date']));?>
                    </td>
                    <td class="<?= $submit_date == date('y-m-d')?'bg-red':''; ?>">
                      <?= date('d, M Y', strtotime($submit_date));?>&nbsp;
                      <?= ($on_work['submit_at'] !=NULL)?date('h:i:s a', strtotime($on_work['submit_at'])):'';?>
                    </td>
                    <td>
                      <?= ($submit_date != date('Y-m-d'))?$this->diffDate(date('Y-m-d'), $submit_date):0;?> Days
                    </td>
                    <td>
                      <span class="label
                                   <?php
                                   if($on_work['status']==0){
                                   echo'label-success';
                                   }elseif($on_work['status']==1){
                                   echo'label-info';
                                   }elseif($on_work['status']==2){
                                   echo'label-danger';
                                   }elseif($on_work['status']==3){
                                   echo'label-warning';
                                   }elseif($on_work['status']==4){
                                   echo'label-warning';
                                   }elseif($on_work['status']==5){
                                   echo'label-danger';
                                   }elseif($on_work['status']==6){
                                   echo'label-success';
                                   }elseif($on_work['status']==7){
                                   echo'label-primary';
                                   }                        
                                   ?>">
                        <?= $this->workStatus($on_work['status']);?>
                      </span>
                    </td>
                    <td>
                      <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar progress-bar-success" style="width: <?= $percent ?>%">
                        </div>
                      </div>
                      <span class="badge bg-red">
                        <?= $percent ?>%
                      </span>
                    </td>
                    <td>
                      <?= $on_work['rating']?>/10
                    </td>
                    <td class="text-center">
                      <?php if ($this->user_empId==$on_work['emp_id']): ?>
                      <?php 
                        $check_report = $this->checkDailyReporting($on_work['work_id']);
                        if ($check_report==false){
                      ?>
                      <a href="<?php $this->url('work', 'daily_reporting', "&w_id=".$on_work['work_id']."&w_type=".$w_type."&task_id=".$task_id);?>" class="btn bg-green btn-flat <?= ($check_report==true)?'disabled':''?>" title="Daily Reporting">
                        <i class="far fa-file-alt">
                        </i>
                      </a>
                      <?php }else{ ?>
                      <a href='#' data-toggle='modal' data-target='#edit_daily_report' data-id="<?=$check_report?>" data-wid="<?=$on_work['work_id']?>" data-pid="<?=$task_id;?>" data-wtype="<?=$w_type?>" class="btn bg-green btn-flat <?= ($check_report==false)?'disabled':''?>" title="View Today's Report">
                        <i class="fas fa-file-alt">
                        </i>
                      </a>
                      <?php } if ($on_work['status']==1){ ?>
                      <a type="#" title="Keep Pending" class="btn btn-flat bg-yellow take_action" data-status='3' data-id="<?=$on_work['work_id'];?>">
                        <i class="fas fa-pause-circle">
                        </i>
                      </a>
                      <?php } ?>
                      <?php if ($on_work['status']==3){ ?>
                      <a type="#" title="Keep Pending" class="btn btn-flat bg-olive take_action" data-status='1' data-id="<?=$on_work['work_id'];?>">
                        <i class="fas fa-play-circle">
                        </i>
                      </a>
                      <?php } ?>
                      <?php else: ?>
                      <a href="#" class="btn btn-flat bg-yellow" data-wtype="<?=($on_work['project_id']!=0)?'project':'sw'?>" data-id="<?=($on_work['project_id']!=0)?$on_work['project_id']:$on_work['sw_id'];?>" data-toggle="modal" data-target="#rating-modal">
                        <i class="fas fa-star-half-alt">
                        </i>
                      </a>
                      <a type="#" title="Complete" class="btn btn-flat bg-green take_action <?=($on_work['completion_percent']!=100)?'disabled':''?>" data-status='0' data-id="<?=$on_work['work_id'];?>">
                        <i class="fas fa-check-circle">
                        </i>
                      </a>
                      <?php if($on_work['status']==2){?>
                      <a type="#" title="Restart" class="btn btn-flat bg-green take_action" data-status='1' data-id="<?=$on_work['work_id'];?>">
                        <i class="fas fa-play-circle">
                        </i>
                      </a>
                      <?php }else{ ?>
                      <a type="#" title="Cancel" class="btn btn-flat bg-red take_action" data-status='2' data-id="<?=$on_work['work_id'];?>">
                        <i class="fas fa-times-circle">
                        </i>
                      </a>
                      <?php }?>
                      <?php endif ?>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  <div class="modal fade" id="edit_daily_report">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="" method=post>
          <div class="modal-body">
            <input type="hidden" name="id">
            <input type="hidden" name="w_id">
            <input type="hidden" name="p_id">
            <input type="hidden" name="w_type">
            <div class="edit_report_form">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-red pull-left" data-dismiss="modal">Close
            </button>
            <button type="submit" class="btn btn-success" name="update_daily_report">Update
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="rating-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="" method=post>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <fieldset class="rating">
                  <input type="radio" id="star10" name="rating" value="10" />
                  <label class = "full" for="star10" title="Awesome - 10 stars">
                  </label>
                  <input type="radio" id="star9half" name="rating" value="9.5" />
                  <label class="half" for="star9half" title="Awesome - 9.5 stars">
                  </label>
                  <input type="radio" id="star9" name="rating" value="9" />
                  <label class = "full" for="star9" title="Awesome - 9 stars">
                  </label>
                  <input type="radio" id="star8half" name="rating" value="8.5" />
                  <label class="half" for="star8half" title="Excellent - 8.5 stars">
                  </label>
                  <input type="radio" id="star8" name="rating" value="8" />
                  <label class = "full" for="star8" title="Excelent - 8 stars">
                  </label>
                  <input type="radio" id="star7half" name="rating" value="7.5" />
                  <label class="half" for="star7half" title="Good - 7.5 stars">
                  </label>
                  <input type="radio" id="star7" name="rating" value="7" />
                  <label class = "full" for="star7" title="Good - 7 stars">
                  </label>
                  <input type="radio" id="star6half" name="rating" value="6.5" />
                  <label class="half" for="star6half" title="Average - 6.5 stars">
                  </label>
                  <input type="radio" id="star6" name="rating" value="6" />
                  <label class = "full" for="star6" title="Average - 6 stars">
                  </label>
                  <input type="radio" id="star5half" name="rating" value="5.5" />
                  <label class="half" for="star5half" title="Not Bad - 5.5 stars">
                  </label>
                  <input type="radio" id="star5" name="rating" value="5" />
                  <label class = "full" for="star5" title="Not Bad - 5 stars">
                  </label>
                  <input type="radio" id="star4half" name="rating" value="4.5" />
                  <label class="half" for="star4half" title="Pretty good - 4.5 stars">
                  </label>
                  <input type="radio" id="star4" name="Poor" value="4" />
                  <label class = "full" for="star4" title="Poor - 4 stars">
                  </label>
                  <input type="radio" id="star3half" name="rating" value="3.5" />
                  <label class="half" for="star3half" title="Poor - 3.5 stars">
                  </label>
                  <input type="radio" id="star3" name="rating" value="3" />
                  <label class = "full" for="star3" title="Poor - 3 stars">
                  </label>
                  <input type="radio" id="star2half" name="rating" value="2.5" />
                  <label class="half" for="star2half" title="Poor - 2.5 stars">
                  </label>
                  <input type="radio" id="star2" name="rating" value="2" />
                  <label class = "full" for="star2" title="Poor - 2 stars">
                  </label>
                  <input type="radio" id="star1half" name="rating" value="1.5" />
                  <label class="half" for="star1half" title="Very poor - 1.5 stars">
                  </label>
                  <input type="radio" id="star1" name="rating" value="1" />
                  <label class = "full" for="star1" title="Very poor - 1 star">
                  </label>
                  <input type="radio" id="starhalf" name="rating" value="0.5" />
                  <label class="half" for="starhalf" title="Very poor - 0.5 stars">
                  </label>
                </fieldset>
                <input type="hidden" name='id' value="">
                <input type="hidden" name='work_type' value="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close
            </button>
            <button type="submit" class="btn btn-success" name="add_rating">Add
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>
<!-- /.content-wrapper -->

<script>
  $('#rating-modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var work_type = $(e.relatedTarget).data('wtype');
    console.log(work_type);
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="work_type"]').val(work_type);
  });
  $('input[name="rating"]').click(function(){
    console.log(this.value);
  });
  $('#edit_daily_report').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var w_id = $(e.relatedTarget).data('wid');
    var p_id = $(e.relatedTarget).data('pid');
    var w_type = $(e.relatedTarget).data('wtype');
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="w_id"]').val(w_id);
    $(e.currentTarget).find('input[name="p_id"]').val(p_id);
    $(e.currentTarget).find('input[name="w_type"]').val(w_type);
    $.get('?c=work&m=getDailyReporting', {
      id: id}
          , function(result) {
      $('.edit_report_form').html(result);
    });
  });
</script>
<script>
  $(document).ready(function () {
    function activeLi(){
      var active_li = $('#active-li').val();
      if(active_li=='see_all'){
        $('.see_all_li').addClass('active-li');
      }else{
        $('.see_all_li').removeClass('active-li');
      }
      if(active_li=='ongoing'){
        $('.ongoing_li').addClass('active-li');
      }else{
        $('.ongoing_li').removeClass('active-li');
      }
      if(active_li=='pending'){
        $('.pending_li').addClass('active-li');
      }else{
        $('.pending_li').removeClass('active-li');
      }
      if(active_li=='canceled'){
        $('.canceled_li').addClass('active-li');
      }else{
        $('.canceled_li').removeClass('active-li');
      }
      if(active_li=='completed'){
        $('.completed_li').addClass('active-li');
      }else{
        $('.completed_li').removeClass('active-li');
      }
      $('.assign_title').html('');
      $('.date_title').html('');
    }
    $(document).on('click','.take_action',function(){
      var status    = $(this).data('status');
      var work_id   = $(this).data('id');
      $.get('?c=ajax&m=changeWorkStatus', {
        status: status, work_id:work_id}
            , function(result) {
        if (result) {
          console.log(result);
          location.reload();
        }
      });
    });
    $('.select2').select2();
    $('#work_list').addClass('active');
    $('#vw_assign_work').addClass('active');

    $('#data-table').DataTable({
        responsive: true,
        ordering: false,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'print',
            text: 'Print',
            footer: true,
            title: function() {
                return "All Work List";
            },
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            customize: function(win) {
                $(win.document.body).css('font-size', '12px');
                $(win.document.body).find('h1').addClass('text-center').css('font-size', '20px');
                $(win.document.body).find('table').addClass('container').css('font-size', 'inherit');
                $(win.document.body).find('table').removeClass('table-bordered');
            }
        }
        ]
    });
    $('.buttons-print span').html('<i class="fas fa-print"></i>');

    $('#see_all').on('click', function(){
      var type = 'see_all';
      getWorkList(type);
      $('.box-title').html('All Works');
      $('#filter_type').val(type);
      $('#active-li').val('see_all');
      activeLi();
    });
    
    $('#comp_projects').on('click', function(){
      var type = 'comp_projects';
      getWorkList(type);
      $('.box-title').html('All Completed Projects');
      $('#filter_type').val(type);
      $('#active-li').val('completed');
      activeLi();
    });

    $('#comp_sw').on('click', function(){
      var type = 'comp_sw';
      getWorkList(type);
      $('.box-title').html('All Completed Single Works');
      $('#filter_type').val(type);
      $('#active-li').val('completed');
      activeLi();
    });

    $('#comp_all').on('click', function(){
      var type = 'comp_all';
      getWorkList(type);
      $('.box-title').html('All Completed Works');
      $('#filter_type').val(type);
      $('#active-li').val('completed');
      activeLi();
    });

    $('#on_projects').on('click', function(){
      var type = 'on_projects';
      getWorkList(type);
      $('.box-title').html('Ongoing Projects');
      $('#filter_type').val(type);
      $('#active-li').val('ongoing');
      activeLi();
    });

    $('#on_sw').on('click', function(){
      var type = 'on_sw';
      getWorkList(type);
      $('.box-title').html('Ongoing Single Works');
      $('#filter_type').val(type);
      $('#active-li').val('ongoing');
      activeLi();
    });

    $('#on_all').on('click', function(){
      var type = 'on_all';
      getWorkList(type);
      $('.box-title').html('All Ongoing Works');
      $('#filter_type').val(type);
      $('#active-li').val('ongoing');
      activeLi();
    });

    $('#pending_projects').on('click', function(){
      var type = 'pending_projects';
      getWorkList(type);
      $('.box-title').html('Pending Projects');
      $('#filter_type').val(type);
      $('#active-li').val('pending');
      activeLi();
    });

    $('#pending_sw').on('click', function(){
      var type = 'pending_sw';
      getWorkList(type);
      $('.box-title').html('Pending Single Works');
      $('#filter_type').val(type);
      $('#active-li').val('pending');
      activeLi();
    });

    $('#pending_all').on('click', function(){
      var type = 'pending_all';
      getWorkList(type);
      $('.box-title').html('All Pending Works');
      $('#filter_type').val(type);
      $('#active-li').val('pending');
      activeLi();
    });

    $('#canceled_projects').on('click', function(){
      var type = 'canceled_projects';
      getWorkList(type);
      $('.box-title').html('Canceled Projects');
      $('#filter_type').val(type);
      $('#active-li').val('canceled');
      activeLi();
    });

    $('#canceled_sw').on('click', function(){
      var type = 'canceled_sw';
      getWorkList(type);
      $('.box-title').html('Canceled Single Works');
      $('#filter_type').val(type);
      $('#active-li').val('canceled');
      activeLi();
    });

    $('#canceled_all').on('click', function(){
      var type = 'canceled_all';
      getWorkList(type);
      $('.box-title').html('All Canceld Works');
      $('#filter_type').val(type);
      $('#active-li').val('canceled');
      activeLi();
    });

    $('.assigned_by_me').on('click', function(){
      var type        = $('#filter_type').val();
      var filter_assign = 'assigned_by_me';
      $('#filter_assign').val(filter_assign);
      getWorkList(type, emp='', startDate='', endDate='', filter_assign);
      $('.assign_title').html('Assigned By Me');
      $('.date_title').html('');
      $('#filter_type').val(type);
    });

    $('.assigned_to_me').on('click', function(){
      var type          = $('#filter_type').val();
      var filter_assign = 'assigned_to_me';
      $('#filter_assign').val(filter_assign);
      getWorkList(type, emp='', startDate='', endDate='', filter_assign);
      $('.assign_title').html('Assigned To Me');
      $('.date_title').html('');
      $('#filter_type').val(type);
    });

    $('select[name="emp_assigned_by"]').on('change', function() {
      var emp     = this.value;
      var empData = emp.split('-');
      emp         = empData[0];
      var empName = empData[1];
      var type    = $('#filter_type').val();
      var filter_assign = 'assigned_by';
      $('#filter_assign').val(filter_assign);
      $('.date_title').html('');
      $('#emp-id').val(emp);
      getWorkList(type, emp, startDate='', endDate='', filter_assign);
      $('.assign_title').append(' Assigned By '+empName);
      $('#filter_type').val(type);
    });

    $('select[name="emp_assigned_to"]').on('change', function() {
      var emp     = this.value;
      var empData = emp.split('-');
      emp         = empData[0];
      var empName = empData[1];
      var type    = $('#filter_type').val();
      var filter_assign = 'assigned_to';
      $('#filter_assign').val(filter_assign);
      $('.date_title').html('');
      $('#emp-id').val(emp);
      getWorkList(type, emp, startDate='', endDate='', filter_assign);
      $('.assign_title').append(' Assigned To '+empName);
      $('#filter_type').val(type);
    });
    $('.ongoing_li').on('click', function(){
      removeEmpDiv();

    });
    $('.pending_li').on('click', function(){
      removeEmpDiv();
    });
    $('.canceled_li').on('click', function(){
      removeEmpDiv();
    });
    $('.completed_li').on('click', function(){
      removeEmpDiv();
    });
    $('.see_all_li').on('click', function(){
      removeEmpDiv();
    });

    $('.filter_by').on('click', function(){
      removeEmpDiv();

    });
    function removeEmpDiv(){
      $('#emp_div_assigned_by').removeClass('in');
      $('#emp_div_assigned_to').removeClass('in');
      $('#filter_assign').val('');
      $('#emp-id').val('');
    }
    function getWorkList(type, emp='', startDate='', endDate='', filterAssign=''){
      var output;
      $.get('?c=ajax&m=getWorkListByFilter', {
        type: type, empid:emp, startDate:startDate, endDate: endDate, filterAssign: filterAssign}
            , function(result) {
        $('.box-body').html(result);
        $('#data-table').DataTable({
            responsive: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'print',
                text: 'Print',
                footer: true,
                title: function() {
                    return "All Work List";
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
                customize: function(win) {
                    $(win.document.body).css('font-size', '12px');
                    $(win.document.body).find('h1').addClass('text-center').css('font-size', '20px');
                    $(win.document.body).find('table').addClass('container').css('font-size', 'inherit');
                    $(win.document.body).find('table').removeClass('table-bordered');
                }
            }
            ]
        });
        $('.buttons-print span').html('<i class="fas fa-print"></i>');
      });
    }
    //Date range as a button
    $('#daterange-btn').daterangepicker(
    {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(0, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      var startDate       = start.format('YYYY-MM-DD');
      var endDate         = end.format('YYYY-MM-DD');
      var type            = $('#filter_type').val();
      var filter_assign   = $('#filter_assign').val();
      var emp             = $('#emp-id').val();
      getWorkList(type, emp, startDate, endDate, filter_assign);
      $('.date_title').html('Whose Submission Date Between '+ start.format('D MMMM YYYY') +' to '+end.format('D MMMM YYYY'));
    });
  });
</script>
<?php include 'views/layouts/footer.php'; ?>