<?php

/*
  Plugin Name: AloniDev Toolkit
  Plugin URI: http://www.alonidev.com
  Version: 1.7.0
  Author: Guy Aloni
  Text Domain: alonidevtoolkit
 */

$plugin_vars = [
	'namespace' => 'AloniDevToolkit',
	'info_url' => 'http://alonidev.com/',
	'remote_package_url' => 'https://github.com/guyaloni912/alonidev-toolkit/archive/refs/heads/release.zip',
	'remote_root_file_url' => 'https://raw.githubusercontent.com/guyaloni912/alonidev-toolkit/release/alonidev-toolkit.php'
];

spl_autoload_register(function ($class_name) use ($plugin_vars) {
	if (stripos($class_name, $plugin_vars["namespace"] . '\\') === 0) {
		include __DIR__ . "/" . str_replace('\\', '/', $class_name) . '.php';
	}
});

add_filter('pre_set_site_transient_update_plugins', function ($transient) use ($plugin_vars) {
	$current_version = get_file_data(__FILE__, ['version'])[0];
	$new_version = get_file_data($plugin_vars["remote_root_file_url"], ['version'])[0];
	if (version_compare($current_version, $new_version) < 0) {
		$obj = new stdClass();
		$obj->slug = basename(__FILE__);
		$obj->new_version = $new_version;
		$obj->url = $plugin_vars["info_url"];
		$obj->package = $plugin_vars["remote_package_url"];
		$transient->response[basename(__DIR__) . '/' . basename(__FILE__)] = $obj;
	}
	return $transient;
});

//////////////////////////


use AloniDevToolkit\Services\ComingSoonService;
use AloniDevToolkit\Services\RequestHandlerService;
use AloniDevToolkit\Services\ShortcodeService;

ComingSoonService::init_service(__DIR__);
RequestHandlerService::init_service();
ShortcodeService::init_service();
