<?php

class Work extends Controller {
	function __construct() {
		parent::__construct();
	}

	public function work_files(){
		$this->login_redirect();
		if (isset($_GET['w_id'])) {

			$w_id 	= $_GET['w_id'];
			$files 	= $this->db->view_all_by_cond('tbl_work_files','work_id='.$w_id);

		}
		if (isset($_POST['upload'])) {

			if (isset($_FILES['attachment']['name']) && !empty($_FILES['attachment']['name'])) {
				$file_name 	 = uniqid() . ($_FILES['attachment']['name']);
				$tmp_name 	 = ($_FILES['attachment']['tmp_name']);
				$destination = "work_files/".$file_name;
				$upload 	 = move_uploaded_file($tmp_name, $destination);
			}else{
				$file_name 	 = '';
			}

			if ($file_name !='') {
				$tbl_work_files_data = array(
					'work_id' 		=> $w_id,
					'file_path' 	=> $file_name,
					'created_by' 	=> $this->user_id,
					'created_at'	=> date('Y-m-d h:i:s a')
				);
				$work_files_id = $this->db->Insert_data("tbl_work_files", $tbl_work_files_data);
			}
			if (isset($work_files_id)) {
				$this->redirect('work','work_files','&w_id='.$w_id);
			}
		}
		if (isset($_GET['action']) && $_GET['action']=='delete') {
			$id 	= $_GET['id'];
			$w_id 	= $_GET['w_id'];
			$this->db->Delete_data('tbl_work_files', 'id='.$id);
			unlink($_GET['file']);
			$this->redirect('work','work_files','&w_id='.$w_id);
		}

		include $this->view . 'work/work_files.php';
	}

	public function checkDailyReporting($work_id){
		$this->login_redirect();
		$check_report = $this->db->details_by_cond('tbl_daily_progress','date="'.date('Y-m-d').'" AND work_id='.$work_id);
		if ($check_report) {
			return $check_report['id'];
		} else {
			return false;
		}
	}

	public function getDailyReporting(){
		$this->login_redirect();
		$id = (isset($_GET['id'])) ? $_GET['id'] : 0 ;
		$check_report = $this->db->details_by_cond('tbl_daily_progress','id='.$id);
		
		$result = '';
		if ($check_report) {
			$result .= '
			<input type="hidden" name="prev_count" value="'.$check_report['count'].'"/>
			<input type="hidden" name="prev_completion" value="'.$check_report['completion_percent'].'"/>
			<div class="form-group">
			<label>Description</label>
			<textarea name="description" class="form-control" rows="3" required>'.$check_report['description'].'</textarea>
			</div>
			<!-- /.form-group -->
			';
			if($check_report['count']>0){
				$result .='				
				<div class="form-group">
				<label for="">Todays Count</label>
				<div class="input-group">
				<input type="text" name="count" value="'.$check_report['count'].'" onkeypress="return numbersOnly(event)" class="form-control"/>
				<span class="input-group-addon">#</span>
				</div>
				</div>
				<!-- /.form-group -->';
			}


			$result .='
			<!-- /.form-group -->
			<div class="form-group">
			<label for="">Todays Progress</label>
			<div class="input-group">
			<input type="text" name="completion_percent" value="'.$check_report['completion_percent'].'" onkeypress="return numbersOnly(event)" class="form-control" required/>
			<span class="input-group-addon">%</span>
			</div>
			</div>
			<!-- /.form-group -->';
		}
		echo $result;
	}

	public function view_daily_reporting() {
		$this->login_redirect();
		if ($this->user_ty!=1){
			$this->redirectJs('dashboard','home');
		}
		$works 		= $this->db->raw_sql(' tbl_daily_progress.*, tbl_works.sw_id AS sw_id, tbl_works.project_id AS project_id, tbl_projects.project_name AS project_name, tbl_single_works.work_title AS work_title FROM ( ( ( tbl_daily_progress LEFT JOIN tbl_works ON tbl_works.id = tbl_daily_progress.work_id ) LEFT JOIN tbl_projects ON tbl_works.project_id = tbl_projects.id ) LEFT JOIN tbl_single_works ON tbl_single_works.sw_id = tbl_works.sw_id )');
		
		if (isset($_POST['add_comment'])) {
			extract($_POST);
			$comment_data = array(
				'director_comment' => $comment,
			);
			$update_comment = $this->db->Update_data('tbl_daily_progress', $comment_data,'id='.$_POST['id']);

			if($update_comment){
				$this->redirectJs('work','view_daily_reporting');
			}
		}
		include $this->view . 'work/view_daily_reporting.php';

	}

