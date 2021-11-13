<?php

namespace AloniDevToolkit\Services {

	class ShortcodeService {

		public static function init_service() {
			self::add_shortcodes();
		}

		private static function add_shortcodes() {
			add_shortcode("siteurl", function () {
				return site_url();
			});
			add_shortcode("random", function ($atts) {
				$atts = shortcode_atts(["length" => 6], $atts);
				$length = $atts["length"];
				if ($length < 1) return "";
				$min = intval("1" . str_repeat("0", $length - 1));
				$max = intval(str_repeat("9", $length));
				return rand($min, $max);
			});
		}

	}

}