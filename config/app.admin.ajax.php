<?php

return [
	[
		'name' => 'easymailing_get_popup_forms',
		'action' => "Easymailing\\App\\Controller\\Admin\\AjaxController::getPopupFormsAction",
	],
	[
		'name' => 'easymailing_get_embeddedd_form',
		'action' => "Easymailing\\App\\Controller\\Admin\\AjaxController::getEmbeddedFormsAction",
	],
	[
		'name' => 'easymailing_get_audiences',
		'action' => "Easymailing\\App\\Controller\\Admin\\AjaxController::getAudiencesAction",
	],
	[
		'name' => 'easymailing_is_valid_api_key',
		'action' => "Easymailing\\App\\Controller\\Admin\\AjaxController::isApiKeyValidAction",
	]
];