	public function daily_reporting() {
		$this->login_redirect();
		if (isset($_GET['w_id']) && isset($_GET['w_type'])) {
			$w_id 		= $_GET['w_id'];
			$w_type = $_GET['w_type'];
		}
		

		if ($w_type == 'np') {
			$p_id = isset($_GET['task_id'])?$_GET['task_id']:0;
			$completion_works = $this->db->details_by_cond('tbl_projects','id='.$p_id);
		} 
		else {
			$sw_id = $_GET['task_id'];
			$completion_works = $this->db->details_by_cond('tbl_single_works','sw_id='.$sw_id);
		}

		

		if (isset($_POST['submit'])) {
			extract($_POST);

			$crnt_percent	= floatval($completion_percent) + floatval($completion_works['completion_percent']);
			$crnt_percent 	= ($crnt_percent >100)?100:$crnt_percent;

			$tbl_daily_progress_data = array(
				'emp_id' 			=> $emp_id,
				'work_id' 			=> $w_id,
				'description' 		=> $description,
				'completion_percent'=> $completion_percent,
				'count'				=> isset($count)?$count:0,
				'report_to'			=> 1,
				'date' 				=> $report_date,
				'created_by' 		=> $this->user_id
			);
			$daily_progress_id = $this->db->Insert_data("tbl_daily_progress", $tbl_daily_progress_data);

			if($daily_progress_id){

				$completion_percent_data = array(
					'completion_percent' => $crnt_percent
				);

				if ($w_type=='np') {
					$update_completion_percent = $this->db->Update_data('tbl_projects', $completion_percent_data,'id='.$p_id);
				}else{
					$update_completion_percent = $this->db->Update_data('tbl_single_works', $completion_percent_data,'sw_id='.$sw_id);
				}

				if($update_completion_percent){
					$this->notificationStore('Reported Successfully', 'success');
				}
			}else {
				$this->notificationStore('There is a problem that we need to fix. Please try again later..', 'error');
			}
			if($update_completion_percent){
				$this->redirectJs('work','work_list');
			}
		}

		include $this->view . 'work/daily_reporting.php';

	}

	public function recommended_works() {
		$this->login_redirect();

		if(isset($_POST['work_forward'])){
			$forward_data = array(
				'work_id' 		=> $_POST['work_id'],
				'forward_by' 	=> $this->user_empId,
				'forward_to' 	=> $_POST['forward_to'],
				'description' 	=> $_POST['description'],
				'created_at' 	=> date('Y-m-d h:i:s a')
			);
			$insert_data = $this->db->Insert_data('tbl_forwarded_works',$forward_data);

			$update_status = array(
				'emp_id' => $_POST['forward_to'],
				'status' => 7
			);
			$update = $this->db->Update_data('tbl_works', $update_status, 'id='.$_POST['work_id']);
		}

		$emp_data = $this->db->view_all_by_cond('tbl_employee','emp_status = 1 AND emp_id!="'.$this->user_empId.'"');
		
		if($this->user_ty!=3){
			
			$on_works_all = $this->db->view_all_by_cond('vw_all_work_details', 'status BETWEEN 4 AND 7 ORDER BY submit_date ASC');

		}else{

			$on_works_all = $this->db->view_all_by_cond('vw_all_work_details', 'status BETWEEN 4 AND 7 AND emp_id="'.$this->user_empId.'"');

		}

		include $this->view . 'work/recommended_works.php';
	}

