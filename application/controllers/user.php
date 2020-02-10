<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        // ambil data session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // if($this->form_validation->run()== false){
        $data['title'] = 'My Profile'; // nama harus sama dengan submenu
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index.php', $data);
        $this->load->view('templates/footer', $data);
        //}
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $uploadimage = $_FILES['image']['name'];
            if ($uploadimage) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_width'] = '2048';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    } //fcpath digunakan untuk mencari letak keberadaan file

                    $new = $this->upload->data('file_name');
                    $this->db->set('image', $new);
                } else {
                    echo $this->upload->display_errors();
                };
                // Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
                $this->upload->initialize($config);
            }
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            has been changed !
          </div>');
            redirect('user');
        }
    }

    public function changepassword()
    {
        // ambil data session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password'; // nama harus sama dengan submenu
        $this->form_validation->set_rules('currentpassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules(
            'newpassword1',
            'password',
            'required|trim|min_length[3]|matches[newpassword2]',
            ['matches' => 'password dont match!', 'min_length' => 'password to short']
        );
        $this->form_validation->set_rules('newpassword2', 'password', 'required|trim|min_length[3]|matches[newpassword1]');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword.php', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $currentpassword = $this->input->post('currentpassword');
            $newpassword = $this->input->post('newpassword1');
            if (!password_verify($currentpassword, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong current password! 
              </div>');
                redirect('user/changepassword');
            } else {
                if ($newpassword == $currentpassword) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                dont same with current password!
              </div>');
                    redirect('user/changepassword');
                } else {
                    $email = $this->session->userdata('email');
                    $pasword_hash = password_hash($newpassword, PASSWORD_DEFAULT);
                    $this->db->set('password', $pasword_hash);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password
                    has been changed !
                  </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
