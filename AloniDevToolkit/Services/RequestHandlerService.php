<?php

namespace AloniDevToolkit\Services {

	use AloniDevToolkit\Helpers\RequestHelper;

	class RequestHandlerService {

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