<?php
include 'Database.php';
class Controller
{
    public $db;
    public $user_id='';
    public $user_img='';
    public $user_empId='';
    public $user_joinDate='';
    public $user_fullName='';
    public $user_userName='';
    public $user_designation='';
    public $user_ty='';
    public $menu='';
    public $acc_type;
    public $view = 'views/';
    public $empData = array();
    public $timezone= 'Asia/Dhaka';
    function __construct()
    {
        session_start();
        date_default_timezone_set($this->timezone);
        $this->db = new Database();
    }

    public function date($date='',$format='Y-m-d h:i:s'){
        $date = new DateTime($date,  new DateTimezone($this->timezone));
        return $date->format($format);
    }

    public function textShorten($text, $limit = 400){
      $text = $text. " ";
      $text = substr($text, 0, $limit);
      $text = substr($text, 0, strrpos($text, ' '));
      $text = $text.".....";
      return $text;
  }

  public function formatDate($date){
    return date('F j, Y, g:i a', strtotime($date));
}

public function diffDate($start_date, $end_date){
    $start_date = strtotime($start_date);
    $end_date = strtotime($end_date);
    $diff = ($end_date - $start_date)/60/60/24;
    return $diff;
}

public function printSidebarElement($user_type, $permissionUrl,  $getUrl, $menuName, $color, $icon = "fa fa-circle-o")
{
    echo '<a href="' . $getUrl . '"><i class="'.$icon.' '.$color.' "></i>' . $menuName . '</a>';
}

public function redirect($c, $m, $path=''){
    header("location:?c=$c&m=$m$path");
}

public function redirectJs($c, $m, $path=''){
    echo "<script>location.href = '?c=$c&m=$m$path'</script>";
}

public function url($c, $m, $path=''){
    echo "?c=$c&m=$m$path";
}

public function empIsPresent($emp_id){
    $present_employee      = $this->db->details_by_cond('tbl_attendance', 'emp_id ="'.$emp_id.'" AND t_date="'.date("Y-m-d").'"');
    return $present_employee;
}
public function empCurrentWorks($emp_id){

    $current_works = $this->db->raw_sql("tbl_works.id AS w_id, tbl_works.emp_id AS emp_id, tbl_projects.project_name AS project_name, tbl_projects.completion_percent AS p_completion, tbl_projects.start_date AS p_start_date, tbl_projects.end_date AS p_end_date, tbl_single_works.work_title AS work_title, tbl_single_works.count AS w_count, tbl_single_works.completion_percent AS sw_completion, tbl_single_works.start_date AS sw_start_date, tbl_single_works.end_date AS sw_end_date FROM tbl_works LEFT JOIN tbl_projects ON tbl_works.project_id = tbl_projects.id LEFT JOIN tbl_single_works ON tbl_single_works.sw_id = tbl_works.sw_id WHERE tbl_works.status = 1 AND tbl_works.emp_id='".$emp_id."'");
    return $current_works;
}

public function setFlashData($key, $value)
{
    $_SESSION[$key] = $value;
}

public function flashData($data)
{
    if (isset($_SESSION["$data"]) && !empty($_SESSION["$data"])) {
        echo $_SESSION["$data"];
        unset($_SESSION["$data"]);
    }
}

public function notificationStore($text, $alert = 'info'){
        $_SESSION['count'] = 0; // require for notificationShowRedirect() method

        if (isset($_SESSION["notification"]) && !empty($_SESSION["notification"])) {

            $_SESSION["notification"] .= '<div class="text-center alert alert-' . $alert . ' alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>' . $text . '</b></div>';
        } else {

            $_SESSION["notification"] = '<div class="text-center alert alert-' . $alert . ' alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>' . $text . '</b></div>';
        }
    }


    public function notificationShow()
    {
        $this->flashData('notification');
    }

