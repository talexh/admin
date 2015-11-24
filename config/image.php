<?php

return array(
	'sizes' => array(
		'original'	=> array(),
		'destination'    => array('width' => 500, 'height'=>'auto'),
		'thumb'    => array('width' => 300, 'height'=>'auto'),
		'crop'	=> array('width' => 200, 'height'=>150),
	),
	'others' => array(
			'original'	=> array(),
			'thumb'    => array('width' => 300, 'height'=>'auto'),
	),
	'upload_path' => public_path() .'/uploads/',
	'media_upload_path' => public_path() .'/uploads/media',
	'other_upload_path' => public_path() .'/uploads/other',
	'appfolder' => public_path() .'/appsdata/',
);
