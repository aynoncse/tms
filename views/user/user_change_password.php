<?php include 'views/layouts/header.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change User Password</h3>
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
                                    <div class="col-md-6 col-md-offset-3">
                                        <?php $this->notificationShow(); ?>
                                        <h4>Change Password User <?= $user['FullName'];?></h4>
                                        <form role="form" enctype="multipart/form-data" method="post">

                                            <div class="form-group">
                                                <label>New Password</label>
                                                <div style="padding-bottom: 15px;">
                                                    <input type="text" name="new_password" placeholder="" class="form-control" required="">
                                                </div>
                                            </div>
                                            <!--<div class="form-group">
                                                <label>New Password</label>
                                                <div style="padding-bottom: 15px;">
                                                    <input type="text" name="new_password" placeholder="" class="form-control" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>New Password Retype</label>
                                                <div style="padding-bottom: 15px;">
                                                    <input type="text" name="new_password_retype" placeholder="" class="form-control" required="" >
                                                </div>
                                            </div>-->

                                            <input type="hidden" name="user_id" value="<?= $_GET['id'];?>">

                                            <div class="row" style="text-align: center; padding: 5px 0px 15px 25px; font-size: 12px;">
                                                <button type="submit" class="btn btn-primary text-center" name="submit">Change Password</button>
                                            </div>
                                        </form>
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

    $('select[name="type"').on('change', function() { // banking section will show when click bank

        if (this.value == '2') {
            $('#due input[name="due_to_company"]').attr('required', 'required');
            $('#due').show();
        } else {
            $('#due input[name="due_to_company"]').removeAttr('required');
            $('#due').hide();
        }
    });

    var unit_price = 0;
    var quantity = 0;
    $('input[name="price"]').on('keyup', function () {
        unit_price = $(this).val();
        var total_price = unit_price * quantity;
        $('input[name="total_price"]').val(total_price);
    });

    $('input[name="total_qty"]').on('keyup', function () {
        quantity = $(this).val();
        var total_price = unit_price * quantity;
        $('input[name="total_price"]').val(total_price);
    });

    $('select[name="payment_method"').on('change', function () { // banking section will show when click bank

        if (this.value == 'bank') {
            $('#bank_info select[name="account_no"]').removeAttr('disabled');
            $('#bank_info input[name="diposited_by"]').removeAttr('disabled');
            $('#bank_info').show();
        } else {
            $('#bank_info select[name="account_no"]').attr('disabled', 'disabled');
            $('#bank_info input[name="diposited_by"]').attr('disabled', 'disabled');
            $('#bank_info').hide();
        }
    });
</script>

<?php include 'views/layouts/footer.php'; ?>
