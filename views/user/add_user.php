<?php include 'views/layouts/header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create New User</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <?php $this->notificationShow() ?>
                    <div class="box-body" style="">
                        <div class="row">
                            <form action="" method="POST" id="user_create" enctype="multipart/form-data">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <label for="">User Level</label>
                                        <select name="user_type" class="form-control" style="margin-bottom: 5px;" required>
                                            <option value="">Select Level</option>
                                            <option value="1">Super Admin Level</option>
                                            <option value="2">Admin Level</option>
                                            <option value="3">Employee Level</option>
                                        </select>
                                    </div>
                                    <div class="form-group">

                                        <label for="">Employee Id</label>

                                        <select name="emp_id" class="form-control" style="margin-bottom: 5px;" required>
                                            <option value="">Select Employee</option>
                                            <?php foreach ($employees as $employee) { ?>
                                                <option value="<?= $employee['emp_id'] ?>"><?= $employee['emp_id'] ?> - <?= $employee['emp_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">User Name</label>
                                        <input type="text" name="user_name" class="form-control" placeholder="User Name" required autocomplete="off">
                                        <div id="checkavailablityUserName" class="text-center"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="**********" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Re-type Password</label>
                                        <input type="password" name="re_type_password" class="form-control" id="exampleInputPassword1" placeholder="**********" required>
                                        <div id="match_pass" class="text-center"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <button type="submit" class="btn btn-block btn-primary" name="submit">Add User</button>
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
    $(document).ready(function() {
        var qtyErrorFlag = true;
        var noticeErrorFlag = true;
        var emptyFieldCount = 0;

        $('input[name="user_name"]').on('keyup', function () {
            var userName = $(this).val();

            console.log(userName);
            if (userName != '') {
                $.get('?c=user&m=ajax_get_user_name', {'user_name': userName}, function(result) {
                    console.log(result);
                    if(result){
                        $('#checkavailablityUserName').html('<p class="bg-danger text-red" style="padding: 5px; border-radius: 5px;margin: 2px 0;"><span  class="glyphicon glyphicon-remove text-danger"></span> Sorry this User Name is already exists. </p>');
                        qtyErrorFlag = false;
                    }else{
                        qtyErrorFlag = true;
                    }

                }, 'json');
            } else {
                $('#checkavailablityUserName').html('');
            }
        });

        $('#user_create').addClass('active');
        $('#vw_user').addClass('active');

        $('form').submit(function (submitEvent) {
            if (qtyErrorFlag == false) {
                submitEvent.preventDefault();
                alert('There is a Error in the Table. Plesae resolve first');
            }
        });

        $('input[name="password"]').on('change', function() { 
         var pass = $(this).val();
         console.log(pass);
         $('input[name="re_type_password"]').on('change', function() { 
             var pass2 = $(this).val();
             if(pass != pass2){
                 alert('Error ! password does not match');
             }
         });
     });

    });
</script>

<?php include 'views/layouts/footer.php'; ?>
