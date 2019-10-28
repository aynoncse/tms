<?php
include 'views/layouts/header.php'; 

if (isset($_POST['submit'])) {
    $this->update_employee_details($_POST, $_FILES);
}
?>
<div class="content-wrapper">

    <section class="content">
        <?php $this->notificationShow(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>                        
                    </div>
                    <div class="box-body" style="">
                        <div class="row">

                            <form action="" method="POST" enctype="multipart/form-data">

                                <input type="hidden" name="id" value='<?php echo $get_single_employee['id']; ?>'>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Joining Date :</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="emp_joining_date" class="form-control pull-right" id="datepicker" type="text" autocomplete="off" value="<?php echo $get_single_employee['emp_joining_date']; ?>" >
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>Employee Name :</label>
                                        <input name="emp_name" class="form-control" value="<?php echo $get_single_employee['emp_name']; ?>" type="text" >
                                    </div>
                                    <div class="form-group">
                                        <label>Father's Name :</label>
                                        <input name="emp_father_name" class="form-control" value="<?php echo $get_single_employee['emp_father_name']; ?>" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Mother's Name :</label>
                                        <input name="emp_mother_name" class="form-control" value="<?php echo $get_single_employee['emp_mother_name']; ?>" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Address :</label>
                                        <textarea class="form-control" name="emp_address" rows="5"><?php echo $get_single_employee['emp_address']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile No. :</label>
                                        <input name="emp_mobile_no" class="form-control" value="<?php echo $get_single_employee['emp_mobile_no']; ?>" type="text"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input name="emp_email" class="form-control" value="<?php echo $get_single_employee['emp_email']; ?>" type="email"  >
                                    </div>
                                    <div class="form-group">
                                        <label>National Id No. :</label>
                                        <input name="emp_nid" class="form-control" value="<?php echo $get_single_employee['emp_nid']; ?>" type="text">
                                    </div>
                                    


                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Designation :</label>
                                        <select name="emp_designation" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="1" <?php echo $get_single_employee['emp_designation']==1?'selected':'' ?>>Director & CEO</option>
                                            <option value="2" <?php echo $get_single_employee['emp_designation']==2?'selected':'' ?>>Operations Manager</option>
                                            <option value="3" <?php echo $get_single_employee['emp_designation']==3?'selected':'' ?>>Marketing Manager</option>
                                            <option value="4" <?php echo $get_single_employee['emp_designation']==4?'selected':'' ?>>Marketing Executive</option>
                                            <option value="5" <?php echo $get_single_employee['emp_designation']==5?'selected':'' ?>>Tele-Marketing Executive</option>
                                            <option value="6" <?php echo $get_single_employee['emp_designation']==6?'selected':'' ?>>Digital Marketing Executive</option>
                                            <option value="7" <?php echo $get_single_employee['emp_designation']==7?'selected':'' ?>>Call Manager</option>
                                            <option value="8" <?php echo $get_single_employee['emp_designation']==8?'selected':'' ?>>Call Executive</option>
                                            <option value="9" <?php echo $get_single_employee['emp_designation']==9?'selected':'' ?>>Programmer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Employee Level:</label>
                                        <select name="emp_level" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="1" <?php echo $get_single_employee['emp_level']==1?'selected':'' ?>>Super Admin Level</option>
                                            <option value="2" <?php echo $get_single_employee['emp_level']==2?'selected':'' ?>>Admin Level</option>
                                            <option value="3" <?php echo $get_single_employee['emp_level']==3?'selected':'' ?>>Executive Level</option>
                                        </select>
                                    </div>

                                    <label>Employee Image:</label><br/>
                                    <label for=""><img src="assets/images/employee_img/<?php echo $get_single_employee['emp_img'];?>" style="height: 180px;width: 180px; border-radius: 5px; padding: 5px;box-shadow: 0px 6px 13px -7px #000; background: linear-gradient(90deg, rgb(101, 168, 58) 0%, rgb(195, 83, 12) 51%, rgb(55, 180, 8) 100%); margin-bottom: 10px" /> </label>
                                    <div class="form-group">
                                        <input id="exampleInputFile" type="file" name="file">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <button type="submit" class="btn btn-block btn-primary" name="submit">Update Employee</button>
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
        $('#vw_employee').addClass('active');
        
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
<?php include 'views/layouts/footer.php'; ?>