<?php include 'views/layouts/header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Employee Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="">
                        <div class="row">
                            <?php $this->notificationShow(); ?>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="emp_joining_date" class="form-control pull-right" id="datepicker" type="text" autocomplete="off" placeholder="Joining Date (Required)" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_name" class="form-control" placeholder="Enter name (Required)" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_father_name" class="form-control" placeholder="Enter father's name" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_mother_name" class="form-control" placeholder="Enter mother's name" type="text">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="emp_address" rows="5" placeholder="Enter Full Address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_mobile_no" class="form-control" placeholder="Enter mobile no (Required)" type="text" required >
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_email" class="form-control" placeholder="Enter email address (Required)" type="text" required >
                                    </div>
                                    <div class="form-group">
                                        <input name="emp_nid" class="form-control" placeholder="Enter national id" type="text">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Upload Image: </label>
                                            <div class="form-group">
                                                <input id="exampleInputFile" type="file" name="file">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select name="emp_designation" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required">
                                            <option disabled selected hidden>Designation (Required)</option>
                                            <option value="1">Director & CEO</option>
                                            <option value="2">Operations Manager</option>
                                            <option value="3">Marketing Manager</option>
                                            <option value="4">Marketing Executive</option>
                                            <option value="5">Tele-Marketing Executive</option>
                                            <option value="6">Digital Marketing Executive</option>
                                            <option value="7">Call Manager</option>
                                            <option value="8">Call Executive</option>
                                            <option value="9">Programmer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="emp_level" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required">
                                            <option disabled selected hidden>Employee Level (Required)</option>
                                            <option value="1">Super Admin Level</option>
                                            <option value="2">Admin Level</option>
                                            <option value="3">Executive Level</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <button type="submit" class="btn btn-block btn-primary" name="submit">Add Employee</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>

    $(document).ready(function () {
        $('#add_employee').addClass('active');
        $('#vw_employee').addClass('active');
        
    });
</script>
<?php include 'views/layouts/footer.php'; ?>