	public function work_list() {
		$this->login_redirect();

		if($this->user_ty!=3){
			
			$on_works_all = $this->db-> view_all_by_cond('vw_all_work_details', 'status NOT BETWEEN 6 AND 7 ORDER BY submit_date ASC');

		}else{

			$on_works_all = $this->db->view_all_by_cond('vw_all_work_details', 'status NOT BETWEEN 6 AND 7 AND emp_id="'.$this->user_empId.'" OR assigned_by="'.$this->user_empId.'" ORDER BY submit_date ASC');

		}

		if (isset($_POST['add_rating'])) {
			extract($_POST);
			$rating_data = array(
				'rating' => $rating,
			);
			if($work_type =='project'){
				$update_comment = $this->db->Update_data('tbl_projects', $rating_data,'id='.$_POST['id']);
			}
			if($work_type =='sw'){
				$update_comment = $this->db->Update_data('tbl_single_works', $rating_data,'sw_id='.$_POST['id']);
			}

			if($update_comment){
				$this->redirectJs('work','work_list');
			}
		}

		if(isset($_POST['update_daily_report'])){
			extract($_POST);
			if ($w_type == 'np') {
				$completion_works = $this->db->details_by_cond('tbl_projects','id='.$p_id);
			}
			else {
				$completion_works = $this->db->details_by_cond('tbl_single_works','sw_id='.$sw_id);
			}

			$prev_percent 	= floatval($completion_works['completion_percent']) - floatval($prev_completion);
			$crnt_percent	= floatval($completion_percent) + $prev_percent;
			$crnt_percent 	= ($crnt_percent >100)?100:$crnt_percent;

			$report_data = array(
				'description' 			=> $description,
				'completion_percent' 	=> $completion_percent,
				'count'					=> (isset($count) && $count !='')?$count:0
			);

			$update_report = $this->db->Update_data('tbl_daily_progress', $report_data,'id='.$_POST['id']);
			if($update_report){

				$completion_percent_data = array(
					'completion_percent' => $crnt_percent
				);

				if ($w_type=='np') {
					$update_completion_percent = $this->db->Update_data('tbl_projects', $completion_percent_data,'id='.$p_id);
				}else{
					$update_completion_percent = $this->db->Update_data('tbl_single_works', $completion_percent_data,'sw_id='.$sw_id);
				}
				$this->redirectJs('work','work_list');
			}

		}

		include $this->view . 'work/work_list.php';
	}

	public function single_project_list() {
		$this->login_redirect();
		$id 		= $_GET['id'];
		$project 	= $this->db->raw_sql_single('project.*,works.id as w_id, groups.group_name, groups.id AS pg_id FROM ((tbl_projects AS project INNER JOIN tbl_programmers_group AS groups ON project.id = groups.project_id) INNER JOIN tbl_works AS works ON project.id = works.project_id) WHERE project.id ='.$id);
		//print_r($project);
		$emp = $this->empData($project['project_manager']);

		$pg_id = $project['pg_id'];
		$percent = $project['completion_percent'];
		if($percent<29){
			$color = 'danger';
		}elseif($percent<30){
			$color = 'yellow';
		}elseif($percent<99){
			$color = 'primary';
		}elseif($percent==100){
			$color = 'success';
		}
		$emp_data = $this->db->raw_sql('employee.emp_name, employee.emp_img, gm.* FROM tbl_employee AS employee RIGHT JOIN tbl_programmers_group_members AS gm ON employee.emp_id = gm.emp_id WHERE gm.pg_id ='.$pg_id);
		/*echo "<pre>";
		print_r($emp_data);
		echo "</pre>";*/


		include $this->view . 'work/single_project_list.php';
	}

	public function single_work_list() {
		$this->login_redirect();
		$id 		= $_GET['id'];
		$work 		= $this->db->raw_sql_single('sw.*, works.id AS w_id, projects.project_name FROM ((tbl_single_works AS sw LEFT JOIN tbl_works AS works ON sw.sw_id = works.sw_id) LEFT JOIN tbl_projects AS projects ON projects.id = sw.project_id) WHERE sw.sw_id ='.$id);
		$emp = $this->empData($work['emp_id']);


		$percent = $work['completion_percent'];
		if($percent<29){
			$color = 'danger';
		}elseif($percent<30){
			$color = 'yellow';
		}elseif($percent<99){
			$color = 'primary';
		}elseif($percent==100){
			$color = 'success';
		}

		/*echo "<pre>";
		print_r($work);
		echo "</pre>";*/

		include $this->view . 'work/single_work_list.php';
	}

