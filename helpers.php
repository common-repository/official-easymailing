<?php

if (!function_exists('easymailing_plugin_directory')){
	/**
	 * Gets the plugin directory.
	 *
	 * @return string
	 */
	function easymailing_plugin_directory()
	{
		return plugin_dir_path( __FILE__ );
	}
}
