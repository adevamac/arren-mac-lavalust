<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Auth extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->call->helper(array('form', 'alert'));
		$this->call->model(array('auth_model', 'admin_model'));
		$this->call->library('form_validation');
	}


	public function index()
	{
		if ($this->session->userdata('loggedin') == 1) {
			redirect('dashboard');
		} else {
			$this->call->view('auth/login');
		}
	}

	public function signup()
	{
		$this->call->view('auth/signup');
	}

	public function login()
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('email')->required()
				->valid_email()
				->name('password')->required();
			if ($this->form_validation->run()) {
				$email = $this->io->post('email', TRUE);
				$password = $this->io->post('password', TRUE);

				$validate = $this->auth_model->login($email, $password);

				if ($validate == 'none') {
					set_flash_alert('danger', 'Sorry, we could not find your account.');
					redirect('');
					exit();
				}
				if ($validate != false) {
					$check_validity = $this->auth_model->check_validation_status($email);
					if ($check_validity != true) {
						$id = $validate['id'];
						$f_name = $validate['f_name'];
						$user_avatar = $validate['user_avatar'];
						$user_type = $validate['user_type'];
						// Set user session
						$this->auth_model->set_logged_in_session($id,  $f_name, $user_avatar, $user_type);
						setcookie(time() + 3600, "/");
						redirect('dashboard');
						exit();
					} else {
						$data['email'] = $email; // Store email for verification
						$this->call->view('auth/verification', $data);
					}
				} else {
					set_flash_alert('danger', 'Username or Password is wrong.');
					redirect('');
					exit();
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('');
				exit();
			}
		}
	}

	public function page()
	{
		if ($this->auth_model->is_logged_in()) {
			if ($this->session->userdata('user_type') == 'admin') {
				// Fetch data from the model
				$data['gender_distribution'] = $this->admin_model->get_gender_distribution();
				$data['civil_status_distribution']  = $this->admin_model->get_civil_status_distribution();
				$data['age_distribution'] = $this->admin_model->get_age_distribution();
				$data['occupation_status_distribution'] = $this->admin_model->get_occupation_status_distribution();
				$data['street_sitio_distribution'] = $this->admin_model->get_street_sitio_distribution();
				$data['age_civil_status_distribution'] = $this->admin_model->get_age_civil_status_distribution(); // New data

				// Load the view and pass the data
				$this->call->view('admin/index', $data);
			} elseif ($this->session->userdata('user_type') == 'client') {
				$this->call->view('client/index');
			} else {
				$this->call->view('errors/error_404');
			}
		} else {
			redirect('');
		}
	}





	public function verify_account()
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('email')->required()
				->valid_email()
				->name('code')->required();

			if ($this->form_validation->run()) {
				$email    = $this->io->post('email', TRUE);
				$code = $this->io->post('code', TRUE);
				$verify = $this->auth_model->verify_account($email, $code);

				if ($verify != false) {
					set_flash_alert('success',  'Your Account is successfully verified. You can now login.');
					redirect('');
				} else {
					$data['email'] = $email;
					set_flash_alert('danger',  'Verification code is incorrect. Please try again.');
					$this->call->view('auth/verification', $data);
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('');
				exit();
			}
		}
	}


	public function resend_verification_token()
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('email')->required()
				->valid_email();

			if ($this->form_validation->run()) {
				$email    = $this->io->post('email', TRUE);
				$new_token = mt_rand(111111111, 999999999);
				$check_user = $this->auth_model->is_user_registered($email, $new_token);
				if ($check_user == 1) {
					$this->resend_code_to_email("$email", "$new_token");
					set_flash_alert('success',  'New Validation Code sent successfully.');
					redirect('');
				}
				if ($check_user == 'noRecord') {
					set_flash_alert('danger',  'Sorry,we could not find your acount');
					redirect('resend_token');
				}
				if ($check_user == 'error') {
					set_flash_alert('danger',  'Account Already verified.');
					redirect('');
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('resend_token');
				exit();
			}
		}
		$this->call->view('auth/resend_token');
	}



	public function resend_code_to_email($recipient, $code)
	{
		// Set the subject, sender, and recipient
		$this->email->subject('New Account Verification Code');
		$this->email->sender('noreply@irohBeats.com');
		$this->email->recipient($recipient);

		// Prepare data for the email template
		$data = array(
			'code' => $code
		);
		ob_start();
		$this->call->view('emails/resend_email_code', $data);
		$email_template = ob_get_clean();
		$this->email->email_content($email_template, 'html');
		$this->email->send();
	}



	public function register()
	{
		// Define form validation rules
		$this->form_validation
			->name('firstname')->required()
			->name('middlename')->required()
			->name('lastname')->required()
			->name('gender')->required()
			->name('dob')->required()
			->name('address')->required()
			->name('email')->required()->valid_email()
			->name('password')->required()->min_length(8)
			->name('repeat_password')->required()->matches('password');

		// Check if the form has been submitted
		if ($this->form_validation->submitted()) {
			if ($this->form_validation->run() == FALSE) {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('signup');
			} else {
				// Form is valid, proceed with registration
				$f_name = $this->io->post('firstname', TRUE);
				$m_name = $this->io->post('middlename', TRUE);
				$l_name = $this->io->post('lastname', TRUE);
				$suffix = $this->io->post('suffix', TRUE);
				$gender = $this->io->post('gender', TRUE);
				$dob = $this->io->post('dob', TRUE);
				$address = $this->io->post('address', TRUE);
				$email = $this->io->post('email', TRUE);
				$password = $this->io->post('password', TRUE);
				$verification_token = mt_rand(111111111, 999999999);

				// File upload logic
				$this->call->library('upload', $_FILES["fileToUpload"]);
				$this->upload
					->set_dir('public/uploads')
					->allowed_extensions(array('jpg'))
					->allowed_mimes(array('image/jpeg'))
					->is_image()
					->encrypt_name();

				// Attempt file upload
				if ($this->upload->do_upload()) {
					$user_avatar = $this->upload->get_filename();

					// Attempt to register the user
					if ($this->auth_model->register(
						$f_name,
						$m_name,
						$l_name,
						$suffix,
						$address,
						$dob,
						$gender,
						$email,
						$password,
						$verification_token,
						$user_avatar
					) == true) {
						// Success: User registered
						$this->send_email_code("$email", "$verification_token");
						set_flash_alert('success', 'Account Created Successfully. Please Login!');
						redirect('/');
					} else {
						// Registration failed: Delete uploaded file
						unlink('./public/uploads/' . $user_avatar);
						set_flash_alert('danger', 'Oops! Email or Username is already taken.');
						redirect('signup');
					}
				} else {
					// Handle upload errors
					$data['errors'] = $this->upload->get_errors();
					set_flash_alert('danger', 'File upload failed: ' . implode(", ", $data['errors']));
					redirect('signup');
				}
			}
		} else {
			redirect('signup');
		}
	}


	public function send_email_code($recipient, $code)
	{
		// Set the subject, sender, and recipient
		$this->email->subject('Account Verification');
		$this->email->sender('noreply@irohBeats.com');
		$this->email->recipient($recipient);

		// Prepare data for the email template
		$data = array(
			'code' => $code
		);
		ob_start();
		$this->call->view('emails/send_email_code', $data);
		$email_template = ob_get_clean();
		$this->email->email_content($email_template, 'html');
		$this->email->send();
	}



	public function forgot_password()
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('email')->required()
				->valid_email();

			if ($this->form_validation->run()) {
				$email    = $this->io->post('email', TRUE);
				$user_change_password = $this->auth_model->user_change_password($email);
				if ($user_change_password != false) {
					$email = $user_change_password['email'];
					$verify_token = $user_change_password['verify_token'];
					$this->reset_password_link("$email", "$verify_token");
					set_flash_alert('success', 'Password Reset Link sent successfully.');
					redirect('');
				} else {
					set_flash_alert('danger', 'Sorry,we could not find your acount.');
					redirect('forgot_password');
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('forgot_password');
				exit();
			}
		} else {
			$this->call->view('auth/forgot_password');
		}
	}

	private function reset_password_link($recipient, $token)
	{
		// Set the subject, sender, and recipient
		$this->email->subject('Account Verification');
		$this->email->sender('noreply@irohBeats.com');
		$this->email->recipient($recipient);
		// Prepare data for the email template
		$data = array(
			'link' => (BASE_URL . 'change_password/'  . $token),
		);
		ob_start();
		$this->call->view('emails/forgot_password_email', $data);
		$email_template = ob_get_clean();
		$this->email->email_content($email_template, 'html');
		$this->email->send();
	}


	public function change_password($token)
	{
		if ($this->form_validation->submitted()) {
			$this->form_validation
				->name('password')->required()->min_length(8)
				->name('repeat_password')->required()->matches('password');

			if ($this->form_validation->run()) {
				$password = $this->io->post('password', TRUE);

				$complete_change_password = $this->auth_model->complete_change_password($token, $password);
				if ($complete_change_password != false) {
					set_flash_alert('success', 'New Password Successfully Updated.');
					redirect('');
				} else {
					set_flash_alert('success', 'Invalid Token.Did not update.Something went Wrong.');
					redirect('forgot_password');
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
				redirect('change_password/' . $token);
			}
		} else {
			$data = array(
				'token' => $token,
			);
			$this->call->view('auth/change_password', $data);
		}
	}


	public function logout()
	{
		if (isset($_COOKIE["type"])) :
			setcookie(time() - 3600, "/");
		endif;
		$this->session->unset_userdata(array('loggedin', 'email', 'user_avatar'));
		$this->session->sess_destroy();
		redirect('');
	}
}
