
<?php include 'views/layouts/header.php';?>
<!-- <link rel="stylesheet" href="assets/css/chat_box.css"> -->
 <style>
  .progress {
    background-color: #d0dee4;
    box-shadow: 2px 1px 2px -1px #28699f;
  }
  .emp-img {
    position: absolute;
    display: contents;
  }
  .emp-img img{
    margin-left: auto;
    margin-right: auto;
    display: block;
  }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="row">
        <div class="col-md-12">
         <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Project Details</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="<?php $this->url('work', 'work_files', "&w_id=".$project['w_id']);?>">
                    <i class="fas fa-folder-open"></i> See Files
                  </a>
                </li>
                <li>
                  <a href="<?php $this->url('work', 'edit_work_files', "&w_id=".$project['w_id']);?>">
                    <i class="fas fa-pen-square"></i> Edit
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav> 
      </div>
    </div>
          <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Project Title: <?= $project['project_name']?></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-2"><p class="text-right">Completion:</p></div>
                  <div class="col-md-8">
                    <div class="progress progress-striped active">
                      <div class="progress-bar progress-bar-<?= $color;?>" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="<?= $percent ?>%" style="width:<?= $percent ?>%;<?= $percent==0?'color:#000;':''?>">
                        <?= $percent ?>%
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-8 col-md-offset-2" style="border: 1px solid #337AB7;padding: 20px 0 0;box-shadow: 0px 0px 2px 1px #ececec;border-radius:10px;color: #000;">
                    <div class="col-md-8 col-md-offset-2 emp-img">
                      <img class="img-circle" style="padding: 3px; background: #D9EDF7; height: 100px;" src="<?php if (empty($emp['emp_img'])){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $emp['emp_img'];} ?>" alt="">
                    </div>
                    <div class="col-md-12 text-center">
                      <?= $emp['emp_name'] ?>
                    </div>


                    <table class="table table-bordered" style="font-size: 14px; font-family: 'Arial Black'; margin-bottom: 0">

                      <tr>
                        <th class="bg-navy">Project Title</th>
                        <td class="bg-gray"><?= $project['project_name']?></td>
                      </tr>

                      <tr>
                        <th class="bg-navy">Description</th>
                        <td class="bg-gray"><?= $project['description']?></td>
                      </tr>

                      

                      <tr>
                        <th class="bg-navy">Assigned By</th>
                        <td class="bg-gray"><?= $this->empName($project['assigned_by']);?></td>
                      </tr>

                      <tr>
                        <th class="bg-navy">Rating</th>
                        <td class="bg-gray"><?= $project['rating']?>/10</td>
                      </tr>  

                      <tr>
                        <th class="bg-navy">Start Date</th>
                        <td class="bg-gray"><?= $this->date($project['start_date'],'d F, Y');?></td>
                      </tr>

                      <tr class="">
                        <th class="bg-navy" style="border-radius:0 0 0 10px;">End Date</th>
                        <td class="bg-gray" style="border-radius:0 0 10px 0;"><?=  $this->date($project['end_date'], 'd F, Y')?></td>
                      </tr>

                    </table>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-6">
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->

        <!-- /.row -->
      </div>
      <!-- /.box-footer -->

    <div class="col-md-12">
      <div class="box">
        <div class="box-body">                      
          <div class="col-md-12">
            <div class="panel panel-success">
              <div class="panel-heading"><b>Team Name:</b> <?= $project['group_name'] ?></div>
              <div class="panel-body">
                <div class="row">
                  <?php foreach ($emp_data as $emp) {?>
                    <div class="col-md-4 col-sm-6">
                      <div class="panel panel-info">
                        <div class="panel-heading"><?= $emp['emp_name'];?></div>
                        <div class="panel-body">
                          <img class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-8 col-md-offset-2 img-circle" style="padding: 3px; background: #D9EDF7; height: 100% auto;" src="<?php if (empty($emp['emp_img'])){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $emp['emp_img'];} ?>" alt=""><br>
                        </div>
                        <div class="panel-footer text-success" style="background: #D9EDF7;">
                          <p>Role: <?= ($emp['role']==1)?'Project Manager':'Member' ?></p>
                          <p>Description: <?php $emp['description'] ?></p>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
            </div>
          </div>
          <!-- ./box-body -->
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
  <button class="open-button text-center" onclick="openForm()"><i class="fas fa-comment-dots"></i>
    <span id='new-comments'></span>
  </button>
  <div class="chat-popup" id="chat_box">
    <div class="chat-header bg bg-primary">
      <button type="button" class="btn cancel" onclick="closeForm()"><i class="fas fa-times"></i></button>
      <h5 >Chat about <b><?= $project['project_name']?></b></h5>
    </div>
    <div class="chat-body">

    </div>
    <form action="" class="form-container">
      <input type="hidden" name='w_id' value="<?=$project['w_id'];?>">
      <textarea class="form-control" placeholder="Type message.." name="comment" required></textarea>
      <button type="button" id="submit_comment" class="btn btn-info pull-right">Send</button>
    </form>
  </div>
</div>
<!-- /.content-wrapper -->

<script>
  function openForm() {
    document.getElementById("chat_box").style.display = "block";
  }

  function closeForm() {
    document.getElementById("chat_box").style.display = "none";
  } 
  var w_id = $('input[name="w_id"]').val();
  $(document).ready(function(){


    //console.log(w_id);
    refreshComment();

    

    $('.open-button').click(function(){
     $.get('?c=work&m=changeWorkCommentStatus', {'w_id': w_id}, function(result) {
      refreshComment();
      var objDiv = $(".chat-body");
      var h = objDiv.get(0).scrollHeight;
      objDiv.animate({scrollTop: h});
    });
   });
    function refreshComment(){
      $.ajax({
        type:"GET", 
        url: "?c=work&m=getWorkComments",
        data: {
          w_id: w_id
        },
        success: function(data) {
        //console.log(data);
        $(".chat-body").html(data);
      }
    });
    }

    $("#chat-box").on('focus',function(){
      refreshComment();
      alert('hello');
    });

    function storeComments(){
      var w_id = $('input[name="w_id"]').val();
      var comment = $('textarea[name="comment"]').val();
      //console.log(comment);

      $.get('?c=work&m=storeWorkComments', {w_id: w_id, comment: comment}, function(result) {
        //console.log(result);
      });
      $('textarea[name="comment"]').val('');
    }


    $("#submit_comment").click(function(){
      storeComments();
      refreshComment();
      var objDiv = $(".chat-body");
      var h = objDiv.get(0).scrollHeight;
      objDiv.animate({scrollTop: h});
    }); 

    $('#work_list').addClass('active');
    $('#vw_assign_work').addClass('active');


    $('.chat-popup').on('keypress', function (e) {
     if (e.which==13) {
      storeComments();
      refreshComment();
      $('textarea[name="comment"]').val('');

      var objDiv = $(".chat-body");
      var h = objDiv.get(0).scrollHeight;
      objDiv.animate({scrollTop: h});
    }
  });

  });

  function newCommentCount(){
    $.ajax({
      type:"GET", 
      url: "?c=work&m=newCommentsCount",
      data: {
        w_id: w_id
      },
      success: function(data) {
        //console.log(data);
        $("#new-comments").html(data);
      }
    });
  }
  setInterval(newCommentCount,1000);
</script>
<?php include 'views/layouts/footer.php'; ?>