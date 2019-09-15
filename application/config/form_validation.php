<?php

$config['auth'] = [
	[
		'field' => 'username',
		'label'	=> 'Username',
		'rules' => 'required'
	],
	[
		'field' => 'password',
		'label'	=> 'Password',
		'rules' => 'required'
	]
];

$config['sekolah/tambah'] = [
	[
		'field' => 'nama_sekolah',
		'label'	=> 'Nama sekolah',
		'rules' => 'required'
	],
	[
		'field' => 'alamat_sekolah',
		'label'	=> 'Alamat sekolah',
		'rules' => 'required'
	]
];

$config['user'] = [
	[
		'field' => 'sekolah_id',
		'label'	=> 'ID Sekolah',
		'rules' => 'required'
	],
	[
		'field' => 'username',
		'label'	=> 'User login',
		'rules' => 'required'
	],
	[
		'field' => 'password',
		'label'	=> 'Password login',
		'rules' => 'required'
	],
	[
		'field' => 'name',
		'label'	=> 'Nama',
		'rules' => 'required'
	],
	[
		'field' => 'is_active',
		'label'	=> 'Status',
		'rules' => 'required'
	],

];