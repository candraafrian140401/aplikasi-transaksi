<?php

class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if($this->session->login) redirect('dashboard');
		$this->load->model('M_customer', 'm_customer');
		$this->load->model('M_pengguna', 'm_pengguna');
	}

	public function index(){
		$this->load->view('login');
	}

	public function proses_login(){
		if($this->input->post('role') === 'customer') $this->_proses_login_customer($this->input->post('username'));
		elseif($this->input->post('role') === 'admin') $this->_proses_login_admin($this->input->post('username'));
		else {
			?>
			<script>
				alert('role tidak tersedia!')
			</script>
			<?php
		}
	}

	protected function _proses_login_customer($username){
		$get_customer = $this->m_customer->lihat_username($username);
		if($get_customer){
			if($get_customer->password_customer == $this->input->post('password')){
				$session = [
					'kode' => $get_customer->kode_customer,
					'nama' => $get_customer->nama_customer,
					'username' => $get_customer->username_customer,
					'password' => $get_customer->password_customer,
					'role' => $this->input->post('role'),
					'jam_masuk' => date('H:i:s')
				];

				$this->session->set_userdata('login', $session);
				$this->session->set_flashdata('success', '<strong>Login</strong> Berhasil!');
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Password Salah!');
				redirect();
			}
		} else {
			$this->session->set_flashdata('error', 'Username Salah!');
			redirect();
		}
	}

	protected function _proses_login_admin($username){
		$get_pengguna = $this->m_pengguna->lihat_username($username);
		if($get_pengguna){
			if($get_pengguna->password_pengguna == $this->input->post('password')){
				$session = [
					'kode' => $get_pengguna->kode_pengguna,
					'nama' => $get_pengguna->nama_pengguna,
					'username' => $get_pengguna->username_pengguna,
					'password' => $get_pengguna->password_pengguna,
					'role' => $this->input->post('role'),
					'jam_masuk' => date('H:i:s')
				];

				$this->session->set_userdata('login', $session);
				$this->session->set_flashdata('success', '<strong>Login</strong> Berhasil!');
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Password Salah!');
				redirect();
			}
		} else {
			$this->session->set_flashdata('error', 'Username Salah!');
			redirect();
		}
	}
}