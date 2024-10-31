<?php

return [
	'config_repository' => [
		'class' => \Easymailing\App\Repository\ConfigRepository::class,
		'arguments' => [
			'parameter_bag'
		],
	],
		'api_client' => [
		'class' => \Easymailing\App\Api\Client::class,
		'arguments' => [
			'parameter_bag', 'config_repository', 'hydrator'
		],
	],
		'hydrator' => [
		'class' => \Easymailing\App\Api\Hydrator::class,
		'arguments' => [

		],
	]
];
