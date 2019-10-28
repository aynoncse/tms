 <?php include 'views/layouts/header.php';?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Daily Reportings</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">

                <div class="col-md-12">
                  <table id="data-table" class="table table-bordered table-striped" style="width: 100%">
                    <thead class="data-table-head">
                      <tr class="data-table-head-row">
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Work Title</th>
                        <th>Description</th>
                        <th>Completion</th>
                        <th>Commment</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($works as $work): ?>


                        <tr>
                          <td><?= $this->date($work['date'],'d M Y') ?></td>
                          <td><?= $this->empName($work['emp_id']) ?></td>
                          <td>
                            <a href="<?php $this->url('work', 'single_work_list', "&id=".$work['sw_id']);?>"><?= !empty($work['work_title']==0)?$work['work_title']:''?></a>

                            <a href="<?php $this->url('work', 'single_project_list', "&id=".$work['project_id']);?>"><?= !empty($work['project_name']==0)?$work['project_name']:''?></a>
                          </td>
                          <td><?= $work['description'];?></td>
                          <td><span class="badge bg-green"><?= $work['completion_percent'];?>%</span></td>
                          <td><?= $work['director_comment'];?></td>
                          <td><button type="button" class="btn bg-green" data-id='<?= $work['id'];?>' data-toggle="modal" data-target="#comment-modal">Comment</button></td>
                        </tr>

                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
                
                <div class="modal fade" id="comment-modal">
                  <div class="modal-dialog">
                    <div class="modal-content">                      
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add Comment</h4>
                      </div>
                      <form action="" method=post>
                        <div class="modal-body">
                          <div class="from-group">
                            <textarea class="form-control" name="comment" placeholder="Put Your Comment Here..." required></textarea>
                          </div>
                        </div>
                        <input type="hidden" name='id' value="">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" name="add_comment">Add</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->

            <!-- /.row -->
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function(){
   $('#comment-modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    $(e.currentTarget).find('input[name="id"]').val(id);
  });
   $('#data-table').DataTable( {
    responsive: true,
    searching: true,
    bLengthChange: false,
    bSort:false
  });

   $('#view_daily_reporting').addClass('active');
   $('#vw_assign_work').addClass('active');
 });
</script>
<?php include 'views/layouts/footer.php'; ?>