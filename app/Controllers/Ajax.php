<?php 
class Ajax extends Controller {
	function __construct() {
		parent::__construct();
	}
	

	public function getWorkListByFilter(){
		$this->login_redirect();
		$filter_type 	= $_GET['type'];
		$filter_assign 	= $_GET['filterAssign'];
		$empId 		 	= $_GET['empid'];
		$startDate 	 	= $_GET['startDate'];
		$endDate 	 	= $_GET['endDate'];

		$i 				=0;
		$query_cond  	= '';
		$assign_cond	= '';
		$see_all 	 	= 'status NOT BETWEEN 6 AND 7 ';
		$project_cond	= ' sw_id=0 ';
		$sw_cond	 	= ' project_id=0 ';

		if($this->user_ty==1){
			$emp_cond 	= ' ';
		}else{
			$emp_cond 	= ' AND emp_id ="'.$this->user_empId.'" OR assigned_by="'.$this->user_empId.'" ';
		}

		if ($filter_assign 	== 'assigned_to_me') {
			$emp_cond 	= ' AND emp_id ="'.$this->user_empId.'" ';
		}
		if ($filter_assign 	== 'assigned_by_me') {
			$emp_cond 		= '';
			$assign_cond 	= ' AND assigned_by ="'.$this->user_empId.'" ';
		}

		if ($filter_assign 	== 'assigned_to') {
			$emp_cond 	= ' AND emp_id ="'.$empId.'" ';
		}
		if ($filter_assign 	== 'assigned_by') {
			$emp_cond 		= '';
			$assign_cond 	= ' AND assigned_by ="'.$empId.'" ';
		}

		

		if ($startDate !='' && $endDate !='') {
			$date_cond 	='submit_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND ';
		}else{
			$date_cond 	='';
		}

		$output = '<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-striped " style="width: 100%">
		<thead class="data-table-head">
		<tr class="data-table-head-row bg-green">
		<th width="1%">SN.</th>
		<th width="14%">Title</th>';

		if($filter_type!='filter_assigned_to'){
			$output .='<th width="15%">Assigned To</th>';
		}
		if($filter_type!='filter_assigned_by'){
			$output .='<th width="10%">Assigned By</th>';
		}
		$output .= '
		<th width="10%">Starts On</th>
		<th width="10%">Deadline On</th>
		<th width="5%">Remaining</th>
		<th width="5%">Status</th>
		<th width="5%">Progress</th>
		<th width="5%">Rating</th>
		<th class="text-center" width="20%">Action</th>
		</tr>
		</thead><tbody>
		';

		
		if($filter_type=='see_all'){			
			$query_cond  .= $date_cond.$see_all.$emp_cond.$assign_cond;
		}elseif($filter_type=='comp_projects'){
			$query_cond  .= $date_cond.$project_cond.' AND status=0'.$emp_cond.$assign_cond;
		}elseif($filter_type=='comp_sw'){
			$query_cond  .= $date_cond.$sw_cond.' AND status=0'.$emp_cond.$assign_cond;
		}elseif($filter_type=='comp_all'){
			$query_cond  .= $date_cond.' status=0'.$emp_cond.$assign_cond;	
		}elseif($filter_type=='on_projects'){
			$query_cond  .= $date_cond.$project_cond.' AND status=1'.$emp_cond.$assign_cond;	
		}elseif($filter_type=='on_sw'){
			$query_cond  .= $date_cond.$sw_cond.' AND status=1'.$emp_cond.$assign_cond;		
		}elseif($filter_type=='on_all'){
			$query_cond  .= $date_cond.' status=1'.$emp_cond.$assign_cond;		
		}elseif($filter_type=='pending_projects'){
			$query_cond  .= $date_cond.$project_cond.' AND status=3'.$emp_cond.$assign_cond;
		}elseif($filter_type=='pending_sw'){
			$query_cond  .= $date_cond.$sw_cond.' AND status=3'.$emp_cond.$assign_cond;
		}elseif($filter_type=='pending_all'){
			$query_cond  .= $date_cond.' status=3'.$emp_cond.$assign_cond;
		}elseif($filter_type=='canceled_projects'){
			$query_cond  .= $date_cond.$project_cond.' AND status=2'.$emp_cond.$assign_cond;		
		}elseif($filter_type=='canceled_sw'){
			$query_cond  .= $date_cond.$sw_cond.' AND status=2'.$emp_cond.$assign_cond;
		}elseif($filter_type=='canceled_all'){
			$query_cond  .= $date_cond.' status=2'.$emp_cond.$assign_cond;
		}
		

		$query_cond  .= ' ORDER BY submit_date ASC';
		$get_work_list = $this->db->view_all_by_cond('vw_all_work_details', $query_cond);
		foreach ($get_work_list as $on_work) {
			$i++;
			if($on_work['project_id']!=0){
				$w_type= 'np';
			}if($on_work['sw_id']!=0){
				if ($on_work['sw_pid']!=0) {
					$w_type= 'ep';
				}else{
					$w_type= 'sw';
				}
			}
			$task_id=($on_work['project_id'] !=0)?$on_work['project_id']:$on_work['sw_id'];
			$percent = $on_work['completion_percent'];
			$submit_date = (empty($on_work['submit_date']))?$on_work['sw_submit_date']:$on_work['submit_date'];

			$output .='<tr class="';
			if($on_work['priority']==1){
				$output .= 'bg-danger';
			}elseif($on_work['priority']==2){
				$output .= 'bg-info';
			}elseif($on_work['priority']==3){
				$output .= 'bg-warning';
			}
			
			$output .='"><td>'.$i.'</td><td>';

			if ($on_work['sw_pid']!=0 || $on_work['sw_pid']!=NULL) {
				$project = $this->db->details_by_cond('tbl_projects','id='.$on_work['sw_pid']);

				$output .= '<a href="index.php?c=work&m=single_work_list&id='.$on_work['sw_id'].'">';
				$output .= $on_work['work_title'];

				if($on_work['sw_pid'] !=0){
					$output .= ' - '. $project['project_name'];
				} else {
					$output .= ' - '. $on_work['count'];
				}
				$output .='</a>';
			}else{
				$output .='<a href="index.php?c=work&m=single_project_list&id='.$on_work['project_id'].'">'.$on_work['work_title'].'</a>';
			}

			$output .='</td>';
			if($filter_type!='filter_assigned_to'){
				$output .='<td>';
				if($this->user_empId!=$on_work['emp_id']){
					$output .= $this->empName($on_work['emp_id']);
				}else{
					$output .= 'Myself';
				}
				
				$output .='</td>';
			}
			$output .='</td>';
			if($filter_type!='filter_assigned_by'){
				$output .='<td>';
				if($on_work['emp_id']==$on_work['assigned_by']){
					$output .= 'Self-Assigned';
				}else{
					$output .= $this->empName($on_work['assigned_by']);
				}
				$output .='</td>';
			}
			$output .='<td>';
			$output .= date('d, M Y', strtotime($on_work['start_date']));
			$output .='</td><td class="';
			$output .= $submit_date == date('y-m-d')?'bg-red':'';
			$output .='">';
			$output .= date('d, M Y', strtotime($submit_date)).' ';
			if($on_work['submit_at'] !=NULL){
				$output .= date('h:i:s a', strtotime($on_work['submit_at']));
			}
			$output .='</td><td>';
			$output .=($submit_date != date('Y-m-d'))?$this->diffDate(date('Y-m-d'), $submit_date):0;
			$output .=' Days</td><td><span class="label ';
			if($on_work['status']==0){
				$output .='label-success">';
			}elseif($on_work['status']==1){
				$output .='label-info">';
			}elseif($on_work['status']==2){
				$output .='label-danger">';
			}elseif($on_work['status']==3){
				$output .='label-warning">';
			}elseif($on_work['status']==4){
				$output .='label-warning">';
			}elseif($on_work['status']==5){
				$output .='label-danger">';
			}elseif($on_work['status']==6){
				$output .='label-success">';
			}elseif($on_work['status']==7){
				$output .='label-primary">';
			}    
			$output .= $this->workStatus($on_work['status']);
			$output .='</span></td><td>
			<div class="progress progress-xs progress-striped active">
			<div class="progress-bar progress-bar-success" style="width:';
			$output .= $percent;
			$output .= '%"></div></div><span class="badge bg-red">';
			$output .= $percent;
			$output .= '%</span></td><td>';
			$output .= $on_work['rating'].'/10</td>';
			$output .= '<td class="text-center">';
			if ($this->user_empId==$on_work['emp_id']){
				$check_report = $this->checkDailyReporting($on_work['work_id']);
				if ($check_report==false){
					$output .= '<a style="margin:0 1px;" href="index.php?c=work&m=daily_reporting&w_id=';
					$output .= $on_work['work_id']."&w_type=".$w_type."&task_id=".$task_id;
					$output .= '" class="btn bg-green btn-flat"';
					
					$output .= ' title="Daily Reporting"><i class="far fa-file-alt"></i></a>';
				}else{
					$output .= '<a style="margin:0 1px;" href="#" data-toggle="modal" data-target="#edit_daily_report" data-id="';
					$output .= $check_report.'" data-wid="'.$on_work['work_id'].'" data-pid="'.$task_id.'" data-wtype="'.$w_type.'" class="btn bg-green btn-flat"';
					$output .= ' title="View Today\'s Report"><i class="fas fa-file-alt"></i></a>';
				}
				if ($on_work['status']==1){
					$output .= '<a style="margin:0 1px;" href="#" title="Keep Pending" class="btn btn-flat bg-yellow take_action" data-status="3" data-id="';
					$output .= $on_work['work_id'];
					$output .= '"><i class="fas fa-pause-circle"></i></a>';
				}
				if ($on_work['status']==3){
					$output .= '<a style="margin:0 1px;" href="#" title="Keep Pending" class="btn btn-flat bg-yellow take_action" data-status="1" data-id="';
					$output .= $on_work['work_id'];
					$output .= '"><i class="fas fa-pause-circle"></i></a>';
				}

			}
			if ($this->user_ty==1){
				$output .='<a style="margin:0 1px;" href="#" class="btn btn-flat bg-yellow" data-wtype="';
				$output .= ($on_work['project_id']!=0)?'project':'sw';
				$output .= '" data-id="';
				$output .= ($on_work['project_id']!=0)?$on_work['project_id']:$on_work['sw_id'];
				$output .= '" data-toggle="modal" data-target="#rating-modal"><i class="fas fa-star-half-alt"></i></a>';

				$output .='<a type="#" title="Complete" class="btn btn-flat bg-green take_action ';
				if($on_work['completion_percent']!=100){
					$output.= 'disabled';
				}
				$output .= ' data-status="0" ';
				$output .= 'data-id="'.$on_work['work_id'].'"><i class="fas fa-check-circle"></i></a>';
				if($on_work['status']==2){
					$output .='<a type="#" title="Restart" class="btn btn-flat bg-green take_action ';
					$output .= ' data-status="1" ';
					$output .= 'data-id="'.$on_work['work_id'].'"><i class="fas fa-play-circle"></i></a>';
				}else{
					$output .='<a type="#" title="Cancel" class="btn btn-flat bg-red take_action ';
					$output .= ' data-status="2" ';
					$output .= 'data-id="'.$on_work['work_id'].'"><i class="fas fa-times-circle"></i></a>';
				}
			}
			$output .='</td></tr>';
		} 
		$output .='</tbody>
		</table>
		</div>';
		echo $output;
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

	public function changeWorkStatus(){
		$this->login_redirect();

		echo $status 		= $_GET['status'];
		$work_id 		= $_GET['work_id'];


		if ($status==5) {
			$refused_work_data = array(
				'work_id' 	 => $work_id,
				'refused_by' => $this->user_empId,
				'created_at' => date('Y-m-d h:i:s a')
			);
			$insert_data = $this->db->Insert_data('tbl_refused_works',$refused_work_data);
		}

		$update_status = array(
			'status' => $status
		);


		$update = $this->db->Update_data('tbl_works', $update_status, 'id='.$work_id);
		
	}

	public function recommendedWorks(){
		$this->login_redirect();
		$i = 0;
		if($this->user_ty!=3){
			$on_works_all = $this->db->view_all_by_cond('vw_all_work_details', 'status BETWEEN(4 TO 7) ORDER BY submit_date ASC');

		}else{
			$on_works_all = $this->db->view_all_by_cond('vw_all_work_details', 'status BETWEEN(4 TO 7) AND emp_id="'.$this->user_empId.'" ORDER BY submit_date ASC');
		}
		$output = '<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-striped " style="width: 100%">
		<thead class="data-table-head">
		<tr class="data-table-head-row bg-green">
		<th width="1%">SN.</th>
		<th width="13%">Title</th>';
		if($this->user_ty==1){
			$output .= '<th width="15%">Recommended To</th>';
		}
		
		$output .='<th width="15%">Recommended By</th>
		<th width="13%">To Start On</th>
		<th width="13%">Deadline On</th>
		<th width="5%">Remaining</th>
		<th width="10%">Status</th>
		<th class="text-center" width="15%">Action</th>
		</tr>
		</thead>
		<tbody>
		';

		foreach ($on_works_all as $on_work) {
			$i++;
			if($on_work['project_id']!=0){
				$w_type= 'np';
			}if($on_work['sw_id']!=0){
				if ($on_work['sw_pid']!=0) {
					$w_type= 'ep';
				}else{
					$w_type= 'sw';
				}
			}
			$task_id=($on_work['project_id'] !=0)?$on_work['project_id']:$on_work['sw_id'];
			$percent = $on_work['completion_percent'];
			$submit_date = (empty($on_work['submit_date']))?$on_work['sw_submit_date']:$on_work['submit_date'];

			$output .='<tr>';
			$output .='<td>'.$i.'</td><td>';

			if ($on_work['sw_pid']!=0 || $on_work['sw_pid']!=NULL) {
				$project = $this->db->details_by_cond('tbl_projects','id='.$on_work['sw_pid']);

				$output .= '<a href="index.php?c=work&m=single_work_list&id='.$on_work['sw_id'].'">';
				$output .= $on_work['work_title'];

				if($on_work['sw_pid'] !=0){
					$output .= ' - '. $project['project_name'];
				} else {
					$output .= ' - '. $on_work['count'];
				}
				$output .='</a>';
			}else{
				$output .='<a href="index.php?c=work&m=single_project_list&id='.$on_work['project_id'].'">'.$on_work['work_title'].'</a>';
			}

			$output .='</td>';
			if($this->user_ty==1){
				$output .='<td>';
				$output .= $this->empName($on_work['emp_id']);
				$output .='</td>';
			}		
			$output .='</td><td>';

			$output .= $this->empName($on_work['assigned_by']);

			$output .='</td>';
			
			$output .='<td>';
			$output .= date('d, M Y', strtotime($on_work['start_date']));
			$output .='</td><td class="';
			$output .= $submit_date == date('y-m-d')?'bg-red':'';
			$output .='">';
			$output .= date('d, M Y', strtotime($submit_date));
			$output .='</td><td>';
			$output .=($submit_date != date('Y-m-d'))?$this->diffDate(date('Y-m-d'), $submit_date):0;
			$output .='Days</td><td><span class="label ';			
			if($on_work['status']==0){
				$output .= 'label-success">';
			}elseif($on_work['status']==1){
				$output .= 'label-info">';
			}elseif($on_work['status']==2){
				$output .= 'label-danger">';
			}elseif($on_work['status']==3){
				$output .= 'label-warning">';
			}elseif($on_work['status']==4){
				$output .= 'label-warning">';
			}elseif($on_work['status']==5){
				$output .= 'label-default">';
			}elseif($on_work['status']==6){
				$output .= 'label-success">';
			}elseif($on_work['status']==7){
				$output .= 'label-primary">';
			}
			$output .= $this->workStatus($on_work['status']);
			$output .='</span></td><td class="text-center">';

			if ($_SESSION['emp_id'] == $on_work['emp_id']){
				$output .= '<button type="button" class="btn bg-green take_action" data-status="6" data-id="'.$on_work['work_id'].'"><i class="fas fa-check"></i></i>
				</button>
				<button type="button" class="btn bg-green" data-status="6" data-id="'.$on_work['work_id'].'" data-toggle="modal" data-target="#rating-modal"><i class="fas fa-share-square"></i>
				</button>
				<button type="button" class="btn bg-red" data-toggle="modal" data-target="#rating-modal"><i class="fas fa-times"></i>
				</button>';
			}
			if ($this->user_ty==1){
				$output .='<button type="button" class="btn bg-green" data-wtype="';
				$output .= ($on_work['project_id']!=0)?'project':'sw';
				$output .= '" data-id="';
				$output .= ($on_work['project_id']!=0)?$on_work['project_id']:$on_work['sw_id'];
				$output .= '" data-toggle="modal" data-target="#rating-modal"><i class="fas fa-star-half-alt"></i></button>';
			}
			$output .='</td></tr>';
		} 
		$output .='</tbody>
		</table>
		</div>';
		echo $output;

	}
	public function getPersonForChat(){
		$this->login_redirect();
		$key = $_POST['key'];
		$query = " emp_name, emp_id AS id FROM tbl_employee WHERE emp_name LIKE '%$key%' AND emp_id !='$this->user_empId' UNION SELECT work_title, work_id FROM vw_all_work_details WHERE work_title LIKE '%$key%' AND (emp_id='$this->user_empId' OR assigned_by='$this->user_empId')";
		$get_person = $this->db->raw_sql($query);
		$result 	= '';
		$result 	.= '<div class="person_list"><ul>';

		if($get_person) {
			foreach ($get_person as $data) {
				$result .= '<li data-id='.$data['id'].' data-name="'.$data['emp_name'].'">'.$data['emp_name'].'</li>';
			}
		}else{
			$result 	.= '<p>No Result Found</p>';
		}
		$result .= '</ul></div>';
		echo $result;
	}
	public function storeWorkMessages(){
		$this->login_redirect();
		$person_id		= $_GET['person_id'];
		$person_type	= $_GET['person_type'];
		$message		= $_GET['message'];
		$w_id 			= 0;
		if ($person_type == 'person') {
			$message_to = $person_id;
		}elseif ($person_type == 'work') {
			$w_id = $person_id;
			$get_work_data = $this->db->details_by_cond('vw_all_work_details', 'work_id='.$w_id);

			if($get_work_data['emp_id']== $this->user_empId) {
				if($get_work_data['emp_id'] == $get_work_data['assigned_by']) {
					$message_to = 'CEO';
				}else{
					$message_to = $get_work_data['assigned_by'];
				}
			}else{
				$message_to = $get_work_data['emp_id'];
			}
		}

		$tbl_messages_data = array(
			'message_from' 	=> $this->user_empId,
			'message_to' 	=> $message_to,
			'message_text' 	=> $w_id,
			'message_text' 	=> $message,
			'seen_status' 	=> 1,
			'created_at'	=> date('Y-m-d H:i:s')
		);
		$message_id = $this->db->Insert_data("tbl_messages", $tbl_messages_data);
	}

	public function getMessageList(){
		$this->login_redirect();
		$messages = $this->db->view_all_by_cond('tbl_messages','seen_status=1 AND message_to="'.$this->user_empId.'" OR message_from="'.$this->user_empId.'" ORDER BY created_at DESC');
		$output = '';
		$personArr = array();
		foreach ($messages as $msg) {
			if($msg['message_to']==$this->user_empId){
				$msg_p  = $msg['message_from'];
			}elseif($msg['message_from']==$this->user_empId){
				$msg_p  = $msg['message_to'];
			}
			
			if(!in_array($msg_p, $personArr)){
				$msg_person = $this->db->details_by_cond('tbl_employee','emp_id="'.$msg_p.'"');

				$last_msg = $this->db->details_by_cond('tbl_messages','message_from="'.$msg_p.'" OR message_to="'.$msg_p.'" ORDER BY id DESC LIMIT 1');
				$output .= '<li data-id="'.$msg_person['emp_id'].'" data-name="'.$msg_person['emp_name'].'">
				<a href="javascript:void(0);">
				<div class="pull-left">
				<img src="assets/images/employee_img/'.$msg_person['emp_img'].'" class="img-circle" alt="User Image">
				</div>
				<h4>'.$msg_person['emp_name'].'
				<small style="top: 35px;"><i class="fa fa-clock-o"></i> ';

				$datetime1 = date_create(date('Y-m-d H:i:s'));
				$datetime2 = date_create($last_msg['created_at']);
				$interval = date_diff($datetime1, $datetime2);

				if($interval->format('%y')==0){
					if($interval->format('%m')==0){
						if($interval->format('%d')==0){
							if($interval->format('%h')==0){
								if($interval->format('%i')==0){
									$output.= "Just Now";
								}else{
									$output.= $interval->format('%i Minutes');
								}
							}else{
								$output.= $interval->format('%h Hours');
							}
						}else{
							$output.= $interval->format('%d Days');
						}
					}else{
						$output.= $interval->format('%m Months');
					}
				}else{
					$output.= $interval->format('%y Years');
				}
				$output.='</small>
				</h4>
				<p style="overflow: hidden;">'.$last_msg['message_text'].'</p>
				</a>
				</li>';
			}
			array_push($personArr, $msg_p);
		}
		echo $output;
	}
	public function getMessages(){
		$this->login_redirect();
		$id 			= $_GET['id'];
		$messages 		= $this->db->view_all_by_cond('tbl_messages',' message_to ="'.$id.'" AND message_from="'.$this->user_empId.'" OR message_from ="'.$id.'" AND message_to="'.$this->user_empId.'" ORDER BY id ASC');
		// echo "<pre>";
		// print_r($messages);
		// echo "</pre>";
		$output = '';

		foreach($messages as $msg){
			$this->login_redirect();
			$empData = $this->empData($msg['message_from']);

			if($msg['message_from'] == $_SESSION['emp_id']){
				$class_name = 'self-msg';
			}else{
				$class_name = 'others-msg';				
			}

			$img =  (empty($empData['emp_img']))?'assets/img/avatar.png':'assets/images/employee_img/'. $empData['emp_img'];

			$output .= "<div class='".$class_name."'>
			<img class='img-circle' src='".$img."'>
			<p>".$msg['message_text']."<span class='msg-time'>".$this->formatDate($msg['created_at'])."</span></p>
			</div>";
		}
		echo $output;
	}

	public function changeWorkMessageStatus(){
		$this->login_redirect();
	}
}

?>