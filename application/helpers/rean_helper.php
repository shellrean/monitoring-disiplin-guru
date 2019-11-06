<?php
  /** --------------------------------------
   * Shellrean Kuswandi
   * 2019
   ** ------------------------------------- **/

  /**
   * Helper untuk membuat flash message sukses
   * @param  string $name
   * @param  string $text
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function alertsuccess($name,$text) {
    $CI =& get_instance();
    $alert = ' 
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    '.$text.'
    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    ';
    return $CI->session->set_flashdata($name,$alert);
  }

  /**
   * Helper untuk membuat flash message error
   * @param  string $name
   * @param  string $text
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function alerterror($name,$text) {
    $CI =& get_instance();
    $alert = ' 
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    '.$text.'
    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    ';
    return $CI->session->set_flashdata($name,$alert);
  } 
  /**
   * Helper untuk mengambil menu sesuai dengan role id
   * @param integer $role
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function menus($role) 
  {
    $CI =& get_instance();
    $main_menu = $CI->db->get_where('menus', ['is_main_menu' => 0, 'role' => $role])->result();
    if(!$main_menu) {
      return '<i>Menu belum tersedia</i>';
    }
    foreach ($main_menu as $main) {
      $submenu = $CI->db->get_where('menus', ['is_main_menu' => $main->id]);
      if ($submenu->num_rows() > 0) {
          $menu = '
          <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon ' . $main->icon . '"></i>' . $main->title . '
          </a>
          <ul class="nav-dropdown-items">';
          
          foreach ($submenu->result() as $sub) {
              $menu .='
              <li class="nav-item">
                <a class="nav-link" href="'.base_url() . $sub->link . '">
                  <i class="nav-icon ' . $sub->icon . '"></i> ' . $sub->title . '
                </a>
              </li>';
          }
          $menu .='</ul></li>';
      
      } else {
        $menu .= '
        <li class ="nav-item ">
          <a class="nav-link" href="'.base_url(). $main->link . '">
            <i class="nav-icon ' . $main->icon . '" ></i>' . $main->title . '
          </a>
        </li>';
      }
    }

    return $menu;
  }

  /**
   * Helper untuk mengecek apakah user sudah login
   * @return boolean
   * @author Kuswandi <wandinak17@gmail.com>
   */ 
  function is_login()
  {
    $CI =& get_instance();
    if (!$CI->session->has_userdata('user_unapp_identifer') && !$CI->session->has_userdata('username') ) {
      redirect('auth');
    }
  }

  /**
   * Helper untuk mengambil seluruh data yang login
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function user()
  {
    $CI =& get_instance();
    return $CI->db->get_where('user',['username' => $CI->session->userdata('username')])->row();

  }
  
  /**
   * Helper untuk mengambil data kelas dengan id
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function kelas($id,$attr="nama")
  {
    $CI =& get_instance();
    return $CI->db->get_where('kelas',['id' => $id])->row()->$attr;
  }
  
  /**
   * Helper untuk mengambil data kelas dengan id
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function guru($id,$attr='nama')
  {
    $CI =& get_instance();
    return $CI->db->get_where('guru',['id' => $id])->row()->$attr;
  }
  /**
   * Helper untuk mengambil data seling dengan id
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function seling($id,$prev)
  {
    $CI =& get_instance();
    $res = $CI->db->get_where('seling',['id' => $id])->row();
    if ($res) {
      return $res->$prev;
    }
    else {
      return '<i>Data dihapus</i>';
    }
  }

  /**
   * Helper untuk mengambil nama hari
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function hari($id)
  {
    $CI =& get_instance();
    return $CI->db->get_where('hari',['id' => $id])->row()->nama;
  }
  /**
   * Helper untuk mengambil nama sekolah
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function sekolah($id,$attr="nama_sekolah")
  {
    $CI =& get_instance();
    return $CI->db->get_where('sekolah',['id' => $id])->row()->$attr;
  }

  function status($id)
  {
    if($id == '1') {
      $badge = '<span class="badge badge-success">Aktif</span>';
    }
    else {
      $badge = '<span class="badge badge-danger">Tidak aktif</span>';
    } 
    return $badge;
  }

  function todate($date) 
  {
    $time = strtotime($date);
    $newformat = date('d/m/Y',$time);

    return $newformat;
  }

   function log_akses($user_id,$status,$code) 
  {
    // 2 error 
    // 1 success
    $CI =& get_instance();
    $CI->db->insert('log_akses',['user_id' => $user_id, 'status' => $status,'code' => $code]);
    return true;
  }
