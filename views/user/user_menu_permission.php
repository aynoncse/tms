<?php include 'views/layouts/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Menu Permission</h3>
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
                                        <label for="exampleInputEmail1">User Level</label>
                                        <select name="user_type" class="form-control" style="margin-bottom: 5px;" required>
                                            <option value="">Select Level</option>
                                            <option value="1">User Level</option>
                                            <option value="2">Employee Level</option>
                                            <option value="4">Accounts Level</option>
                                            <option value="5">Special Level</option>

                                        </select>
                                    </div>



                                    <div class="form-group" id="work_permission" style="display: none">
                                        <label for="exampleInputEmail1">Permission</label>

                                        <div class="form-group" style="border: 1px solid #CCCCCC; padding: 5px; border-radius:4px;">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="WorkPermission[]" class="wclschekbox" id="inlineCheckbox1" value="add"> Add
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="WorkPermission[]" class="wclschekbox" id="inlineCheckbox2" value="view"> View
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="WorkPermission[]" class="wclschekbox" value="edit" > Edit
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="WorkPermission[]" class="wclschekbox"  value="delete" > Delete
                                            </label>
                                            <input type="hidden" name="workaccess" id="workaccess"/>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-10 col-md-offset-1" id="menu_permission" style="display: none;">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Menu Permission</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="btn-primary btn-xs pointer">
                                                <input type="checkbox" id="select_all_menu_permission"><b> Select All</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr style="margin: 0px;">
                                    <h4 class="bg-success">Users</h4>
                                    <hr style="margin: 0px;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="menu_permission[]" value="usercreate">Add User</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="menu_permission[]" value="view_user">View All User</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="menu_permission[]" value="menu_permission">Menu Permission</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="margin: 0px 0px 5px;">
                                </div>

                                <input type="hidden" name="menu_permission[]" value="">
                                <input type="hidden" name="WorkPermission[]" value="">

                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5">
                                        <button type="submit" class="btn btn-block btn-primary" name="submit">Change Permission</button>
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
        var employee_id = 0;
        $('select[name="employee_id"]').on('change', function () {
            employee_id = $(this).val();
            //console.log(employee_id);
            $.get('?c=user&m=ajax_get_employee_name', {'id': employee_id}, function (result) {
                console.log(result.employee_name);


                $('input[name="employee_name"]').val(result.employee_name);
            }, 'json');


        });
    }
    );
    $(document).ready(function () {
        $('input[name="password"]').on('change', function () {
            var pass = $(this).val();
            console.log(pass);
            $('input[name="re_type_password"]').on('change', function () {
                var pass2 = $(this).val();
                console.log(pass2);
                if (pass != pass2) {
                    alert('Error ! password does not match');
                }
            });
        });
    }
    );
</script>
<script>
    $(document).ready(function () {
        $('#menu_per').addClass('active');
        $('#vw_user').addClass('active');
        $('form#user_create').on('change', 'input#select_all_menu_permission', function (event) {

            var checked = $(this).prop('checked');

            $('form#user_create').find('input[name="menu_permission[]"]').prop('checked', checked);

        })
    });

    $('select[name="user_type"]').on('change', function () {
        var user_type = $(this).val();
        $('input').prop('checked', false);
        $('#menu_permission').show();
        $('#work_permission').show();
        $.get('?c=user&m=ajax_menu_permission', {'user_type':user_type,},function (result) {

            $.each(result.menu_permission, function (kay, val) {
                $('input[value="'+val+'"]').prop('checked', true);
            });

            $.each(result.work_permission, function (kay, val) {
                $('input[value="'+val+'"]').prop('checked', true);
            });

        },'json');

    });
</script>

<?php include 'views/layouts/footer.php'; ?>
