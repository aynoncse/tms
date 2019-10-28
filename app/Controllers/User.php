<?php

class User extends Controller
{
    public function login() {

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $this->redirect('dashboard','home');
        }
        if (isset($_POST['submit'])){
            $user_name   = isset($_POST['user_name'])? $_POST['user_name'] :NULL;
            $password    = MD5(isset($_POST['password'])? $_POST['password'] :NULL);
            $data = $this->login_check("tbl_users","user_name='$user_name' AND Password='$password' AND Status='1'");

            if (!empty($data)){
                $_SESSION['user_id']        = $data['user_id'];
                $_SESSION['emp_id']         = $data['emp_id'];
                $_SESSION['user_name']      = $data['user_name'];
                $_SESSION['user_type']      = $data['user_type'];
                $this->redirect('dashboard','home');
            }else{
                $this->setFlashData('error','Invalid User Name or Password');
            }
        }
        include $this->view . 'user/login.php';
    }
//end

//start
    public function logout(){
        session_start();
        session_destroy();
        $this->redirect('user','login');
    }
//end

//start
    public function add_user(){
        $this->login_redirect();

        $employees = $this->db->view_all_by_cond('tbl_employee','emp_status = 1 AND tbl_employee.emp_id NOT IN(SELECT tbl_users.emp_id FROM tbl_users)');
        $date_time =date('Y-m-d g:i:sA');

        if(isset($_POST['submit'])){
            extract($_POST);
            $form_data = array(
                'emp_id' => $emp_id,
                'user_name' => $user_name,
                'user_type' => $user_type,
                'password' => MD5($password),
                'status' => 1 ,
                'entry_by' => !empty($this->user_id)?$this->user_id:0,
                'entry_date' => $date_time,
                'update_by' => !empty($this->user_id)?$this->user_id:0
            );

            $userexits = $this->db->details_by_cond('tbl_users',"user_name='".$_POST['user_name']."'");

            if (empty($userexits)){
                $created_id = $this->db->Insert_data("tbl_users", $form_data);
            }else {
                $this->notificationStore('This User Name "'.$_POST['user_name'].'" Already Exist, Try Another User Name.');
            }

            if($created_id) {
                $this->notificationStore('User Successfully Created', 'success');
            } 

            else {
                $this->notificationStore('Sorry! User Create Failed, Please Try again');
            }

        }

        include $this->view . 'user/add_user.php';
    }
//end function add_user

    public function view_all_users(){
        $this->login_redirect();
        $all_users = $this->db->view_all("tbl_users");
        include $this->view . 'user/view_all_users.php';
    }
//end function view_all_users

//start
    public function view_user_details(){
        $this->login_redirect();
        $user = $this->db->raw_sql_single('* FROM `tbl_users` LEFT JOIN tbl_employee ON tbl_users.emp_id=tbl_employee.emp_id WHERE user_id='.$_GET['id']);

        include $this->view . 'user/user_details.php';
    }
//end

//start
    public function change_user_status(){
        $this->login_redirect();
        $intoken = isset($_GET['intoken']) ? $_GET['intoken'] : NULL;
        $actoken = isset($_GET['actoken']) ? $_GET['actoken'] : NULL;

        if (!empty($intoken)) {
            $form_data = array('Status' => '0', 'update_by' => $this->user_id);

            $this->db->Update_data("tbl_users", $form_data, "where user_id='$intoken'");
        }

        if (!empty($actoken)) {
            $form_data = array('Status' => '1', 'update_by' => $this->user_id);

            $this->db->Update_data("tbl_users", $form_data, "where user_id='$actoken'");
        }

        $this->redirect('user','view_all_users');

    }
//end

    public function edit_user(){
        $this->login_redirect();
        $date_time =date('Y-m-d g:i:sA');
        if (isset($_POST['submit'])){
            $user_id = $_POST['user_id'];
            $form_data_user_access_update = array(
                'user_type'   => $_POST['user_type'],
                'update_by'   => $this->user_id,
                'last_update' => $date_time
            );

            $this->notificationStore('User Update Successful', 'success');
            $this->redirect('user','view_all_users');

        }else{
            $user_id = $_GET['id'];

            $employees = $this->db->view_all_by_cond('tbl_employee','employee_status=1');
            $user = $this->db->details_by_cond('tbl_users','user_id='.$user_id);

            include $this->view . 'user/edit_user.php';
        }
    }

    public function user_change_password(){
        $this->login_redirect();
        if (isset($_POST['submit'])){
            $postData= $_POST;

            $password = md5($_POST['new_password']);
            $this->db->Update_data('tbl_users',['Password'=>$password],'user_id='.$postData['user_id']);

            $this->notificationStore('Password Changed');

            $this->redirectJs('user','user_change_password','&id='.$postData['user_id']);
        }else{
            $user = $this->db->details_by_cond('tbl_users','user_id='.$_GET['id']);
            include $this->view . 'user/user_change_password.php';
        }
    }

    public function ajax_get_user_name(){
        $user_name = $_GET['user_name'];
        $User_id = $this->user_id;
        $name = $this->db->details_by_cond('tbl_users', 'user_name="'.$user_name.'"');

        echo json_encode($name);
    }

    public function ajax_get_employee_name(){
        $id = $_GET['id'];
        $User_id = $this->user_id;
        $name = $this->db->details_by_cond('tbl_employee', 'emp_id="'.$id.'"');

        echo json_encode($name);
    }


}