<?php

class Employee extends Controller {


/*    if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (isset($_GET['search'])) {
            $dateYear = $_GET['dateYear'];
        } else {
            $dateYear = date('Y');
        }
    }*/

    function __construct() {
        parent::__construct();
        $this->login_redirect();
    }

//    start
    public function add_employee_details() {
        $this->login_redirect();
        $active = 'add_employee_details';

        if(isset($_POST['submit'])){
            $insert = $this->add_employee_details_insert($_POST, $_FILES);
            if ($insert){
                $this->notificationStore('Employee Assigned Successfully', 'success');
                $this->redirectJs('employee', 'add_employee_details');
            } else {
                $this->notificationStore('Employee  Assigned Failed', 'error');
                $this->redirectJs('employee', 'add_employee_details');
            }
        }  else {
            include $this->view . 'employee/add_employee_details.php';
        }

    }

//    end
//    start
    public function add_employee_details_insert($postData, $fileData) {
        $this->login_redirect();

        if (isset($fileData['file']['name']) && !empty($fileData['file']['name'])) {
            $file_name = uniqid() . ($fileData['file']['name']);
            $tmp_name = ($fileData['file']['tmp_name']);
            $destination = "assets/images/employee_img/" . $file_name;
            $upload = move_uploaded_file($tmp_name, $destination);
        } else {
            $file_name = '';
        }
        $data = array(
            'emp_id'          => '0',
            'emp_name'        => $postData['emp_name'],
            'emp_mobile_no'   => $postData['emp_mobile_no'],
            'emp_email'       => $postData['emp_email'],
            'emp_address'     => $postData['emp_address'],
            'emp_nid'         => $postData['emp_nid'],
            'emp_img'         => $file_name,
            'emp_father_name' => $postData['emp_father_name'],
            'emp_mother_name' => $postData['emp_mother_name'],
            'emp_designation' => $postData['emp_designation'],
            'emp_level'       => $postData['emp_level']     ,
            'emp_joining_date'=> date('Y-m-d', strtotime($postData['emp_joining_date'])),
            'emp_status'      => 1,
            'entry_by'        => $this->user_id
        );
        $last_insert_id = $this->db->Insert_data('tbl_employee', $data);

        if (!empty($last_insert_id)) {
            $joining_day = date('d', strtotime($postData['emp_joining_date']));
            $joining_month = date('m', strtotime($postData['emp_joining_date']));
            $joining_year = date('Y', strtotime($postData['emp_joining_date']));
            $employee_id = 'EMP' . $last_insert_id . $joining_day . $joining_month . $joining_year;

            $update_employee_id = $this->db->Update_data('tbl_employee', ['emp_id' => $employee_id], 'id = ' . $last_insert_id);
        }

        return $last_insert_id;
    }

    public function view_employee_list() {
        $this->login_redirect();
        $active = 'view_employee_list';
        $employee_list = $this->db->view_all_by_cond('tbl_employee', 'emp_status = 1');

        include $this->view . 'employee/view_employee_list.php';
    }

    public function update_employee_details_view() {
        $this->login_redirect();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $get_single_employee = $this->db->details_by_cond('tbl_employee', 'id=' . $id);
        $emp_id = $get_single_employee['emp_id'];

        include $this->view . 'employee/update_employee_details.php';
    }

    public function update_employee_details($postData, $fileData) {
        $this->login_redirect();
        $id = $postData['id'];
        $get_single_employee = $this->db->details_by_cond('tbl_employee', 'id=' . $id);

        if (isset($fileData['file']['name']) && !empty($fileData['file']['name'])) {
            $file_name = uniqid() . ($fileData['file']['name']);
            $tmp_name = ($fileData['file']['tmp_name']);
            $destination = "assets/images/employee_img/" . $file_name;
            $upload = move_uploaded_file($tmp_name, $destination);
        } else {

            $file_name = $get_single_employee['emp_img'];
        }
        if (isset($postData['probation_period']) && !empty($postData['probation_period'])) {
            $probation = $postData['probation_period'];
        } else {
            $probation = 0;
        }

        $data = array(
            'emp_name'        => $postData['emp_name'],
            'emp_mobile_no'   => $postData['emp_mobile_no'],
            'emp_email'       => $postData['emp_email'],
            'emp_address'     => $postData['emp_address'],
            'emp_nid'         => $postData['emp_nid'],
            'emp_img'         => $file_name,
            'emp_father_name' => $postData['emp_father_name'],
            'emp_mother_name' => $postData['emp_mother_name'],
            'emp_designation' => $postData['emp_designation'],
            'emp_level'       => $postData['emp_level']     ,
            'emp_joining_date'=> date('Y-m-d', strtotime($postData['emp_joining_date'])),
            'emp_status' => 1,
            'update_by' => $this->user_id,
            'emp_img' => $file_name
        );
        $update_data = $this->db->Update_data('tbl_employee', $data, 'id=' . $id);
        if ($update_data) {
            $this->notificationStore('Employee Updated Successfully', 'success');
            $this->redirectJs('employee','update_employee_details_view','&id='.$postData['id']);
            //echo "<script>location.href = '?c=employee&m=update_employee_details_view&id=".$postData['id']."'</script>";
        }
    }

