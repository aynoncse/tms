<?php include 'views/layouts/header.php';?>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Target Work List for The Month of <?= date('F, Y')?></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="data-table" class="table table-bordered table-striped" style="width: 100%">
              <thead class="data-table-head bg-green">
                <tr class="data-table-head-row">
                  <th style="width: 10px">SN.</th>
                  <th>Employee</th>
                  <th>Type</th>
                  <th>Work Title</th>
                  <th>Count</th>
                  <th>Description</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; foreach ($target_works as $target_work) { $i++; ?>
                  <tr>
                    <td class="col-md-1"><?= $i; ?></td>
                    <td class="col-md-2"><?= $this->empName($target_work['emp_id']);?></td>
                    <td class="col-md-1"><?= $target_work['target_type']==1?'Daily':'Monthly';?></td>
                    <td class="col-md-2"><?= $target_work['work_title'];?></td>
                    <td class="col-md-1">
                      <?= $target_work['count'];?>
                      <?=$target_work['daily_count']>0?' ('.$target_work['daily_count'].'/Day)':'';?>                        
                    </td>
                    <td class="col-md-3">
                      <?php
                      if (strlen($target_work['description'])<40) {
                        echo $target_work['description'];
                      } else {
                        echo $this->textShorten($target_work['description'],40)?>
                        <a data-target="#full_description" data-toggle="modal" data-text="<?=$target_work['description']?>">Read More</a>
                        <?php 
                      }
                      ?>
                    </td>
                    <td class="col-md-2">                      
                      <button class="btn btn-sm bg-green col-md-5" type="button" data-target='#edit_target' data-toggle='modal' data-id='<?=$target_work['id']; ?>' data-work_title='<?=$target_work['work_title'];?>'  data-count='<?=$target_work['count']; ?>' data-daily_count='<?=$target_work['daily_count']; ?>' data-target_type='<?=$target_work['target_type']; ?>' data-description='<?=strip_tags($target_work['description']); ?>'> <i class="fas fa-edit"></i></button>     
                      
                      <a class="btn btn-sm btn-danger col-md-5 col-md-offset-1" href="<?php $this->url('work', 'target_work_list', "&id=".$target_work['id']."&action=delete");?>" onclick="return confirm('Are you sure you want to delete this item?');">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->

          <div class="modal fade" id="full_description">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="desc_text">
                    
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="edit_target">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="" method="post">                  
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name='id'>
                    <div class="form-group">
                      <label>Work Title</label>
                      <input list="work_titles" type="text" class="form-control" name="work_title"autocomplete="off"/>

                      <datalist id="work_titles">
                        <?php foreach ($work_titles as $title) {?>
                          <option value="<?= $title['work_title']; ?>"></option>
                        <?php } ?>
                      </datalist>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label>Count</label>
                      <input type="text" class="form-control" onkeypress="return numbersOnly(event)" name="count" placeholder="Put a Number" autocomplete="off"/>
                    </div>

                    <div class="form-group hidden" id="daily-count">
                      <label>Daily Count</label>
                      <input type="text" class="form-control" onkeypress="return numbersOnly(event)" name="daily_count" placeholder="Put a Number" autocomplete="off"/>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label>Description</label>
                      <textarea name="description" class="form-control" rows="3" id="editor">
                      </textarea>
                    </div>
                    <!-- /.form-group -->

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-green" name="update">Update</button>
                  </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

        </div>
        <!-- /.box -->
      </div>
      <!-- /.col-md-12 -->
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
    CKEDITOR.replace('editor')
  })
</script>
<script>
  $('#full_description').on('show.bs.modal', function(e) {
      var text = $(e.relatedTarget).data('text');
      $('#desc_text').html(text);
  });

  $('#edit_target').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var work_title = $(e.relatedTarget).data('work_title');
    var count = $(e.relatedTarget).data('count');
    var daily_count = $(e.relatedTarget).data('daily_count');
    var target_type = $(e.relatedTarget).data('target_type');
    var description = $(e.relatedTarget).data('description');
    //console.log(work_title);
    if (target_type==2) {
      $('#daily-count').removeClass('hidden');
    }else{
      $('#daily-count').addClass('hidden');
    }
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="work_title"]').val(work_title);
    $(e.currentTarget).find('input[name="count"]').val(count);
    $(e.currentTarget).find('input[name="daily_count"]').val(daily_count);
    CKEDITOR.instances.editor.setData(description);
  });
  
</script>
<script>
 $(document).ready(function () {
  $('#target_work_list').addClass('active');
  $('#vw_assign_work').addClass('active');
} );
</script>

<?php include 'views/layouts/footer.php'; ?>