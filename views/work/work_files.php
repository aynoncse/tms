<?php include 'views/layouts/header.php';?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <div class="col-md-6">
              <h3 class="box-title">File List</h3>
            </div>
            <div class="col-md-6">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="upload-btn-wrapper">
                  <button class="upbtn btn btn-flat"><i class="fas fa-upload"></i> Upload New</button>
                  <input id="upload-btn" type="file" name="attachment" />
                </div>
                <div class="help-block">
                  <p></p>
                </div>
                <input type="submit" name="upload" value="Upload" class="hidden btn btn-flat btn-info" style="width:112px; position: absolute; top:0;">
              </form>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <?php 
            $i=1;
            foreach ($files as $file) {
              $file_name = explode('.',$file['file_path']);
              $file_ext = strtolower(end($file_name));

              if ($file_ext == 'txt') {
                $file_icon = 'fa-file-alt';
              }elseif ($file_ext=='pdf') {
                $file_icon = 'fa-file-pdf';
              }elseif ($file_ext=='doc' || $file_ext=='docx') {
                $file_icon = 'fa-file-word';
              }elseif ($file_ext=='zip' || $file_ext=='rar') {
                $file_icon = 'fa-file-archive';
              }elseif ($file_ext =='php' || $file_ext=='css' || $file_ext=='html' || $file_ext=='js') {
                $file_icon = 'fa-file-code';
              }
          ?>
              <div class="col-md-2 file-div">
                <a class="delete-file" href="?c=work&m=work_files&action=delete&id=<?=$file['id'];?>&w_id=<?=$file['work_id']?>&file=<?$file['file_path']?>" title="" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-times delete-icon"></i></a>
                <i class="fas <?=$file_icon;?> file-icons" title=" File Name: <?=$file['file_path']?> &nbsp;
Type: <?=$file_ext;?> File
Uploaded: <?=$this->formatDate($file['created_at'], 'd M Y, h:i:s a')?> &nbsp;
Uploaded by: <?= $this->entry_by($file['created_by']);?>"></i>
                  <a class="btn btn-flat bg-navy" href="work_files/<?=$file['file_path']?>" download><i class="fa fa-download"></i> Download</a>
                </div>
                <?php $i++;} ?>
              </div>
              <!-- /.box-body -->
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

    <script>
     $(document).ready(function () {
      $('#upload-btn').on('change', function() {
        var i = $(this).prev('label').clone();
        var file = $('#upload-btn')[0].files[0].name;
        $('.help-block p').text(file);
        $('input[name=upload]').removeClass('hidden');
      });

      $('.delete-file').on('click', function() {
       
      });
      $('#vw_assign_work').addClass('active');
    });
  </script>

  <?php include 'views/layouts/footer.php'; ?>