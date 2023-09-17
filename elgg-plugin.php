<?php

return [
	'plugin' => [
		'name' => 'Users Online',
		'version' => '4.3.0',
	],
	'bootstrap' => \UsersOnlineBootstrap::class,
	'settings' => [
		'user_listing_limit' => 20,
		'display_option' => 'top',
		'show_admins' => 'yes',
	],
	'view_extensions' => [
		'css/elgg' => [
			'users_online/css' => [],
		],
	],
];
