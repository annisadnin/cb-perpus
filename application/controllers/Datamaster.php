<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datamaster extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function kategoribarang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Kategori Barang'; //nama harus sama dengan sub menu
        $data['kategori_barang'] = $this->db->get('kategori_barang')->result_array();
        $this->form_validation->set_rules('Nama_kategori', 'Nama_kategori', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('Datamaster/kategoribarang.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->db->insert('kategori_barang', ['Nama_kategori' => $this->input->post('Nama_kategori')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Kategori Barang!
          </div>');
            redirect('Datamaster/kategoribarang');
        }
    }
    public function Supplier()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Supplier'; //nama harus sama dengan sub menu
        $data['supplier'] = $this->db->get('supplier')->result_array();
        $this->form_validation->set_rules('Nama', 'Nama', 'required');
        $this->form_validation->set_rules('Alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('Telp', 'Telp', 'required|trim|min_length[11]|max_length[13]');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('Datamaster/Supplier.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->db->insert(
                'supplier',
                [
                    'Nama' => $this->input->post('Nama'),
                    'Alamat' => $this->input->post('Alamat'),
                    'Telp' => $this->input->post('Telp')
                ]
            );
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Kategori Barang!
          </div>');
            redirect('Datamaster/Supplier');
        }
    }
    public function Barang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Barang'; //nama harus sama dengan sub menu
        $data['barang'] = $this->db->get('barang')->result_array();
        $this->form_validation->set_rules('Nama_barang', 'Nama_barang', 'required');
        $this->form_validation->set_rules('id_supplier', 'id_supplier', 'required');
        $this->form_validation->set_rules('stok', 'stok', 'required');
        $this->form_validation->set_rules('harga_beli', 'harga_beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'harga_jual', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('Datamaster/Barang.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->db->insert(
                'barang',
                [
                    'Nama_barang' => $this->input->post('Nama_barang'),
                    'id_supplier' => $this->input->post('id_supplier'),
                    'stok' => $this->input->post('stok'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'harga_jual' => $this->input->post('harga_jual')
                ]
            );
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Barang!
          </div>');
            redirect('Datamaster/Barang');
        }
    }
}
