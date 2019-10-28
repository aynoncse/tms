<?php include 'views/layouts/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
   
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit User</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="">
                        <div class="row">
                            <form action="" method="POST" id="user_create" enctype="multipart/form-data">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">User Level</label>
                                        <select name="user_type" class="form-control" style="margin-bottom: 5px;" required>
                                            <option value="">Select Level</option>
                                            <?php if ($user['UserType']=='1'){?>
                                                <option value="1" selected>User Level</option>
                                                <option value="2">Employee Level</option>
                                                <option value="SA">Admin Level</option>
                                                <option value="4">Accounts Level</option>
                                                <option value="5">Special Level</option>
                                            <?php } elseif ($user['UserType']=='2'){?>
                                                <option value="1">User Level</option>
                                                <option value="2" selected>Employee Level</option>
                                                <option value="SA">Admin Level</option>
                                                <option value="4">Accounts Level</option>
                                                <option value="5">Special Level</option>
                                            <?php } elseif ($user['UserType']=='SA'){?>
                                                <option value="1">User Level</option>
                                                <option value="2">Employee Level</option>
                                                <option value="SA" selected>Admin Level</option>
                                                <option value="4">Accounts Level</option>
                                                <option value="5">Special Level</option>
                                            <?php } elseif ($user['UserType']=='4'){?>
                                                <option value="1">User Level</option>
                                                <option value="2">Employee Level</option>
                                                <option value="SA">Admin Level</option>
                                                <option value="4" selected>Accounts Level</option>
                                                <option value="5">Special Level</option>
                                            <?php } elseif ($user['UserType']=='5'){?>
                                                <option value="1">User Level</option>
                                                <option value="2">Employee Level</option>
                                                <option value="SA">Admin Level</option>
                                                <option value="4">Accounts Level</option>
                                                <option value="5" selected>Special Level</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Employee Id</label>
                                        <select name="employee_id" class="form-control" style="margin-bottom: 5px;" disabled>
                                            <option value="">Select Employee</option>
                                            <?php foreach ($employees as $employee) { ?>
                                                <option value="<?= $employee['id'] ?>" <?php if ($employee['id']==$user['employee_pid']){echo 'selected';}?>><?= $employee['employee_id'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php if (!empty($user['FullName'])){?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Name</label>
                                        <input type="text" disabled="" name="employee_name" class="form-control" placeholder="Employee Name" value="<?= $user['FullName']?>" required>
                                    </div>
                                    <?php } ?>

                                    <?php if (!empty($user['UserId'])){?>
                                        <input type="hidden" name="user_id" class="form-control" value="<?= $user['UserId']?>" required>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">User Name</label>
                                        <input type="text" name="user_name" class="form-control" value="<?= $user['UserName']?>" disabled>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <button type="submit" class="btn btn-block btn-primary" name="submit">Edit User</button>
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
        var employee_id = 0;
        $('select[name="employee_id"]').on('change', function() {
            employee_id = $(this).val();
             //console.log(employee_id);
            $.get('?c=user&m=ajax_get_employee_name', {'id': employee_id}, function(result) {
                  console.log(result.employee_name);
                

                $('input[name="employee_name"]').val(result.employee_name);
            }, 'json');


        });
    }
    );
    $(document).ready(function() {
       $('input[name="password"]').on('change', function() { 
           var pass = $(this).val();
           console.log(pass);
           $('input[name="re_type_password"]').on('change', function() { 
           var pass2 = $(this).val();
           console.log(pass2);
           if(pass != pass2){
               alert('Error ! password does not match');
           }
        });
        });
    }
    );
</script>
<script>
    $(document).ready(function() {
        $('#vw_user').addClass('active');
        
        $('form#user_create').on('change', 'input#select_all_menu_permission', function(event) {

            var checked = $(this).prop('checked');

            $('form#user_create').find('input[name="menu_permission[]"]').prop('checked', checked);

        })
    });
</script>

<?php include 'views/layouts/footer.php'; ?>