    public function login_check($table_name, $where_cond)
    {
        $sql_login = "SELECT * FROM " . $table_name . " WHERE $where_cond";
        $login = $this->db->con->prepare($sql_login);
        $login->execute();
        $total = $login->rowCount();

        if ($total == 1) {
            $data = $login->fetch(PDO::FETCH_ASSOC);
            return isset($data) ? $data : NULL;
        } else {
            return $total;
        }
    }

    public function login_redirect()
    {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $this->user_id          = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
            $this->user_userName    = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : NULL;
            $this->user_ty          = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : NULL;
            $this->user_empId       = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : NULL;
            $empData                = $this->empData($this->user_empId);
            $this->user_fullName    = $empData['emp_name'];
            $this->user_img         = $empData['emp_img'];
            $this->user_designation = $empData['emp_designation'];
            $this->user_joinDate    = $empData['entry_date'];
        }else{
            $this->redirect('user','login');
        }
    }

    public function importantNotification(){
        $notification = $this->db->view_all_by_cond('tbl_notifications','priority=1 AND status =1 AND emp_id="'.$this->user_empId.'"');
        return $notification;
    }
    public function getNotification(){
        $notification = $this->db->view_all_by_cond('tbl_notifications','priority!=1 AND status =1 AND emp_id="'.$this->user_empId.'"');
        return $notification;
    }

    public function entry_by($id){
        $entry_by = $this->db->raw_sql_single('tbl_users.emp_id, tbl_employee.emp_name FROM tbl_users LEFT JOIN tbl_employee ON tbl_employee.emp_id = tbl_users.emp_id WHERE tbl_users.user_id='.$id);
        return $entry_by['emp_name'];
    }

    public function get_emp_id($id){
        $emp_data = $this->db->details_by_cond('tbl_users','user_id='.$id);
        return $emp_data['emp_id'];
    }

    public function getAccTypeId($accNameKey){
        $accTypeData = $this->db->details_by_cond('acc_type_list', 'name_key = "'.$accNameKey.'"');
        if(!empty($accTypeData) && isset($accTypeData)){
            return $accTypeData['id'];
        }else{

        }
    }

    public function loadAccountTypes(){
        include 'application/library/AccountType.php';
        $this->acc_type = new AccountType();
    }

    public function loadLib($library, $param=''){
        include 'application/library/'.$library.'.php';
        $this->$library = new $library($param);
    }

    public function user_type($type){
        if ($type==1){echo 'Super Admin';}
        elseif ($type==2){echo 'Admin Level';}
        elseif ($type==3){echo 'Employee Level';}
    }

    public function empData($id){
        $emp_data = $this->db->details_by_cond('tbl_employee','emp_id="'.$id.'"');
        return $emp_data;
    }
    public function empName($id){
        $emp_data = $this->db->details_by_cond('tbl_employee','emp_id="'.$id.'"');
        return $emp_data['emp_name'];
    }

    public function empLevel($type){
        if ($type==1){echo 'Super Admin';}
        elseif ($type==2){echo 'Admin';}
        elseif ($type==3){echo 'Executive';}
    }

    public function empDesignation($designation){
        if ($designation==1){return 'Director & CEO';}
        elseif ($designation==2){return 'Operations Manager';}
        elseif ($designation==3){return 'Marketing Manager';}
        elseif ($designation==4){return 'Marketing Executive';}
        elseif ($designation==5){return 'Tele-Marketing Executive';}
        elseif ($designation==6){return 'Digital Marketing Executive';}
        elseif ($designation==7){return 'Call Manager';}
        elseif ($designation==8){return 'Call Executive';}
        elseif ($designation==9){return 'Programmer';}
        else{return '';}
    }

    public function workStatus($status){
        if ($status==1){return 'Ongoing';}
        elseif ($status==2){return 'Canceled';}
        elseif ($status==3){return 'Pending';}
        elseif ($status==4){return 'Forwarded';}
        elseif ($status==5){return 'Refused';}
        elseif ($status==6){return 'Undertaking';}
        elseif ($status==7){return 'Recomended';}
        elseif ($status==0){return 'Completed';}
        else{return '';}
    }

    public function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}