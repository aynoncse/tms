<?php include 'views/layouts/header.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Details of <strong><?php echo !empty($user['emp_name']) ? $user['emp_name']:NULL;?></strong></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="">
                        <div class="box" style="border-top: none;">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="box box-primary" style="border: 1px solid #ddd;">
                                            <div class="box-body box-profile">
                                                <img class="profile-user-img img-responsive img-circle" src="assets/images/employee_img/<?php
                                                if (isset($user['emp_img']) && !empty($user['emp_img'])) {
                                                    echo $user['emp_img'];
                                                } else {
                                                    echo 'avatar.png';
                                                }
                                                ?>" alt="User profile picture">

                                                <h3 class="profile-username text-center"><?php echo !empty($user['emp_name']) ? $user['emp_name']:$user['emp_name'];?></h3>

                                                <p class="text-muted text-center"><?php !empty($user['emp_designation']) ? $this->empDesignation($user['emp_designation']):NULL;?></p>

                                                <ul class="list-group list-group-unbordered">
                                                    <li class="list-group-item">
                                                        <b>User ID</b> <a class="pull-right laser-id"><?php echo !empty($user['user_id']) ? $user['user_id']:'';?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Mobile No</b> <a class="pull-right laser-id"><?php echo !empty($user['emp_mobile_no']) ? $user['emp_mobile_no']:NULL;?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Employee ID</td>
                                                        <td class="col-sm-12"><a href="<?php $this->url('employee','emp_laser','&id='.$user['id']); ?>"><?php echo $user['emp_id'];?></a> </td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Full Name</td>
                                                        <td class="col-sm-12"><?php echo !empty($user['emp_name']) ? $user['emp_name']:NULL;?></td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Address</td>
                                                        <td class="col-sm-12"><?php echo !empty($user['emp_address']) ? $user['emp_address']:NULL;?></td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">National ID</td>
                                                        <td class="col-sm-12"><?php echo !empty($user['emp_nid']) ? $user['emp_nid']:NULL;?></td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Email</td>
                                                        <td class="col-sm-12"><?php echo !empty($user['emp_email'])? $user['emp_email']:NULL;?></td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Status</td>
                                                        <td class="col-sm-12"><?php if ($user['status']==1){echo 'Active';}else{echo 'Disabled';}  ?></td>
                                                    </tr>
                                                    <tr class="employe_laser_table">
                                                        <td class="col-sm-3 laser-title">Entry Date</td>
                                                        <td class="col-sm-12"><?php echo date('M d Y', strtotime($user['entry_date'])) ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div> 

                </div>
            </div>
        </div>


    </section>
</div>
<script>
     $(document).ready(function() {
        $('#vw_user').addClass('active');
    });
</script>
<?php include 'views/layouts/footer.php'; ?>
