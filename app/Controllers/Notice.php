<?php

class Notice extends Controller {
	function __construct() {
		parent::__construct();
	}

	public function send_notice(){
		$this->login_redirect();
		$employee_list = $this->db->view_all_by_cond('tbl_employee', 'emp_status = 1');
		if (isset($_POST['submit'])){

			$employee 	= implode($_POST['group_members'], ',');
			$notice_data 	= array(
				'employee' 	=> $employee,
				'notice' 	=> $_POST['notice'],
				'status' 	=> 1,
				'created_at'=> date('Y-m-d h:i:s')
			);
			$notice_id = $this->db->Insert_data('tbl_notice',$notice_data);
		}
		
		include $this->view . 'notice/send_notice.php';
	}
	public function see_notices(){
		$this->login_redirect();
		$notices = $this->db->view_all_by_cond('tbl_notice','status=1');

		if (isset($_POST['edit_notice'])) {
			extract($_POST);
			$tbl_notice_update_data = array(
				'notice' 		=> $notice,
			);
			$update_notice = $this->db->Update_data('tbl_notice', $tbl_notice_update_data, 'id='.$id);
		}
		if (isset($_GET['action'])&& $_GET['action'] =='del') {

			$tbl_notice_update_data = array(
				'status' 		=> 0,
			);
			$delete_notice = $this->db->Update_data('tbl_notice', $tbl_notice_update_data, 'id='.$_GET['id']);

			$this->redirect('notice','see_notices');
		}

		include $this->view . 'notice/see_notices.php';
	}

}
?>