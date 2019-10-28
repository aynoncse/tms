<?php include 'views/layouts/header.php'; ?>
<div class="content-wrapper">
    
    <section class="content">
        <?php $this->notificationShow(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Attendance List <?php echo date("d-M-Y", strtotime($startDate)) . " to " . date("d-M-Y", strtotime($endDate)); ?></strong></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" id='dateButton' data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <button type="button" class="btn btn-danger pull-right" id="daterange-btn">
                            <span><i class="fa fa-calendar"></i> Filter </span>
                            <i class="fa fa-caret-down"></i>
                        </button>

                        <div class="attendance_list">
                            <table id="data-table" class="table table-bordered table-dark" style="width: 100%;">
                                <thead class="data-table-head">
                                    <tr class="data-table-head-row">
                                        <th>Date</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Entering Time</th>
                                        <th>Leaving Time</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($current_date_attendance as $atten) {
                                        ?>
                                        <tr>
                                            <td class=""><?= $this->date($atten['t_date'], 'd M Y'); ?></td>
                                            <td class=""><?= $atten['emp_id']; ?></td>
                                            <?php $emp = $this->empData($atten['emp_id'])?>
                                            <td class=""><?= $emp['emp_name'] ?></td>
                                            <td><?= date('h:i:s a', strtotime($atten['entering_time']))?></td>
                                            <td><?= $atten['leaving_time']!=NULL?date('h:i:s a', strtotime($atten['leaving_time'])):''?></td>
                                            <td><?= $this->empDesignation($emp['emp_designation']);?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--/.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('input[name="startDate"]').datepicker({
            autoclose: true,
            toggleActive: true,
            format: 'dd-mm-yyyy'
        });

        $('input[name="endDate"]').datepicker({
            autoclose: true,
            toggleActive: true,
            format: 'dd-mm-yyyy'
        });

        $(document).on('mouseover', 'tbody tr td [data-toggle="tooltip"]', function() {
            $('tbody tr td [data-toggle="tooltip"]').tooltip();
        });

    });

    $(document).ready(function() {
        $('#data-table').DataTable({
            responsive: true,
            ordering: false,
            paging: false,
            info:false,
            dom: 'Bfrtip',
            searching: false,
            buttons: [
            {
                extend: 'print',
                text: 'Print',
                footer: true,
                title: function() {
                    return "Employee Attendence <?php echo date("d-M-Y", strtotime($startDate)) . " to " . date("d-M-Y", strtotime($endDate)); ?>"
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function(win) {
                    $(win.document.body).css('font-size', '12px');
                    $(win.document.body).find('h1').addClass('text-center').css('font-size', '20px');
                    $(win.document.body).find('table').addClass('container').css('font-size', 'inherit');
                    $(win.document.body).find('table').removeClass('table-bordered');
                }
            }
            ]
        });
        $('.buttons-print span').html('<i class="fas fa-print"></i>');
    });
</script>

<script>
    $(document).ready(function () {
        $('#attend_list').addClass('active');
        $('#vw_employee').addClass('active');

    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<script>
 $(document).ready(function () {
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
    {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    var startDate   = start.format('YYYY-MM-DD');
    var endDate     = end.format('YYYY-MM-DD');
    $.get('?c=employee&m=employee_attendance_list_ajax', {startDate: startDate, endDate:endDate,search:'search'}, function(result) {
      $('.attendance_list').html(result);
      //console.log(result);
      $('#data-table').DataTable({
        "destroy": true, //use for reinitialize datatable
        responsive: true,
        autowidth:false,
        ordering: false,
        paging: false,
        info:false,
        dom: 'Bfrtip',
        searching: false,
        buttons: [
        {
            extend: 'print',
            text: 'Print',
            footer: true,
            title: function() {
                return "Employee Attendence <?php echo date("d-M-Y", strtotime($startDate)) . " to " . date("d-M-Y", strtotime($endDate)); ?>"
            },
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            customize: function(win) {
                $(win.document.body).css('font-size', '12px');
                $(win.document.body).find('h1').addClass('text-center').css('font-size', '20px');
                $(win.document.body).find('table').addClass('container').css('font-size', 'inherit');
                $(win.document.body).find('table').removeClass('table-bordered');
            }
        }
        ]
    })
      $('.buttons-print span').html('<i class="fas fa-print"></i>');
  });
}
)

});
</script>
</script>
<?php include 'views/layouts/footer.php'; ?>