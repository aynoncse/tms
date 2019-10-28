<?php include 'views/layouts/header.php'; ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Employee</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Employee List</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                            <?php $this->notificationShow(); ?>

                    <div class="box-body" style="">
                        <div class="box" style="border-top: none;">

                            <div class="table-responsive">

                                <table id="data-table" class="table table-bordered table-striped" style="width: 100%">
                                    <thead class="data-table-head">
                                        <tr class="data-table-head-row">
                                            <th>Joining Date</th>
                                            <th>EMP ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Address</th>
                                            <th>Level</th>
                                            <th >Image</th>
                                            <th class="col-md-2 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employee_list as $emp) {
                                            $id = $emp['id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $this->date($emp['emp_joining_date'], 'd M Y'); ?></td>
                                                <td><a href="#"><?php echo $emp['emp_id'] ?></a></td>
                                                <td ><a href="#"><?php echo $emp['emp_name'] ?></a></td>
                                                <td><?php echo $emp['emp_mobile_no'] ?></td>
                                                <td><?= $this->empDesignation($emp['emp_designation']);?></td>
                                                <td><?php echo $emp['emp_address'] ?></td>
                                                <td><?php echo $this->empLevel($emp['emp_level']);?></td>
                                                
                                                <td><img src="assets/images/employee_img/<?php
                                                    if (isset($emp['emp_img']) && !empty($emp['emp_img'])) {
                                                        echo $emp['emp_img'];
                                                    } else {
                                                        echo 'avatar.png';
                                                    }
                                                    ?>" style="height: 75px;width: 75px; border-radius: 45px; background: #0e9e0f; padding: 2px;box-shadow: 0px 6px 13px -7px #000;" /></td>
                                                <td align="center">
                                                    <a href="<?php $this->url('employee', 'update_employee_details_view', "&id=$id");
                                                    ?>"><button type="button" class="btn bg-primary btn-flat "><i class="fa fa-edit"></i></button></a>
                                                   
                                                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php
                                                    $id = $emp['id'];
                                                    $this->url('employee', 'delete_employee', "&id=$id");
                                                    ?>"><button type="button" class="btn bg-maroon btn-flat "><i class="fa fa-trash"></i></button></a>
                                                  
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script>
     $(document).ready(function () {
        $('#vw_employee').addClass('active');
        $('#view_emp_list').addClass('active');

        var table = $('#data-table').DataTable( {
            responsive: true
        } );

    } );
</script>
<?php include 'views/layouts/footer.php'; ?>