	public function changeNotificatonStatus(){
		$this->login_redirect();
		$id 			= $_GET['id'];
		$update_status  = array('status' => 0);
		$change_status 	= $this->db->Update_data('tbl_notifications', $update_status, 'id='.$id);
	}


	public function storeWorkMessages(){
		$this->login_redirect();
		$w_id 			= $_GET['w_id'];
		$comment 		= $_GET['comment'];


		$tbl_messages_data = array(
			'work_id' 		=> $w_id,
			'comment' 		=> $comment,
			'seen_status' 	=> 1,
			'created_by' 	=> $_SESSION['emp_id'],
			'created_at'	=> date('Y-m-d h:i:s a')
		);
		$work_comment_id = $this->db->Insert_data("tbl_messages", $tbl_messages_data);
	}

	public function newMessagesCount(){
		$this->login_redirect();
		$w_id 			= $_GET['w_id'];
		$newMessages 	= $this->db->view_all_by_cond('tbl_messages','work_id ='.$w_id.' AND created_by!="'.$_SESSION['emp_id'].'" AND seen_status=1');
		$newMessages = sizeof($newMessages);

		echo ($newMessages>0)?'<p>'.$newMessages.'</p>':NULL;
	}

	public function changeWorkMessagesStatus(){
		$this->login_redirect();
		$w_id 			= $_GET['w_id'];
		$update_status  = array('seen_status' => 0);
		$change_status 	= $this->db->Update_data('tbl_messages', $update_status, 'work_id='.$w_id);
	}

	public function getWorkMessages(){
		$this->login_redirect();
		$w_id 			= $_GET['w_id'];
		$messages 		= $this->db->view_all_by_cond('tbl_messages','work_id ='.$w_id.' ORDER BY id ASC');
		$output = '';

		foreach($messages as $msg){
			$this->login_redirect();
			$empData = $this->empData($msg['created_by']);

			if($msg['created_by'] == $_SESSION['emp_id']){
				$class_name = 'self-msg';
			}else{
				$class_name = 'others-msg';				
			}

			$img =  (empty($empData['emp_img']))?'assets/img/avatar.png':'assets/images/employee_img/'. $empData['emp_img'];

			$output .= "<div class='".$class_name."'>
			<img class='img-circle' src='".$img."'>
			<p>".$msg['comment']."<span class='msg-time'>".$this->formatDate($msg['created_at'])."</span></p>
			</div>";
		}
		echo $output;
	}

	public function getEmployeeByDesignation(){
		$this->login_redirect();
		$designation 	= $_POST['designation'];
		$emp_data 		= $this->db->view_all_by_cond('tbl_employee','emp_status = 1 AND emp_designation ='.$designation);
		$output 		='<option disabled selected hidden>Click to Select</option>';
		if(!empty($emp_data)){
			foreach ($emp_data as $emp) {
				$output .= "<option value=".$emp['emp_id'].">".$emp['emp_name']."</option>";
			}
			echo $output;
		}else{
			echo $output;
		}
	}

	public function set_target_work() {

		$this->login_redirect();
		$employees 		= $this->db->view_all_by_cond('tbl_employee','emp_status = 1');
		$work_titles	= $this->db->view_all('tbl_work_titles','');

		if (isset($_POST['submit'])) {
			extract($_POST);

			if(!empty($work_title)){
				$w_titles = $this->db->details_by_cond('tbl_work_titles','work_title ="'.$work_title.'"');
				if(!$w_titles){

					$tbl_work_title_data = array(
						'work_title' => $work_title
					);
					$insert_work_title = $this->db->Insert_data("tbl_work_titles", $tbl_work_title_data);
				}
			}

			$tbl_target_works_data = array(
				'for_month' 		=> date('Y-m-d',strtotime($for_month)),
				'work_for' 			=> $work_for,
				'target_type' 		=> $target_type,
				'emp_id' 			=> $emp_id,
				'work_title' 		=> $work_title,
				'description' 		=> $description,
				'count' 			=> $work_count,
				'daily_count'		=> $daily_count,
				'created_by' 		=> $this->user_id,
				'created_at'	=> date('Y-m-d h:i:s a')
			);

			$target_id = $this->db->Insert_data("tbl_target_works", $tbl_target_works_data);

			if($target_id){
				$this->notificationStore('Target Work Set Successfully', 'success');
				$this->redirect('work','target_work_list');
			}
		}
		include $this->view . 'work/set_target_work.php';
	}

