<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| ----------------------------------------------------------
| Template library general
| CopyRight 2018-2019
| Author Kuswandi <wandinak17@gmail.com>
| ----------------------------------------------------------
*/

class Template
{
  /**
   * Propery menampung data array dari default view
   * @return array
   * @author kuswandi <wandinak17@gmail.com>
   */
  var $template_data = array();

  /**
  * Methodu untuk menambahkan variable yang di pakai di dalam view
  * @param string $name
  * @param string $value
  * @author kuswandi <wandinak17@gmail.com>
  */
  function set($name, $value)
  {
    $this->template_data[$name] = $value;
  }

  /**
   * Method untuk meload template
   * @param string $template
   * @param string $view
   * @param array $view_data
   * @author kuswandi <wandinak17@gmail.com>
   */
  function load($template = '', $view = '', $view_data = array(), $return = false)
  {
    $this->CI = &get_instance();
    $this->set('content_view', $this->CI->load->view($view, $view_data, true));
    return $this->CI->load->view($template, $this->template_data, $return);
  }
}
