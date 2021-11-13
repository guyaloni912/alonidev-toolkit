<?php

namespace AloniDevToolkit\Helpers {

	class RequestHelper {

		public static function add_handler($action, $callback) {
			add_action('admin_post_' . $action, $callback);
		}

		public static function add_handler_ajax($action, $callback) {
			add_action('wp_ajax_nopriv_' . $action, $callback);
			add_action('wp_ajax_' . $action, $callback);
		}

	}

}