	public function target_work_list() {
		$this->login_redirect();
		if (isset($_POST['update'])) {
			extract($_POST);
			$tbl_target_works_update_data = array(
				'work_title' 		=> $work_title,
				'count' 			=> $count,
				'daily_count'		=> $daily_count,
				'description'		=> $description,
			);
			$update_role = $this->db->Update_data('tbl_target_works', $tbl_target_works_update_data, 'id='.$id);
		}
		if (isset($_GET['action'])&& $_GET['action'] =='delete') {

			$this->db->Delete_data('tbl_target_works', 'id='.$_GET['id']);
			$this->redirect('work','target_work_list');
		}
		
		$work_titles	= $this->db->view_all('tbl_work_titles','');
		if($this->user_ty !=3){
			$target_works 	= $this->db->view_all_by_cond('tbl_target_works','MONTH(for_month)="'.date('m').'" AND YEAR(for_month)="'.date('Y').'"');
		}else{
			$target_works 	= $this->db->view_all_by_cond('tbl_target_works','MONTH(for_month)="'.date('m').'" AND YEAR(for_month)="'.date('Y').'" AND emp_id="'.$this->user_empId.'"');
		}

		include $this->view . 'work/target_work_list.php';
	}


	public function assign_work() {
		$this->login_redirect();
		$programmers 	= $this->db->view_all_by_cond('tbl_employee','emp_status = 1 AND emp_designation="9"');
		$employees 		= $this->db->view_all_by_cond('tbl_employee','emp_status = 1');
		$projects 		= $this->db->view_all('tbl_projects','');
		$work_titles	= $this->db->view_all('tbl_work_titles','');
		$sw_id			= 0;
		$g_project_id	= 0;
		$start_date		= $end_date = '';
		$submit_at 		='';

		if (isset($_POST['submit'])) {
			extract($_POST);

			if (isset($_FILES['attachment']['name']) && !empty($_FILES['attachment']['name'])) {
				$file_name = uniqid() . ($_FILES['attachment']['name']);
				$tmp_name = ($_FILES['attachment']['tmp_name']);
				$destination = "work_files/" . $file_name;
				$upload = move_uploaded_file($tmp_name, $destination);
			}else{
				$file_name = '';
			}

			$submit_at = ($deadline==2)?'':$submit_at;

			if(!empty($work_title)){
				$w_titles = $this->db->details_by_cond('tbl_work_titles','work_title ="'.$work_title.'"');
				if(!$w_titles){

					$tbl_work_title_data = array(
						'work_title' => $work_title
					);
					$insert_work_title = $this->db->Insert_data("tbl_work_titles", $tbl_work_title_data);
				}
			}
			

			if ($work_for==9) {

				if ($work_type==1) {
					$project_manager = $emp_id;
				}

				if($project_type==2){
					$tbl_project_data = array(
						'project_name' 		=> $project_name,
						'project_manager' 	=> $project_manager,
						'description' 		=> $description,
						'start_date' 		=> $this->date($start_date,'Y-m-d'),
						'end_date' 			=> $this->date($end_date,'Y-m-d'),
						'assigned_by' 		=> $this->user_empId,
						'created_by' 		=> $this->user_id,
						'created_at'		=> date('Y-m-d h:i:s a')
					);

					$g_project_id = $this->db->Insert_data("tbl_projects", $tbl_project_data);

					$tbl_programmers_group_data = array(
						'project_id' 		=> $g_project_id,
						'group_name' 		=> isset($group_name)?$group_name:''
					);
					$pg_id = $this->db->Insert_data("tbl_programmers_group", $tbl_programmers_group_data);

					if (isset($group_members) && !empty($group_members)) {
						foreach ($group_members as $emp_id) {
							$tbl_programmers_group_members_data = array(
								'pg_id' 	=> $pg_id,
								'emp_id'	=> $emp_id

							);
							$pg_members_id = $this->db->Insert_data("tbl_programmers_group_members", $tbl_programmers_group_members_data);
						}
						$update_project_manager_data = array(
							'role' 			=> 1,
						);
						$update_role = $this->db->Update_data('tbl_programmers_group_members', $update_project_manager_data, 'pg_id='.$pg_id.' AND emp_id="'.$project_manager.'"');
					}else{
						$tbl_programmers_group_members_data = array(
							'pg_id' 	=> $pg_id,
							'emp_id'	=> $emp_id,
							'role' 		=>1
						);
						$pg_members_id = $this->db->Insert_data("tbl_programmers_group_members", $tbl_programmers_group_members_data);
					}
				}
				if($project_type==1){
					$tbl_single_work_data = array(
						'emp_id' 			=> $emp_id,
						'project_id' 		=> isset($project_id)?$project_id:0,
						'work_title' 		=> $work_title,
						'work_description' 	=> $description,
						'start_date' 		=> $this->date($start_date,'Y-m-d'),
						'end_date' 			=> $this->date($end_date,'Y-m-d'),
						'submit_at'			=> $submit_at,
						'assigned_by' 		=> $this->user_empId,
						'created_by' 		=> $this->user_id,
						'created_at'		=> date('Y-m-d h:i:s a')
					);
					$sw_id = $this->db->Insert_data("tbl_single_works", $tbl_single_work_data);
				}

			}
			

			if ($work_type == 1 && $work_for !=9) {
				$tbl_single_work_data = array(
					'emp_id' 			=> $emp_id,
					'project_id' 		=> isset($project_id)?$project_id:0,
					'work_title' 		=> $work_title,
					'count'				=> $work_count,
					'work_description' 	=> $description,
					'start_date' 		=> $this->date($start_date,'Y-m-d'),
					'end_date' 			=> $this->date($end_date,'Y-m-d'),
					'submit_at'			=> $submit_at,
					'assigned_by' 		=> $this->user_empId,
					'created_by' 		=> $this->user_id,
					'created_at'		=> date('Y-m-d h:i:s a')
				);
				$sw_id = $this->db->Insert_data("tbl_single_works", $tbl_single_work_data);
			}

			$tbl_work_data = array(
				'sw_id' 			=> isset($sw_id)?$sw_id:0,
				'project_id' 		=> $g_project_id,
				'emp_id' 			=> isset($emp_id)?$emp_id:'0',
				'work_for' 			=> $work_for,
				'work_type' 		=> $work_type,
				'priority' 			=> (isset($priority) && !empty($priority))?$priority:0,
				'deadline'			=> $deadline,
				'status' 			=> 7,
				'created_by' 		=> $this->user_id,
				'created_at'		=> date('Y-m-d h:i:s a')
			);
			$work_id = $this->db->Insert_data("tbl_works", $tbl_work_data);


			if ($file_name !='') {
				$tbl_work_files_data = array(
					'work_id' 				=> $work_id,
					'file_path' 		=> $file_name,
					'created_by' 		=> $this->user_id,
					'created_at'		=> date('Y-m-d h:i:s a')
				);
				$work_files_id = $this->db->Insert_data("tbl_work_files", $tbl_work_files_data);
			}

			if($sw_id!=0){
				$notification = 'You have recommended to a new task name "'.$work_title.'"';
				$path = 'c=work&m=single_work_list&id='.$sw_id;
			}elseif($g_project_id!=0){
				$notification 	= 'You have recommended to a new project name "'.$project_name.'"';
				$path 			= 'c=work&m=single_project_list&id='.$g_project_id;
			}

			$tbl_notifications_data = array(
				'emp_id' 		=>$emp_id,
				'notification'	=>$notification,
				'path'			=>$path,
				'priority'		=>(isset($priority) && !empty($priority))?$priority:0,
				'status'		=>1
			);
			$work_id = $this->db->Insert_data("tbl_notifications", $tbl_notifications_data);
		}
		include $this->view . 'work/assign_work.php';
	}

}
