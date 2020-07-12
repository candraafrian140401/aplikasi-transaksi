<?php

use Dompdf\Dompdf;

class Customer extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->login['role'] != 'customer' && $this->session->login['role'] != 'admin') redirect();
		$this->data['aktif'] = 'customer';
		$this->load->model('M_customer', 'm_customer');
	}

	public function index(){
		$this->data['title'] = 'Data Customer';
		$this->data['all_customer'] = $this->m_customer->lihat();
		$this->data['no'] = 1;

		$this->load->view('customer/lihat', $this->data);
	}

	public function tambah(){
		if ($this->session->login['role'] == 'customer'){
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Tambah Customer';

		$this->load->view('customer/tambah', $this->data);
	}

	public function proses_tambah(){
		if ($this->session->login['role'] == 'customer'){
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_customer' => $this->input->post('kode_customer'),
			'nama_customer' => $this->input->post('nama_customer'),
			'username_customer' => $this->input->post('username_customer'),
			'password_customer' => $this->input->post('password_customer'),
		];

		if($this->m_customer->tambah($data)){
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Ditambahkan!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Ditambahkan!');
			redirect('customer');
		}
	}

	public function ubah($id){
		if ($this->session->login['role'] == 'customer'){
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Ubah Customer';
		$this->data['customer'] = $this->m_customer->lihat_id($id);

		$this->load->view('customer/ubah', $this->data);
	}

	public function proses_ubah($id){
		if ($this->session->login['role'] == 'customer'){
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_customer' => $this->input->post('kode_customer'),
			'nama_customer' => $this->input->post('nama_customer'),
			'username_customer' => $this->input->post('username_customer'),
			'password_customer' => $this->input->post('password_customer'),
		];

		if($this->m_customer->ubah($data, $id)){
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Diubah!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Diubah!');
			redirect('customer');
		}
	}

	public function hapus($id){
		if ($this->session->login['role'] == 'customer'){
			$this->session->set_flashdata('error', 'Hapus data hanya untuk admin!');
			redirect('penjualan');
		}

		if($this->m_customer->hapus($id)){
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Dihapus!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Dihapus!');
			redirect('customer');
		}
	}

	public function export(){
		$dompdf = new Dompdf();
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$this->data['all_customer'] = $this->m_customer->lihat();
		$this->data['title'] = 'Laporan Data Customer';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('Customer/report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data Customer Tanggal ' . date('d F Y'), array("Attachment" => false));
	}
}