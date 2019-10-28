<?php

class Dashboard extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function home() {
        $this->login_redirect();
        if ($this->user_ty == 1) {
            $this->dashboard();
        } else {
            $this->empDashboard();
        }        
    }

    public function updateEmpNote(){
        $this->login_redirect();
        $note = isset($_GET['note'])?$_GET['note']:'';
        if ($note != '') {
            $note_data = array('note' => $note);
            $getNote = $this->db->details_by_cond('tbl_emp_note','emp_id="'.$_SESSION['emp_id'].'"');

            if($getNote){
                $update_data = $this->db->Update_data('tbl_emp_note', $note_data,'id='.$getNote['id']);
            }else{
                $note_data = array('emp_id' => $_SESSION['emp_id'],'note' => $note);
                $insert_data = $this->db->Insert_data('tbl_emp_note', $note_data);
            }
        }
    }

    public function getEmpNote(){
        $getNote = $this->db->details_by_cond('tbl_emp_note','emp_id="'.$_SESSION['emp_id'].'"');
        echo $getNote['note'];
    }

    public function empDashboard() {
       
        $on_projects    = $this->db->view_all_by_cond('vw_project_details','status = 1 AND emp_id="'.$this->user_empId.'"');

        $projects_accomplished = $this->db->view_all_by_cond('tbl_projects', 'status=0 AND emp_id="'.$this->user_empId.'"');

        $comp_projects         = $this->db->view_all_by_cond('tbl_projects', 'completion_percent=100 AND emp_id="'.$this->user_empId.'"');

        $on_works       = $this->db->view_all_by_cond('tbl_single_works', 'status=1 AND emp_id="'.$this->user_empId.'"');

        $today_deadline_works  = $this->db->view_all_by_cond('tbl_single_works', 'status=1 AND end_date="'.date('Y-m-d').'" AND emp_id="'.$this->user_empId.'"');

        $today_deadline_projects  = $this->db->view_all_by_cond('tbl_projects', 'status=1 AND end_date="'.date('Y-m-d').'" AND emp_id="'.$this->user_empId.'"');


        $on_works_all             = $this->db->raw_sql('tbl_works.emp_id, tbl_works.id AS work_id, tbl_works.project_id AS project_id, tbl_projects.project_name AS project_name, tbl_projects.completion_percent AS project_completion, tbl_projects.end_date AS submit_date, tbl_works.sw_id AS sw_id, tbl_single_works.end_date AS sw_submit_date, tbl_single_works.completion_percent AS sw_completion, tbl_single_works.work_title AS work_title FROM tbl_works LEFT JOIN tbl_projects ON tbl_works.project_id = tbl_projects.id LEFT JOIN tbl_single_works ON tbl_single_works.sw_id = tbl_works.sw_id WHERE tbl_works.status = 1 AND tbl_works.emp_id="'.$this->user_empId.'"');

        include $this->view . 'empdashboard.php';
    }


    public function dashboard() {
        $on_projects           = $this->db->view_all_by_cond('tbl_projects', 'status=1');
        $comp_projects         = $this->db->view_all_by_cond('tbl_projects', 'status=0');
        $employee              = $this->db->view_all_by_cond('tbl_employee', 'emp_status=1 AND emp_designation !=1');
        $programmers           = $this->db->view_all_by_cond('tbl_employee', 'emp_status=1 AND emp_designation = 9');
        $not_programmers       = $this->db->view_all_by_cond('tbl_employee', 'emp_status=1 AND emp_designation != 9 AND emp_designation !=1');

        $today_deadline_works  = $this->db->view_all_by_cond('tbl_single_works', 'status=1 AND end_date="'.date('Y-m-d').'"');

        $on_works              = $this->db->raw_sql('tbl_works.emp_id, tbl_works.id AS work_id, tbl_works.project_id AS project_id, tbl_projects.project_name AS project_name, tbl_projects.completion_percent AS project_completion, tbl_projects.end_date AS submit_date, tbl_single_works.end_date AS sw_submit_date, tbl_single_works.completion_percent AS sw_completion, tbl_single_works.work_title AS work_title FROM tbl_works LEFT JOIN tbl_projects ON tbl_works.project_id = tbl_projects.id LEFT JOIN tbl_single_works ON tbl_single_works.sw_id = tbl_works.sw_id WHERE tbl_works.status = 1');
        include $this->view . 'dashboard.php';
    }



    public function getTasksInHand($emp_id){
        $task_in_hand = $this->db->view_all_by_cond('tbl_works','sw_id !=0 AND status=1 AND completion_percent<100 AND emp_id="'.$emp_id.'"');
        return $task_in_hand;
    }

    public function getTasksCompleted($emp_id){
        $task_in_hand = $this->db->view_all_by_cond('tbl_works','sw_id !=0 AND status=1 AND completion_percent=100 AND emp_id="'.$emp_id.'" AND end_date = submitted_time="'.date('Y-m-d h:i:s a').'"');
        return $task_in_hand;
    }

    public function getTasksOverdue($emp_id){
        $task_in_hand = $this->db->raw_sql('tbl_single_works.end_date,tbl_works.* FROM tbl_works LEFT JOIN tbl_single_works ON tbl_works.sw_id = tbl_single_works.sw_id WHERE tbl_works.sw_id !=0 AND tbl_works.status = 1 AND tbl_works.emp_id="'.$emp_id.'" AND tbl_single_works.end_date<"'.date('Y-m-d').'"');
        return $task_in_hand;
    }

    public function getProjectsOverdue($emp_id){
        $task_in_hand = $this->db->raw_sql('tbl_projects.end_date,tbl_works.* FROM tbl_works LEFT JOIN tbl_projects ON tbl_works.project_id = tbl_projects.id WHERE tbl_works.sw_id =0 AND tbl_works.status = 1 AND tbl_works.emp_id="'.$emp_id.'" AND tbl_projects.end_date<"'.date('Y-m-d').'"');
        return $task_in_hand;
    }

    public function getProjectsCompleted($emp_id){
        $task_in_hand = $this->db->view_all_by_cond('tbl_works','sw_id=0 AND status=1 AND completion_percent=100 AND emp_id="'.$emp_id.'" AND end_date = submitted_time="'.date('Y-m-d h:i:s a').'"');
        return $task_in_hand;
    }

    public function getProjectsInHand($emp_id){
        $task_in_hand = $this->db->view_all_by_cond('tbl_works','sw_id =0 AND status=1 AND completion_percent<100 AND emp_id="'.$emp_id.'"');
        return $task_in_hand;
    }
}
