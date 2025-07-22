<?php
require_once('../config.php');
Class Content extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function update(){
		extract($_POST);
		$content_file="../".$file.".html";
		$update = file_put_contents($content_file, $content);
		if($update){
			return json_encode(array("status"=>"success"));
			$this->settings->set_flashdata("success",ucfirst($file)." content is successuly updated");
			exit;
		}
	}
	public function education(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .= ", ";
				$data .= "`$k` = '$v'";
			}
		}
				if(!empty($data)) $data .= ", ";
				$data .= "`description` = '".addslashes(htmlentities($description))."'";

		if(empty($id)){
			$sql ="INSERT INTO education set $data";
		}else{
			$sql ="UPDATE education set $data where id = {$id}";
		}
		$save = $this->conn->query($sql);
		$action = empty($id) ? "added":"updated";
		if($save){
			$resp['status']='success';
			$resp['message']= " Educational Attainment Details successfully ".$action;
			$this->settings->set_flashdata('success',$resp['message']);
			
		}else{
			$resp['status']='failed';
			$resp['message']= " error:".$sql;
		}
		return json_encode($resp);
		exit;
	}
	public function education_delete(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM education where id = $id");
		if($qry){
			$resp['status']='success';
			$resp['message']= " Educational Attainment Details successfully deleted";
			$this->settings->set_flashdata('success',$resp['message']);
		}
	}

	public function work(){
		extract($_POST);
		$data = "";
		
		// Get the absolute path to the uploads directory
		$uploads_base_path = $_SERVER['DOCUMENT_ROOT'] . '/portfolio/uploads/';
		
		// Handle image upload for logo
		if(isset($_FILES['company_logo']) && $_FILES['company_logo']['tmp_name'] != ''){
			$relative_path = 'uploads/logos/';
			$absolute_path = $uploads_base_path . 'logos/';
			
			if (!file_exists($absolute_path)) {
				mkdir($absolute_path, 0777, true);
			}
			
			$filename = time() . '_' . $_FILES['company_logo']['name'];
			
			if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $absolute_path . $filename)){
				if(!empty($data)) $data .= ", ";
				// Store the web-accessible path in the database
				$data .= "`company_logo` = '{$relative_path}{$filename}'";
				error_log("Logo uploaded successfully");
			} else {
				error_log("Failed to upload logo. Error: " . error_get_last()['message']);
			}
		}
		
		// Handle certificate file upload
		if(isset($_FILES['certificate_file']) && $_FILES['certificate_file']['tmp_name'] != ''){
			$relative_path = 'uploads/certificates/';
			$absolute_path = $uploads_base_path . 'certificates/';
			
			if (!file_exists($absolute_path)) {
				mkdir($absolute_path, 0777, true);
			}
			
			$filename = time() . '_' . $_FILES['certificate_file']['name'];
			
			if(move_uploaded_file($_FILES['certificate_file']['tmp_name'], $absolute_path . $filename)){
				if(!empty($data)) $data .= ", ";
				// Store the web-accessible path in the database
				$data .= "`certificate_file` = '{$relative_path}{$filename}'";
				error_log("Certificate uploaded successfully");
			} else {
				error_log("Failed to upload certificate. Error: " . error_get_last()['message']);
			}
		}
		
		// Rest of your function remains the same...
		// Other form data
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id', 'description', 's_month', 's_year', 'e_month', 'e_year', 'present'))){
				if(!empty($data)) $data .= ", ";
				$data .= "`$k` = '".addslashes($v)."'";
			}
		}
	
		// Description
		if(isset($description) && $description != ''){
			if(!empty($data)) $data .= ", ";
			$data .= "`description` = '".addslashes(htmlentities($description))."'";
		}
	
		// Duration fields
		if(isset($s_month) && isset($s_year)){
			if(!empty($data)) $data .= ", ";
			$data .= "`started` = '{$s_month}_{$s_year}'";
		}
		
		if(isset($present) && $present == 'on'){
			if(!empty($data)) $data .= ", ";
			$data .= "`ended` = 'Present'";
		} else if(isset($e_month) && isset($e_year)){
			if(!empty($data)) $data .= ", ";
			$data .= "`ended` = '{$e_month}_{$e_year}'";
		}
	
		// Insert or Update
		if(empty($id)){
			$sql = "INSERT INTO work SET $data";
		} else {
			$sql = "UPDATE work SET $data WHERE id = {$id}";
		}
	
		error_log("SQL Query: " . $sql); // Debug the SQL query
	
		$save = $this->conn->query($sql);
		$action = empty($id) ? "added" : "updated";
	
		if($save){
			$resp['status'] = 'success';
			$resp['message'] = "Work Details successfully " . $action;
			$this->settings->set_flashdata('success', $resp['message']);
		} else {
			$resp['status'] = 'failed';
			$resp['message'] = "Error: " . $this->conn->error;
			error_log("SQL Error: " . $this->conn->error);
		}
	
		return json_encode($resp);
		exit;
	}
	
	

	public function work_delete(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM work where id = $id");
		if($qry){
			$resp['status']='success';
			$resp['message']= " Work Details successfully deleted";
			$this->settings->set_flashdata('success',$resp['message']);
		}
	}

	public function project() {
		// Enable error reporting for debugging, remove in production
		error_reporting(E_ALL);
		ini_set('display_errors', 0); // Don't display errors directly to avoid breaking JSON
		
		try {
			extract($_POST);
			$data = "";
			
			// Handle text fields first
			foreach($_POST as $k => $v) {
				if(!in_array($k, array('id', 'description', 'summary', 'existing_video_url'))) {
					if(!empty($data)) $data .= ", ";
					// Use mysqli_real_escape_string for better SQL injection protection
					$v = $this->conn->real_escape_string($v);
					$data .= "`$k` = '$v'";
				}
			}
			
			// Handle description and summary separately
			if(!empty($data)) $data .= ", ";
			$description = $this->conn->real_escape_string($description);
			$summary = $this->conn->real_escape_string($summary);
			$data .= "`description` = '$description'";
			$data .= ", `summary` = '$summary'";
			
			// Handle banner image upload
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
				$upload_dir = '../uploads/';
				if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
				
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], '../'.$fname);
				if($move) {
					$data .= ", `banner` = '$fname'";
				} else {
					throw new Exception("Failed to upload image: " . error_get_last()['message']);
				}
			}
			
			// Handle video upload
			if(isset($_FILES['video_file']) && $_FILES['video_file']['tmp_name'] != '') {
				$video_path = 'uploads/videos/';
				if(!is_dir('../'.$video_path)) mkdir('../'.$video_path, 0777, true);
				
				$video_name = $video_path.time().'_'.$_FILES['video_file']['name'];
				$video_move = move_uploaded_file($_FILES['video_file']['tmp_name'], '../'.$video_name);
				if($video_move) {
					$data .= ", `video_url` = '$video_name'";
				} else {
					throw new Exception("Failed to upload video: " . error_get_last()['message']);
				}
			}
			
			// Build and execute SQL query
			if(empty($id)) {
				$sql = "INSERT INTO project SET $data";
			} else {
				$id = (int)$id; // Ensure ID is an integer for security
				$sql = "UPDATE project SET $data WHERE id = $id";
			}
			
			$save = $this->conn->query($sql);
			
			if($save) {
				$action = empty($id) ? "added" : "updated";
				$resp = array(
					'status' => 'success',
					'message' => "Project details successfully $action"
				);
				$this->settings->set_flashdata('success', $resp['message']);
			} else {
				$resp = array(
					'status' => 'failed',
					'message' => "Database error: " . $this->conn->error,
					'sql' => $sql
				);
			}
			
			// Always return clean JSON
			header('Content-Type: application/json');
			echo json_encode($resp);
			exit;
			
		} catch (Exception $e) {
			header('Content-Type: application/json');
			echo json_encode(array(
				'status' => 'failed',
				'message' => $e->getMessage()
			));
			exit;
		}
	}

	public function blog(){
		ob_clean(); // clear buffer
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','description','reference_links'))){
				if(!empty($data)) $data .= ", ";
				$v = $this->conn->real_escape_string($v); // Add proper escaping
				$data .= "`$k` = '$v'";
			}
		}
		if(!empty($data)) $data .= ", ";
		$data .= "`description` = '".addslashes(htmlentities($description))."'";
		$data .= ", `reference_links` = '".addslashes($reference_links)."'";
	
		// Handle blog image upload
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/'.strtotime(date('Y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if($move){
				$data .= ", img = '{$fname}'";
			}
		}
	
		if(empty($id)){
			$sql = "INSERT INTO blogs SET $data";
		} else {
			$id = intval($id); // Make sure ID is an integer
			$sql = "UPDATE blogs SET $data WHERE id = {$id}";
		}
	
		$save = $this->conn->query($sql);
		$action = empty($id) ? "added" : "updated";
	
		if($save){
			$resp['status'] = 'success';
			$resp['message'] = "Blog successfully {$action}";
			$this->settings->set_flashdata('success', $resp['message']);
		}
		else {
			$resp['status'] = 'failed';
			$resp['message'] = "Error: " . $this->conn->error;
		}
		echo json_encode($resp);
		// Remove the return statement or use just one of either echo or return
		exit;
	}
	public function contact(){
		extract($_POST);
		$data = "";
		foreach ($_POST as $key => $value) {
			if(!empty($data)) $data .= ", ";
				$data .= "('{$key}','{$value}')";
		}
		$this->conn->query("TRUNCATE `contacts`");
		$sql = "INSERT INTO `contacts` (meta_field, meta_value) Values $data";
		$qry = $this->conn->query($sql);
		if($qry){
			$resp['status']='success';
			$resp['message']= " Contact Details successfully updated";
			$this->settings->set_flashdata('success',$resp['message']);
		}else{
			$resp['status']='error';
			$resp['message']= $sql;
		}
		return json_encode($resp);
		exit;
	}

	
	
}

$Content = new Content();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update':
		echo $Content->update();
	break;
	case 'education':
		echo $Content->education();
	break;
	case 'education_delete':
		echo $Content->education_delete();
	break;
	case 'work':
		echo $Content->work();
	break;
	case 'work_delete':
		echo $Content->work_delete();
	break;
	case 'project':
		echo $Content->project();
	break;
	case 'project_delete':
		echo $Content->project_delete();
	break;
	case 'contact':
		echo $Content->contact();
	break;
	case 'blog':
		echo $Content->blog();
	break;
	default:
		// echo $sysset->index();
		break;
}