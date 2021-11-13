<?php

namespace AloniDevToolkit\Services {

	use AloniDevToolkit\Helpers\RequestHelper;

	class RequestHandlerService {

//		public static function init_service() {
//			self::init_ajax_handler();
//			$str = UrlHelper::get_url_model()->path;
//			$patterns = ["^\/wp-admin(\/.*|$)", "^\/abc(\/.*|$)"];
//			var_dump(self::str_matches_any($str, $patterns));
//		}
//		private static function str_matches_any($str, $patterns) {
//			foreach ($patterns as $pattern) {
//				$pattern = "/" . $pattern . "/i";
//				if (@preg_match($pattern, $str)) return true;
//			}
//			return false;
//		}

		public static function init_service() {
			self::add_redirect_handler();
		}

		static function add_redirect_handler() {
			RequestHelper::add_handler("redirect", function () {
				$url = $_REQUEST["url"];
				wp_redirect($url);
				exit();
			});
		}

	}

}