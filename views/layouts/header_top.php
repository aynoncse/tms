
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="assets/img/logo_bsd.png" class="img-responsive" alt="logo"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="assets/img/logo_bsd.png" class="img-responsive" alt="logo"></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="messages-menu" id="attendance">
              <?php
              $is_attend = $this->db->details_by_cond('tbl_attendance', 'emp_id="'.$this->user_empId.'" AND t_date="'.date('Y-m-d').'"');
                //print_r($is_attend);
              if(!$is_attend){
                ?>
                <button type="button" id="give_attendance" class="btn btn-flat" title="Give Attendance" style="font-size: 20px;background: rgba(255,0,0,0.2); color:#fff; transform: 1s;position: relative;display: block;padding: 10px 15px;">
                  <i class="fas fa-hand-point-up"></i>
                </button>

              <?php }else{?>
                <?php if ($is_attend['leaving_time']==NULL){?>
                  <button type="button" id="leave_office" class="btn btn-flat" title="Leaving for Today" style="font-size: 20px;background: rgba(255,0,0,0.2); color:#fff; transform: 1s;position: relative;display: block;padding: 10px 15px;">
                    <i class="fas fa-hand-point-down"></i>
                  </button>
                <?php }}?>
              </li>
              <?php $notices = $this->db->view_all_by_cond('tbl_notice','status=1'); ?>
              <li class="messages-menu" id="notice_board">
                <a href="#" data-id='' data-toggle="modal" data-target="#notice-modal">
                  <i class="fas fa-exclamation-triangle"></i>
                  <?php if (sizeof($notices)>0): ?>
                    <span class="label label-danger"><?=sizeof($notices);?></span>
                  <?php endif ?>
                </a>
              </li>

              <li class="dropdown messages-menu msg-icon">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class=""><input class ="chat_search" name="chat_search" type="text" placeholder="Search..."></li>
                  <div class="person_list"></div>

                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu" id="message_list">
                              
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->

              <?php $notifications = $this->getNotification(); ?>

              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?= (sizeof($notifications)>0)?sizeof($notifications):'';?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?= sizeof($notifications);?> new notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php foreach ($notifications as $notification) {?>
                        <li><!-- Task item -->
                          <a href="index.php?<?=$notification['path']?>" id='notification-status' data-id='<?=$notification['id']?>'>
                            <h3>
                              <?= $notification['notification']; ?>
                            </h3>
                          </a>
                        </li>
                        <!-- end task item -->
                      <?php  } ?>
                    </ul>
                  </li>
                  <li class="footer"><a href="<?php $this->url('work', 'work_list');?>">View all</a></li>
                </ul>
              </li>

              <?php $notifications = $this->importantNotification(); ?>

              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger"><?= (sizeof($notifications)>0)?sizeof($notifications):'';?></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php foreach ($notifications as $notification) {?>
                        <li><!-- Task item -->
                          <a href="index.php?<?=$notification['path']?>" id='notification-status' data-id='<?=$notification['id']?>'>
                            <h3>
                              <?= $notification['notification']; ?>
                            </h3>
                          </a>
                        </li>
                        <!-- end task item -->
                      <?php  } ?>
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="<?php $this->url('work', 'work_list');?>">View all tasks</a>
                  </li>
                </ul>
              </li>

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php if (empty($this->user_img)){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $this->user_img;} ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= $this->user_fullName ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php if (empty($this->user_img)){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $this->user_img;} ?>" class="img-circle" alt="User Image">

                    <p>
                      <span class="hidden-xs"><?= $this->user_fullName;?></span> - <?= $this->empDesignation($this->user_designation);?> 
                      <small>Member since <?php echo date('d M Y', strtotime($this->user_joinDate))?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                <!-- <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php $this->url('user','logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>

    </nav>
  </header>

  
  <div class="modal fade" id="notice-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Notice Board</h4>
        </div>
        <div class="modal-body">
          <!-- <div class="noticeboard">

          </div> -->
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="noticeboard">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <?php for ($i=0; $i <sizeof($notices); $i++) { ?>


                  <li data-target="#myCarousel" data-slide-to="<?= $i;?>" class="<?=($i==0)?'active':''?>"></li>
                <?php } ?>
              </ol>
              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <?php
                $i=0;
                foreach ($notices as $notice):
                  $employee = explode(',', $notice['employee']);
                  if(in_array($_SESSION['emp_id'], $employee) || $this->user_ty==1):

                    ?>
                    <div class="notice-paper item <?=($i==0)?'active':''?>">
                      <img src="assets/img/pin.png" alt="" style="position: absolute;right: 8px;top: 1px;height: 35px;" />
                      <div class="notice-body">
                        <h2></h2>
                        <?=$notice['notice']?>
                      </div>  
                    </div>


                    <?php $i++; endif; endforeach ?>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>

              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <script>

        $(document).ready(function(){
          $('#notification-status').click(function(){
            var id = $('#notification-status').data('id');
            $.get('?c=work&m=changeNotificatonStatus', {'id': id}, function(result) {
            });
          });
          $('#give_attendance').click(function(){
        //var emp_id = $('#give_attendance').data('empid');
        //console.log('emp_id');
        $.get('?c=employee&m=employee_attendance', {'action': 'give_attendance'}, function(result) {
          if(result){
            location.reload(true);
          }
        });
      });
          $('#leave_office').click(function(){
        //var emp_id = $('#give_attendance').data('empid');
        console.log('emp_id');

        $.get('?c=employee&m=employee_attendance', {'action': 'leave_office'}, function(result) {
         if(result){
          location.reload(true);
        }
      });
        //location.reload(true);
      });
        });

      </script>