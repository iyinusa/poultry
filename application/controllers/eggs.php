<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eggs extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		$this->load->library('image_lib'); //load image library
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($this->session->userdata('logged_in')==FALSE){ 
			redirect(base_url().'login/', 'location');
		}
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->user->query_rec_single('id', $get_id, 'bz_egg');
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_branch_id'] = $item->branch_id;
				$data['e_qty'] = $item->qty;
				$data['e_reg_date'] = $item->reg_date;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			if($this->user->delete_rec('id', $del_id, 'bz_egg') > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5>Deleted</h5></div>';
			} else {
				$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
			}
		}
		
		//check if ready for post
		if($_POST){
			$egg_id = $_POST['egg_id'];
			$branch_id = $_POST['branch_id'];
			$qty = $_POST['qty'];
			$reg_date = $_POST['reg_date'];
			
			$now = date('j M Y H:ma');
			
			//check for update
			if($egg_id != ''){
				$upd_data = array(
					'branch_id' => $branch_id,
					'qty' => $qty,
					'reg_date' => $reg_date
				);
				
				if($this->user->update_rec('id', $egg_id, 'bz_egg', $upd_data) > 0){
					$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>No Changes Made</h5></div>';
				}
			} else {
				$reg_data = array(
					'branch_id' => $branch_id,
					'qty' => $qty,
					'reg_date' => $reg_date
				);
				
				if($this->user->reg_rec('bz_egg', $reg_data) > 0){
					$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
				}
			}
		}
		
		//query uploads
		$data['allup'] = $this->user->query_rec('bz_egg');
		$data['allbranch'] = $this->user->query_rec('bz_branch');
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Egg';
		$data['page_act'] = 'egg';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('egg', $data);
	  	$this->load->view('designs/footer', $data);
	}
}