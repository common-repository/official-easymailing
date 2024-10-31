<?php

return
[
	[
		'menu_slug' => 'easymailing_configuration',
		'parent_slug' => null,
		'action' => "Easymailing\\App\\Controller\\Admin\\ConfigurationController::indexAction",
		'page_title' => __( 'Configuración', 'easymailing' ),
		'menu_title' => 'Easymailing',
		'capability' => 'administrator',
		'icon_url' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="48" viewBox="0 0 48 48">
			  <defs>
			    <clipPath id="clip-ico-logo-easymailing">
			      <rect width="48" height="48"/>
			    </clipPath>
			  </defs>
			  <g id="ico-logo-easymailing" clip-path="url(#clip-ico-logo-easymailing)">
			    <g id="Grupo_6343" data-name="Grupo 6343" transform="translate(13638.999 7034.507)">
			      <g id="Grupo_6342" data-name="Grupo 6342" transform="translate(-13638.999 -7031.507)">
			        <path id="Trazado_1" data-name="Trazado 1" d="M-588.98,157.742V138.276c0-2.292-2.522-4.15-5.637-4.15s-5.637,1.858-5.637,4.15V164.8a3.082,3.082,0,0,0,.043.5C-599.481,165.252-589.312,166.308-588.98,157.742Z" transform="translate(600.253 -131.948)" fill="#38afbd"/>
			        <path id="Trazado_2" data-name="Trazado 2" d="M-507.879,157.742V138.276c0-2.292,2.523-4.15,5.637-4.15s5.637,1.858,5.637,4.15V164.8a3.079,3.079,0,0,1-.043.5C-497.377,165.252-507.547,166.308-507.879,157.742Z" transform="translate(544.605 -131.948)" fill="#38afbd"/>
			        <path id="Trazado_3" data-name="Trazado 3" d="M-553.975,130.057a6.131,6.131,0,0,0-7.969.125l-14.188,13.11h-.052l-14.442-12.885a6.126,6.126,0,0,0-7.971,0,4.653,4.653,0,0,0,0,7.112l16.708,14.908v14.321c0,2.292,2.525,4.15,5.637,4.15s5.637-1.857,5.637-4.15V152.675l16.779-15.5A4.655,4.655,0,0,0-553.975,130.057Z" transform="translate(600.252 -128.647)" fill="#28d6d6"/>
			      </g>
			    </g>
			  </g>
			</svg>
			'),
		'position' => 110,
		'show_in_menu' => true,
	],
	[
		'menu_slug' => 'easymailing_configuration',
		'parent_slug' => 'easymailing_configuration',
		'action' => "Easymailing\\App\\Controller\\Admin\\ConfigurationController::indexAction",
		'page_title' => __( 'Configuración', 'easymailing' ),
		'menu_title' => __( 'Configuración', 'easymailing' ),
		'capability' => 'administrator',
		'position' => 10,
		'show_in_menu' => true,
	],
	[
		'menu_slug' => 'easymailing_forms',
		'parent_slug' => 'easymailing_configuration',
		'action' => "Easymailing\\App\\Controller\\Admin\\FormController::indexAction",
		'page_title' => __( 'Formularios', 'easymailing' ),
		'menu_title' => __( 'Formularios', 'easymailing' ),
		'capability' => 'administrator',
		'position' => 10,
		'show_in_menu' => true,

	],
	[
		'menu_slug' => 'easymailing_forms_popup',
		'parent_slug' => 'easymailing_configuration',
		'action' => "Easymailing\\App\\Controller\\Admin\\FormController::popupAction",
		'page_title' => __( 'Formulario Popup', 'easymailing' ),
		'menu_title' => __( 'Formularios Popup', 'easymailing' ),
		'capability' => 'administrator',
		'position' => 20,
		'show_in_menu' => false,
	],
	[
		'menu_slug' => 'easymailing_forms_embedded',
		'parent_slug' => 'easymailing_configuration',
		'action' => "Easymailing\\App\\Controller\\Admin\\FormController::embeddedAction",
		'page_title' => __( 'Formulario Incrustado', 'easymailing' ),
		'menu_title' => __( 'Formularios Incrustado', 'easymailing' ),
		'capability' => 'administrator',
		'position' => 20,
		'show_in_menu' => false,

	]
];


//add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
