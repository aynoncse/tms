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
    <div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">See Notices</h3>
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
                        <th class="col-md-1">S.N.</th>
                        <th class="col-md-2">Date</th>
                        <th class="col-md-3">Notice</th>
                        <th class="col-md-4">Send to</th>
                        <th class="col-md-2 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i=0; foreach ($notices as $notice): $i++;
                      //$employee = explode(',', $notice['employee']);
                      ?>
                      <tr>
                        <td><?= $i;?></td>
                        <td><?= $this->date($notice['created_at'],'d M Y, h:i:s a') ?></td>
                        <td>
                          <?php
                          if (strlen($notice['notice'])<70) {
                            echo $notice['notice'];
                          } else {
                            echo $this->textShorten($notice['notice'],70)?>
                            <a data-target="#full_description" data-toggle="modal" data-text="<?=$notice['notice']?>">Read More</a>
                            <?php 
                          }
                          ?>
                        </td>

                        <td>
                          <?php
                          $k=1; $j= sizeof($employee);
                          foreach ($employee as $emp) {
                            echo $this->empName($emp);
                            if($k!=$j){
                              echo ", ";
                            }
                            $k++;
                          } ?>
                        </td>
                        <td class="text-center">
                          <button type="button" data-toggle="modal" data-target="#edit_notice" data-id="<?= $notice['id']?>" data-notice="<?= $notice['notice'];?>" class="btn bg-green btn-flat ">
                            <i class="fa fa-edit"></i>
                          </button>

                          <a onclick="return confirm('Are you sure you want to delete this item?');" href="?c=notice&amp;m=see_notices&amp;action=del&amp;id=<?= $notice['id']?>" class="btn bg-red btn-flat "><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
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

<div class="modal fade" id="edit_notice">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Notice</h4>
      </div>

      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" class="assign-work-form">
          <input type="hidden" name="id">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Notice Body</label>
                <textarea name="notice" class="form-control" rows="3" id="editor1"></textarea>
              </div>
              <!-- /.form-group -->
            </div>

            <div class="col-md-4 col-md-offset-4">
              <button type="submit" name='edit_notice' class="btn bg-green text-center" style="width: 100%;">Submit</button>
            </div>
          </div>
        </form>
      </div>
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
  $('#full_description').on('show.bs.modal', function(e) {
    var text = $(e.relatedTarget).data('text');
    $('#desc_text').html(text);
  });
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
  })
</script>
<script>
  $(document).ready(function() {
    $('#see_notices').addClass('active');
    $('#vw_notice').addClass('active');

    $('#data-table').DataTable( {
      responsive: true,
      searching: true,
      bLengthChange: false,
      bSort:false
    });

    $('#edit_notice').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var notice = $(e.relatedTarget).data('notice');

      $(e.currentTarget).find('input[name="id"]').val(id);

      CKEDITOR.instances.editor1.setData(notice);
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