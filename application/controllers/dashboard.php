<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		
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
		
		$data['count_feeds'] = 0;
		$data['count_livestock'] = 0;
		$data['count_mortality'] = 0;
		$data['count_eggs'] = 0;
		
		//count records
		$feedrec = $this->user->query_rec('bz_feed');
		$feedc = 0;
		if(!empty($feedrec)){
			foreach($feedrec as $rec){
				$feedc += $rec->qty;
			}
			$data['count_feeds'] = $feedc;
		}
		
		$liverec = $this->user->query_rec('bz_livestock');
		$livec = 0;
		if(!empty($liverec)){
			foreach($liverec as $rec){
				$livec += ($rec->healthy + $rec->unhealthy);
			}
			$data['count_livestock'] = $livec;
		}
		
		$morrec = $this->user->query_rec('bz_mortality');
		$morc = 0;
		if(!empty($morrec)){
			foreach($morrec as $rec){
				$morc += $rec->qty;
			}
			$data['count_mortality'] = $morc;
		}
		
		$eggrec = $this->user->query_rec('bz_egg');
		$eggc = 0;
		if(!empty($eggrec)){
			foreach($eggrec as $rec){
				$eggc += $rec->qty;
			}
			$data['count_eggs'] = $eggc;
		}
		
		$data['title'] = 'Dashboard';
		$data['page_act'] = 'dashboard';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('dashboard', $data);
	  	$this->load->view('designs/footer', $data);
	}
}