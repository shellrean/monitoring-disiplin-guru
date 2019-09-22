<?php

$config['auth'] = [
	[
		'field' => 'username',
		'label'	=> 'username',
		'rules' => 'required'
	],
	[
		'field' => 'password',
		'label'	=> 'password',
		'rules' => 'required'
	]
];

$config['sekolah/tambah'] = [
	[
		'field' => 'nama_sekolah',
		'label'	=> 'nama sekolah',
		'rules' => 'required'
	],
	[
		'field' => 'alamat_sekolah',
		'label'	=> 'alamat sekolah',
		'rules' => 'required'
	]
];

$config['user'] = [
	[
		'field' => 'sekolah_id',
		'label'	=> 'id sekolah',
		'rules' => 'required'
	],
	[
		'field' => 'username',
		'label'	=> 'user login',
		'rules' => 'required'
	],
	[
		'field' => 'password',
		'label'	=> 'password login',
		'rules' => 'required'
	],
	[
		'field' => 'name',
		'label'	=> 'nama',
		'rules' => 'required'
	],
	[
		'field' => 'is_active',
		'label'	=> 'status',
		'rules' => 'required'
	],

];

$config['guru/tambah'] = [
	[
		'field'	=> 'nip',
		'label'	=> 'nip',
		'rules'	=> 'required'
	],
	[
		'field'	=> 'nama',
		'rules'	=> 'required'
	]
];