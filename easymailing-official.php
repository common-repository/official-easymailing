<?php
/**
 * Plugin Name: Official Easymailing
 * Plugin URI: https://github.com/easymailing/wordpress-plugin
 * Description: Official Easymailing plugin for integrate forms in WordPress
 * Version: 1.1.0
 * Author: Easymailing
 * Author URI: https://easymailing.com
 * Requires PHP: 7.1
 * Requires at least: 4.7.5
 * License: GPLv2 or later
 * Text Domain: easymailing
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

use Easymailing\App\Core\Activate;
use Easymailing\App\Core\Application;
use Easymailing\App\Core\Deactivate;


defined('ABSPATH') or die('You have not access to this file');

define( 'EASYMAILING_OFFICIAL_VERSION', '1.1.0' );

// Require once the Composer Autoload
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if (class_exists( 'Easymailing\\App\\Core\\Application')) {

	@require 'helpers.php';

	/**
	 * The code that runs during plugin activation
	 */
	function activate_easymailing_official_plugin() {
		Activate::activate();
	}
	register_activation_hook( __FILE__, 'activate_easymailing_official_plugin' );

	/**
	 * The code that runs during plugin activation
	 */
	function deactivate_easymailing_official_plugin() {
		Deactivate::deactivate();
	}
	register_deactivation_hook( __FILE__, 'deactivate_easymailing_official_plugin' );

	/**
	 * The code that runs during plugin uninstall
	 */
	function uninstall_easymailing_official_plugin() {
		Deactivate::uninstall();
	}
	register_uninstall_hook( __FILE__, 'uninstall_easymailing_official_plugin' );




	/**
	 * Boot the plugin
	 */
	$app = Application::getInstance();
	$app->boot(easymailing_plugin_directory(), 'production');

}
