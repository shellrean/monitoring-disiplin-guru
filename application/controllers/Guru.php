<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller 
{
	/** @var breadcrumb */
	private $breadcrumb;

	/**
     * GuruController constructor.
     *
     * @throws
     */
	public function __construct()
	{
		parent::__construct();

		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Data master</li>',
			'<li class="breadcrumb-item active">Data guru</li>'
		);
		$this->template->set('breadcrumb',$this->breadcrumb);
	}

	/**
	 * Show our dashboard for guru page
	 *
	 * @access public
	 */
	public function index()
	{
		$this->template->load('app','core/guru');
	}

	/**
	 * Insert data into table
	 *
	 * @method post
	 * @access public
	 * @return json
	 */
	public function store()
	{

	}

	/**
	 * Delete data from table
	 *
	 * @method post
	 * @access public
	 * @return json
	 */
	public function destroy()
	{

	}

	/**
	 * Show the selected row
	 *
	 * @method get ajax_request
	 * @param integer $id
	 * @return json
	 */
	public function show($id == null) 
	{

	}

	/**
	 * Get datatable 
	 *
	 * @method get ajax_request
	 * @return json
	 */
	public function data()
	{

	}

	








	

}