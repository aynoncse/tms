<style>
 ul li ul .active {
  background: #076816;
  margin-left: -5px;
  padding-left: 5px;
}
</style>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php if (empty($this->user_img)){?>assets/img/avatar.png<?php } else { echo 'assets/images/employee_img/'. $this->user_img;} ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?= $this->user_fullName ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">Menu</li>
      <li id='vw_dashboard'>
        <a href="<?php $this->url('dashboard','home'); ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>

        </a>
      </li>

      <li class="treeview " id="vw_user">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="user_create">
            <?php $this->printSidebarElement($this->user_ty,'usercreate','?c=user&m=add_user','Create New User','text-red');?>
          </li>
          <li id="view_user">
            <?php $this->printSidebarElement($this->user_ty,'view_user','?c=user&m=view_all_users','All Users', 'text-yellow');?>
          </li>

        </ul>
      </li>

      <li id="vw_employee" class="treeview">
        <a href="#">
          <i class="fas fa-user-friends"></i>
          <span> &nbsp; Employee</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="add_employee"><?php $this->printSidebarElement($this->user_ty,'add_new_employee','?c=employee&m=add_employee_details','Add New Employee', 'text-red');?></li>
          <li id="view_emp_list">
            <?php $this->printSidebarElement($this->user_ty,'employee_list','?c=employee&m=view_employee_list','Employee List', 'text-green');?>
          </li>

          <li id="attend_list"><?php $this->printSidebarElement($this->user_ty,'employee_attendance_list','?c=employee&m=employee_attendance_list','Employee Attendance List', 'text-aqua');?></li>
        </ul>
      </li>


      <li class="treeview" id="vw_assign_work">
        <a href="#">
          <i class="fas fa-tasks"></i> <span> &nbsp; Manage Works</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" >
          <li id="target_work"><?php $this->printSidebarElement($this->user_ty,'set_target_work','?c=work&m=set_target_work','Set Target Work', 'text-maroon');?>
        </li>
        <li id="target_work_list"><?php $this->printSidebarElement($this->user_ty,'target_work_list','?c=work&m=target_work_list','List of Target Works', 'text-purple');?>
      </li>
      <li id="assign_work"><?php $this->printSidebarElement($this->user_ty,'assign_work','?c=work&m=assign_work','Assign Work', 'text-aqua');?>
    </li>

    <li id="work_list"><?php $this->printSidebarElement($this->user_ty,'view_work_list','?c=work&m=work_list','List of Works', 'text-red');?></li>

    <li id="recommended_works"><?php $this->printSidebarElement($this->user_ty,'recommended_works','?c=work&m=recommended_works','Recommended Works', 'text-yellow');?></li>

    <?php if ($this->user_ty==1): ?>
      <li id="view_daily_reporting"><?php $this->printSidebarElement($this->user_ty,'view_daily_reporting','?c=work&m=view_daily_reporting','View Daily Reporting', 'text-green');?>
    </li>
  <?php endif ?>
</ul>
</li>
<?php if ($this->user_ty==1): ?>
  <li class="treeview" id="vw_notice">
    <a href="#">
      <i class="fas fa-exclamation-triangle text-danger"></i> <span> &nbsp; Notice</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu" >
      <li id="send_notice"><?php $this->printSidebarElement($this->user_ty,'send_notice','?c=notice&m=send_notice','Send Notice', 'text-maroon');?>
    </li>
    <li id="see_notices"><?php $this->printSidebarElement($this->user_ty,'see_notice','?c=notice&m=see_notices','See Notices', 'text-purple');?>
  </li>
</ul>
</li>
<?php endif ?>

</ul>
</section>
<!-- /.sidebar -->
</aside>