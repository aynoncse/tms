<?php include 'views/layouts/header.php';?>
<link rel="stylesheet" href="assets/css/work_list_style.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
   <div class="row">
    <div class="col-md-12">
      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">All Recommended Works</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="data-table" class="table table-bordered table-striped " style="width: 100%">
              <thead class="data-table-head">
                <tr class="data-table-head-row bg-green">
                  <th width="1%">SN.</th>
                  <th width="13%">Title</th>
                  <?php if($this->user_ty==1){?><th width="10%">Recommended To</th><?php } ?>
                  <th width="15%">Recommended By</th>
                  <th width="13%">To Start On</th>
                  <th width="13%">Deadline On</th>
                  <th width="5%">Remaining</th>
                  <th width="10%">Status</th>
                  <th class="text-center" width="20%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=0;

                foreach ($on_works_all as $on_work) {
                  $i++;
                  if($on_work['project_id']!=0){
                    $w_type= 'np';
                  }if($on_work['sw_id']!=0){
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
                  <tr>
                    <td><?= $i; ?></td>
                    <td>
                      <?php if ($on_work['sw_pid']!=0 || $on_work['sw_pid']!=NULL) {
                        $project = $this->db->details_by_cond('tbl_projects','id='.$on_work['sw_pid']);?>
                        <a href="<?php $this->url('work', 'single_work_list', "&id=".$on_work['sw_id']);?>">
                          <?= $on_work['work_title']?>
                          <?php
                          if($on_work['sw_pid'] !=0){
                            echo ' - '. $project['project_name'];
                          } else {
                            echo ' - '. $on_work['count'];
                          }
                          ?>
                        </a>
                      <?php }else{?>
                        <a href="<?php $this->url('work', 'single_project_list', "&id=".$on_work['project_id']);?>"><?= $on_work['work_title'];?></a>
                      <?php } ?>                           
                    </td>

                    <?php if($this->user_ty==1){?>
                      <td><?= $this->empName($on_work['emp_id']);?></td>
                    <?php } ?>
                    <td>
                      <?php
                      if($on_work['emp_id']==$on_work['assigned_by']){
                        echo 'Self-Assigned';
                      }elseif($this->user_empId==$on_work['assigned_by']){
                        echo 'Myself';
                      }else{
                        echo $this->empName($on_work['assigned_by']);
                      }
                      ?>
                    </td>
                    <td>
                      <?= date('d, M Y', strtotime($on_work['start_date']));?>
                    </td>
                    <td class="<?= $submit_date == date('y-m-d')?'bg-red':''; ?>">
                      <?= date('d, M Y', strtotime($submit_date));?>
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
                       <td class="text-center">
                      <?php if ($this->user_ty!=1){ ?>
                          
                        <?php if ($on_work['status']==7) {?>
                        <a type="#" class="btn bg-green take_action <?=($on_work['status']==6)?'disabled':''?>" data-status='6' data-id="<?=$on_work['work_id'];?>"><i class="fas fa-check"></i>
                        </a>
                        <?php }else{?>
                        <a type="#" title="Let's Start" class="btn bg-green take_action <?=($on_work['status']==1)?'disabled':''?>" data-status='1' data-id="<?=$on_work['work_id'];?>"><i class="far fa-play-circle"></i>
                        </a>
                        <?php }?>
                        <a type="#" title="Forward to Someone Else" class="btn bg-olive " data-id="<?=$on_work['work_id'];?>" data-toggle="modal" data-target="#forward-modal"><i class="fas fa-share-square"></i>
                        </a>
                        <a type="#" title="Refuse This Work" class="btn bg-red take_action <?=($on_work['status']==5)?'disabled':''?>" data-status='5' data-id="<?=$on_work['work_id'];?>"><i class="fas fa-times"></i>
                        </a>
                        
                      <?php } ?>
                      <?php if ($this->user_ty==1){ ?>

                      <?php if ($on_work['status']==5) {?>                        
                        <a type="#" title="Forward to Someone Else" class="btn btn-flat bg-olive " data-id="<?=$on_work['work_id'];?>" data-toggle="modal" data-target="#forward-modal"><i class="fas fa-share-square"></i>
                        </a>
                      <?php } ?>
                        <a type="#" title="Cancel This Work" class="btn btn-flat bg-red take_action <?=($on_work['status']==2)?'disabled':''?>" data-status='2' data-id="<?=$on_work['work_id'];?>"><i class="fas fa-times"></i>
                      <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
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


<div class="modal fade" id="forward-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= $_SERVER['REQUEST_URI']?>" method=post>
        <div class="modal-body">
          <input type="hidden" name="work_id">
          <div class="">
            <div class="form-group">
              <label>Select Employee</label>
              <select name="forward_to" class="form-control select2" style="width: 100%;">
                <option disabled selected hidden>Click to Select</option>
                <?php  foreach ($emp_data as $emp): ?>
                  <option value="<?=$emp['emp_id']?>"><?=$emp['emp_name'];?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea name="description" class="form-control" rows="3" id="editor1"></textarea>
            </div>
            <!-- /.form-group -->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-red pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="work_forward">Forward</button>
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

<script src="assets/js/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
  
    CKEDITOR.replace('editor1')
  })
</script>
<script>
 $(document).ready(function (e) {
  //  $.get('?c=ajax&m=recommendedWorks', {}, function(result) {
  //   if(result){
  //     $('.box-body').html(result);
  //     console.log(result);
  //     $('#data-table').DataTable( {
  //       'destroy': true,
  //       responsive: true,    
  //       bLengthChange: true,
  //       bSort:false,
  //       columnDefs: [
  //       { responsivePriority: 1, targets: 1 },
  //       ]
  //     });
  //   }
  // });

  $('#forward-modal').on('show.bs.modal', function(e) {
    var work_id = $(e.relatedTarget).data('id');
    $(e.currentTarget).find('input[name="work_id"]').val(work_id);
  });

  $('.select2').select2();
  $('#recommended_works').addClass('active');
  $('#vw_assign_work').addClass('active');

  $('#data-table').DataTable( {
    responsive: true,
    bLengthChange: true,
    bSort:false,
    columnDefs: [
    { responsivePriority: 1, targets: 1 },
    ]
  });

  $(document).on('click','.take_action',function(){
     
    var status    = $(this).data('status');
    var work_id   = $(this).data('id');

    $.get('?c=ajax&m=changeWorkStatus', {status: status, work_id:work_id}, function(result) {
      if (result) {
        console.log(result);
        location.reload();
      }
    });
  });
});

</script>

<?php include 'views/layouts/footer.php'; ?>