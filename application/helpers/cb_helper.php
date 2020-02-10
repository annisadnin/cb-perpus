<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        // mengambil role id agar dibatasi oleh hak access
        $menu = $ci->uri->segment(1);
        // uri atas menunjukan admin/user
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        // mengambil id menu di usermenu
        $menu_id = $queryMenu['id'];
        $useraccess = $ci->db->get_where(
            'user_access_menu',
            [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ]
        );
    }
    if (!$useraccess->num_rows() > 1) {
        //untuk mengeblock hak access
        redirect('auth/blocked');
    }
}
function check_access($role_id, $id)
{
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        //untuk mengeblock hak access
        return "checked='checked'";
    }
}
