<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->library('form_validation'); //load form validate rules
		$this->load->helper('captcha'); //load CAPTCHA library
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index($page='forgot')
	{
		if($this->session->userdata('logged_in') == TRUE){ 
			redirect(base_url(), 'location');
		}
		
		if ( ! file_exists(APPPATH.'views/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		$stamp = $this->input->get('stamp');
		$email = $this->input->get('email');
		
		if($stamp=='' || $email==''){
			//set form input rules 
			$this->form_validation->set_rules('email','Email Address','trim|required|valid_email|xss_clean');
			
			$this->form_validation->set_error_delimiters('<div id="pass-info" class="alert alert-danger">', '</div>'); //error delimeter
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['err_msg'] = '';
			}
			else
			{
				//check if ready for post
				if(isset($_POST['send'])) {
					$email = $_POST['email'];
					
					if($this->user->check_by_email($email) < 0) {
						$data['err_msg'] = '<h5 class="alert alert-danger">Email address not exist</h5>';
					} else {
						$time = time();
						
						$reg_data = array(
							'reset' => 1,
							'reset_stamp' => $time
						);
						
						//email notification processing
						$this->email->clear(); //clear initial email variables
						$this->email->to($email);
						$this->email->from('info@itcerebral.com','ITCerebral');
						$this->email->subject('Activate Email Address');
						
						//compose html body of mail
						$mail_stamp = $time;
						$mail_subhead = 'Password Reset';
						$body_msg = '
							You requested for password reset on ITCerebral.<br /><br />
							Click <a href="'.base_url().'forgot?stamp='.$mail_stamp.'&amp;email='.$email.'">Reset Password</a> to set new password<br /><br />Thanks
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {
							$data['err_msg'] = '<h5 class="alert alert-danger">Please check your Email Address for LINK to reset your password. (NB: Check SPAM if not in INBOX)</h5>';
													
							$this->user->activate($email, $reg_data); //update records
							
						} else {
							$data['err_msg'] = '<h5 class="alert alert-danger">Problem sending email this time. You will need to try again.</h5>';
						}
					}
				}
			}
		} else {
			//check activation link
			$ch = $this->user->check_reset($stamp, $email);
			if(empty($ch)){
				$data['err_msg'] = '<h5 class="alert alert-danger">Reset link already expired!</h5>';
			} else {
				//check if post else prepare reset
				//set form input rules 
				$this->form_validation->set_rules('new','New password','trim|required|min_length[4]|max_length[32]|xss_clean|md5');
				$this->form_validation->set_rules('confirm','Confirm password','trim|required|matches[new]|xss_clean');
				
				//error delimeter
				$this->form_validation->set_error_delimiters('<div id="pass-info" class="alert alert-danger">', '</div>');
				
				if ($this->form_validation->run() == FALSE){
					$data['err_msg'] = '';
				} else {
					//check if ready for post
					if(isset($_POST['change'])) {
						$new = $_POST['new'];
						$confirm = $_POST['confirm'];
						
						$update_data = array(
							'user_pass' => $new,
							'reset' => 0,
							'reset_stamp' => ''
						);
						
						if($this->user->activate($email, $update_data) > 0){
							$data['err_msg'] = '<h5 class="alert alert-info">Password reset. <a href="'.base_url().'login/">Sign In</a></h5>';
						} else {
							$data['err_msg'] = '<h5 class="alert alert-danger">There is problem this time. Try later</h5>';
						}
					}
				}
			}
		}
		
		$data['title'] = 'Reset Password | ITCerebral';
		
		$this->load->view('designs/header', $data);
		$this->load->view($page, $data);
		$this->load->view('designs/footer', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */