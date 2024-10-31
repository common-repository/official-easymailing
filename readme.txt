=== Official Easymailing ===
Contributors: easymailing
Tags: easymailing, newsletter, email marketing, form, lead magnet, subscription form, web form, subscribe, elementor
Donate link: https://easymailing.com
Requires at least: 4.7.5
Tested up to: 6.4.3
Requires PHP: 7.1
Stable tag: 1.1.0
License: GPL 2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add subscription forms created in Easymailing to your WordPress site, now with Elementor integration.

== Description ==
This plugin allows you to add subscription forms created in Easymailing within your WordPress website. You can grow your audience in a simple way, and now with Elementor integration, it's even easier to create beautiful subscription forms.

To be able to configure the plugin, you need an API key that you can get inside the Easymailing control panel, in "Configuration" > "API key".

If you don't have an Easymailing account yet, you can create one at https://easymailing.com/signup.

For additional information on how to configure the plugin, including integration with WordPress, visit our help center at https://ayuda.easymailing.com/hc/es/articles/360018193498-Integración-con-WordPress.

== Installation ==

= Method 1 =

1. Login to your WordPress admin panel.
2. Open Plugins in the left sidebar, click Add New, and search for the Easymailing plugin.
3. Install the plugin and activate it.

= Method 2 =

1. Download the Easymailing plugin.
2. Unzip the downloaded file and upload it to your /wp-content/plugins/ folder.
3. Activate the plugin in the WordPress admin panel.

= How to add an Easymailing form =

1. After successful installation, you will see the Easymailing icon on the left sidebar. Click it.
2. Enter your Easymailing API key.
3. Click "Forms" on the left sidebar to start adding your subscription forms to posts and pages. You can also choose the popup form for your site .

= How to Integrate Easymailing with Elementor Forms =

1. After successful installation, you will see the Easymailing icon on the left sidebar. Click it.
2. Enter your Easymailing API key.
3. Build your form in elementor adding a form widget
4. Add action "EasyMailing" in "Action After Submit" section
5. Choose "EasyMailing" section and setup audience, groups and map custom fields

== Frequently Asked Questions ==

= Requirements =

* Requires PHP7.1

= What is the plugin license? =

* This plugin is released under a GPL license.

= What is Easymailing? =

Easymailing is an email marketing platform. You can create and send email newsletters, manage subscribers, and track and analyze results.

= Where can I see more information? =

You can get help at https://ayuda.easymailing.com.


== Screenshots ==

1. Setup
2. Select form
3. Popup form
4. Embedded form
5. Add form in Gutenberg
6. Elementor integration

== Changelog ==
= 1.1.0 =
* New: Add Elementor form action integration. Now you can easily integrate your Easymailing forms with Elementor.
* Fix: Various bug fixes and improvements.

= 1.0.8 =
* Fix: An error when plugin configuration saved in wp_options is not correct
* Add: Delete plugin configuration saved in wp_options when the plugin is uninstalled

= 1.0.7 =
* Fix: set form in Gutemberg block
* Fix: Refactor some Core classes
* Add: Environment production and development

= 1.0.6 =
* Fix: session_start warning in site health

= 1.0.5 =
* Fix: Prevent error when not saved APikey and try to add a form
* Fix: Embedded forms not filtering correctly by audience

= 1.0.4 =
* Fix: Fix version Requires at least

= 1.0.3 =
* Fix: Fix some typos

= 1.0.2 =
* Added: English translations
* Fix: Javascript not included when not selecting a popup form

= 1.0.1 =
* Added: Wordpress.org assets

= 1.0.0 =
* First release


