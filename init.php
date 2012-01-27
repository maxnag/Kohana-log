<?php

Route::set('log_download', 'log/download(/<date>)', array(
		'date' => '\d{2}.\d{2}.\d{4}',
	))
	->defaults(array(
		'controller' => 'log',
		'action' => 'download',
));

Route::set('log', 'log(/<date>)', array(
		'date' => '\d{2}.\d{2}.\d{4}',
	))
	->defaults(array(
		'controller' => 'log',
		'action' => 'view',
));