    public function delete_employee() {
        $this->login_redirect();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $data = array(
            'emp_status' => 0
        );
        $update_data = $this->db->Update_data('tbl_employee', $data, 'id=' . $id);
        if ($update_data) {
            $this->notificationStore('Employee Deleted Successfully', 'success');
            $this->redirectJs('employee', 'view_employee_list');
        }
    }

    public function checkAttendance(){
        $this->login_redirect();
        if (isset($_GET['action']) && $_GET['action']=='check_attendance') {
            $is_attend = $this->db->details_by_cond('tbl_attendance', 'emp_id="'.$this->user_empId.'" AND t_date="'.date('Y-m-d').'"');
            $output='';
            if(!$is_attend){
                $output .= '<button type="button" class="btn btn-flat" title="Give Attendance" style="font-size: 20px;background: rgba(255,0,0,0.2); transform: 1s;position: relative;display: block;padding: 10px 15px;">
                <i class="fas fa-hand-point-up"></i>
                </button>';
            }else{
                if ($is_attend['leaving_time']=='00:00:00'){
                    $output .= '<button type="button" class="btn btn-flat" title="Leaving for Today" style="font-size: 20px;background: rgba(255,0,0,0.2); transform: 1s;position: relative;display: block;padding: 10px 15px;">
                    <i class="fas fa-hand-point-down"></i>
                    </a>';
                }
            }
            echo $output;
        }
    }
    public function employee_attendance() {
        $this->login_redirect();
        if (isset($_GET['action']) && $_GET['action']=='give_attendance') {
            $is_attend = $this->db->details_by_cond('tbl_attendance', 'emp_id="'.$this->user_empId.'" AND t_date="'.date('Y-m-d').'"');
            if(!$is_attend){
                $data = array(
                    'emp_id'        => $this->user_empId,
                    'entering_time' => date("H:i:s"),
                    't_date'        => date("Y-m-d"),
                    'created_at'    => date("Y-m-d H:i:s")
                );
                $result = $this->db->Insert_data('tbl_attendance', $data);
            }
        }
        if (isset($_GET['action']) && $_GET['action']=='leave_office') {
            $result = $this->db->Update_data('tbl_attendance', ['leaving_time' => date("H:i:s")], 'emp_id="'.$this->user_empId.'" AND t_date="'.date('Y-m-d').'"');
        }
        if($result){
            echo 'true';
        }
    }

    public function employee_attendance_list(){
        $this->login_redirect();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $current_date_attendance = $this->db->view_all_by_cond("tbl_attendance", "t_date BETWEEN '$startDate' and '$endDate' ORDER BY `tbl_attendance`.`t_date` ASC");

        include $this->view . 'employee/employee_attendance_list.php';
    }

    public function employee_attendance_list_ajax(){
        $this->login_redirect();
        if (isset($_GET['search'])) {
            $startDate = $_GET['startDate'];
            $endDate   = $_GET['endDate'];  
        }
        $attendance = $this->db->view_all_by_cond("tbl_attendance", "t_date BETWEEN '$startDate' and '$endDate' ORDER BY `tbl_attendance`.`t_date` ASC");

        $output = '<table id="data-table" class="table table-bordered table-striped table-dark" style="width: 100%">
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
                        <tbody>';
        foreach ($attendance as $attn) {
            $this->login_redirect();
            $emp = $this->empData($attn['emp_id']);
            $leaving_time = $attn['leaving_time']!=NULL?date('h:i:s a', strtotime($attn['leaving_time'])):'';
            $output .='<tr>
                        <td class="">'.$this->date($attn['t_date'], 'd M Y').'</td>'.
                        '<td class="">'.$attn['emp_id'].'</td>'.
                        '<td class="">'.$emp['emp_name'].'</td>'.
                        '<td class="">'.date('h:i:s a', strtotime($attn['entering_time'])).'</td>'.
                        '<td class="">'.$leaving_time.'</td>'.
                        '<td class="">'.$this->empDesignation($emp['emp_designation']).'</td></tr>';

        }
        $output.=' </tbody></table>';
        echo $output;
    }
}
