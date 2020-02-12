<?php
defined('BASEPATH') or exit('No direct script access allowed');

class menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Menu Management'; //nama harus sama dengan sub menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'menu', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Menu !
          </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Submenu Management'; //nama harus sama dengan sub menu
        //harus membuat model karena membutuhkan menu dan tampil di submenu 
        $this->load->model('menu_model', 'menu'); // aliasnya menu
        $data['submenu'] = $this->menu->getsubmenu(); //menu disini artinya model
        $data['jummenu'] = $this->menu->jummenu(); //menghitung jumlah menu 
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('menu_id', 'menu', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data =
                [
                    'title' => $this->input->post('title'),
                    'menu_id' => $this->input->post('menu_id'),
                    'url' => $this->input->post('url'),
                    'is_active' => $this->input->post('is_active')
                ];
            $this->db->insert('user_sub_menu', $data);


            $this->session->set_flashdata('mes', '<div class="alert alert-success" role="alert">
            New Sub Menu !
          </div>');
            redirect('menu/submenu');
        }
    }
}
