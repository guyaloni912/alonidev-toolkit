<?php

namespace AloniDevToolkit\Services {

	class ComingSoonService {

		private static $enable_coming_soon = false;
		private static $current_url = "";
		private static $redirect_url = "";
		private static $passthrough_parameter = "";

		public static function init_service($plugin_root_dir) {
			if (!function_exists('acf_add_options_page')) return;
			acf_add_options_page(['page_title' => 'AloniDev Toolkit', 'post_id' => 'alonidev-toolkit']);
			add_filter('acf/settings/load_json', function ($paths) use ($plugin_root_dir) {
				$paths[] = $plugin_root_dir . '/acf-json';
				return $paths;
			});
			add_action('init', function () {
				self::do_coming_soon();
			});
		}

		public static function do_coming_soon() {
			self::$enable_coming_soon = get_field("enable_coming_soon", "alonidev-toolkit");
			if (self::$enable_coming_soon) {
				self::$current_url = self::get_current_url();
				self::$redirect_url = self::get_redirect_url();
				self::$passthrough_parameter = get_field("passthrough_parameter", "alonidev-toolkit");

				if (!isset($_COOKIE["passthrough"])) {
					setcookie('passthrough', "false", 0, "/");
				}
				if (self::is_safe() == false) {
					header("Location: " . self::$redirect_url);
					exit();
				}
			}
		}

		private static function is_safe() {
			$query_string = $_SERVER['QUERY_STRING'];
			if (!empty(self::$passthrough_parameter) && strstr($query_string, self::$passthrough_parameter) !== false) {
				setcookie('passthrough', self::$passthrough_parameter, 0, "/");
				return true;
			}
			if (isset($_COOKIE["passthrough"]) && $_COOKIE["passthrough"] == self::$passthrough_parameter) return true;
			if (is_user_logged_in() ||
					self::$current_url == '/wp-login.php/' ||
					self::$current_url == '/wp-admin/' ||
					self::$current_url == '/index.php/' ||
					self::$current_url == '/wp-admin/admin-ajax.php/') return true;
			if (self::is_external(self::$redirect_url) == false && self::$current_url == self::$redirect_url) return true;
			return false;
		}

		private static function get_current_url() {
			$url = parse_url($_SERVER["REQUEST_URI"]);
			$url = "/" . trim($url["path"], '/') . "/";
			return $url;
		}

		private static function get_redirect_url() {
			$url = get_field("redirect_url", "alonidev-toolkit");
			//$site_url = trim(site_url(), "/");
			//if (stripos($url, $site_url) === 0) $url = substr($url, strlen($site_url));
			if (!self::is_external($url)) {
				$url = "/" . trim(parse_url($url)["path"], "/") . "/";
			}
			return $url;
		}

		private static function is_external($url) {
			return stripos($url, "http://") === 0 || stripos($url, "https://") === 0;
		}

	}

}