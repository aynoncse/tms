<?php include 'views/layouts/header.php'; ?>

<div class="content-wrapper">
    <?php $this->notificationShow() ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">All Users</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="datatable">
                                <thead>
                                    <tr class="bg-default">
                                        <th style="width: 20px;">#</th>
                                        <th style="text-align: center;">Full Name</th>
                                        <th style="text-align: center;">User Name</th>
                                        <th style="text-align: center;">Email Address</th>
                                        <th style="text-align: center;">Mobile No</th>
                                        <th style="text-align: center;">User Type</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Details</th>
                                        <?php if ($this->user_ty == 'SA') { ?>
                                            <th style="text-align: center;">Edit</th>
                                            <th style="text-align: center;">Change Pass</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = '0';
                                    foreach ($all_users as $value) {
                                        $empData= $this->empData($value['emp_id']);
                                        extract($value);
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo !empty($empData['emp_name']) ? $empData['emp_name'] : '<a href="?c=user&m=view_user_details&id='.$value['user_id'].'">'.$value['emp_name'].'</a>'; ?></td>
                                            <td><?php echo isset($value['user_name']) ? $value['user_name'] : NULL; ?></td>
                                            <td><?php echo !empty($empData['emp_email']) ? $empData['emp_email'] : NULL; ?></td>
                                            <td><?php echo !empty($empData['emp_mobile_no']) ? $empData['emp_mobile_no'] : NULL; ?></td>

                                            <td>
                                                <?php
                                                $this->user_type($value['user_type']);
                                                ?>
                                            </td>

                                            <td style="text-align: center;">
                                                <?php
                                                if ((isset($value['status']) ? $value['status'] : NULL) == '1') { ?>
                                                    <a href="?c=user&m=change_user_status&intoken=<?php echo isset($value['user_id']) ? $value['user_id'] : NULL; ?>"><span class="glyphicon glyphicon-ok"></span></a>
                                                <?php } else { ?>
                                                    <a href="?c=user&m=change_user_status&actoken=<?php echo isset($value['user_id']) ? $value['user_id'] : NULL; ?>"><span class="glyphicon glyphicon-remove btn-danger"></span></a>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align: center;"><a href="<?php $this->url('user','view_user_details','&id='.$value['user_id'])?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                            <?php if ($this->user_ty == 'SA') { ?>
                                                <td style="text-align: center;"><a href="?c=user&m=edit_user&id=<?php echo isset($value['user_id']) ? $value['user_id'] : NULL; ?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                                <td style="text-align: center;"><a href="<?php $this->url('user','user_change_password','&id='.$value['user_id']) ?>">Change</a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#view_user').addClass('active');
        $('#vw_user').addClass('active');
        
    });
</script>
<?php include 'views/layouts/footer.php'; ?>
