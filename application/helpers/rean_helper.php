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
  function kelas($id)
  {
    $CI =& get_instance();
    return $CI->db->get_where('kelas',['id' => $id])->row()->nama;
  }
  
  /**
   * Helper untuk mengambil data seling dengan id
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function seling($id,$prev)
  {
    $CI =& get_instance();
    return $CI->db->get_where('seling',['id' => $id])->row()->$prev;
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
