<?php

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->login['role'] != 'customer' && $this->session->login['role'] != 'admin') redirect();
		$this->data['aktif'] = 'dashboard';
		$this->load->model('M_barang', 'm_barang');
		$this->load->model('M_customer', 'm_customer');
		$this->load->model('M_penjualan', 'm_penjualan');
		$this->load->model('M_pengguna', 'm_pengguna');
		$this->load->model('M_toko', 'm_toko');
	}
	public function index(){
		$this->data['title'] = 'Halaman Dashboard';
		$this->data['jumlah_barang'] = $this->m_barang->jumlah();
		$this->data['jumlah_customer'] = $this->m_customer->jumlah();
		$this->data['jumlah_penjualan'] = $this->m_penjualan->jumlah();
		$this->data['jumlah_pengguna'] = $this->m_pengguna->jumlah();
		$this->data['toko'] = $this->m_toko->lihat();
		$this->load->view('dashboard', $this->data);
	}
}