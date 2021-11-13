<?php

namespace AloniDevToolkit\Helpers {

	use AloniDevToolkit\Models\UrlModel;

	class UrlHelper {

		public static function get_url($url = null) {
			if ($url === null) {
				$url = self::get_current_url();
			}
			return $url;
		}

		public static function get_url_model($url = null) {
			$raw = self::get_url($url);
			$parsed = parse_url($raw);
			$scheme = $parsed["scheme"];
			$host = $parsed["host"];
			$path = $parsed["path"];
			$query = $parsed["query"];

			$scheme_host = ($scheme ? $scheme . "://" : "") . $host;
			$path_query = $path . ($query || stripos($url, "?") == strlen($url) - 1 ? "?" . $query : "");
			$scheme_host_path = $scheme_host . $path;
			$host_path = $host . $path;
			$host_path_query = $host . $path_query;
			$scheme_host_path_query = $scheme_host . $path_query;
			$full = $scheme_host_path_query;

			$query_as_array = [];
			parse_str($query, $query_as_array);

			$u = new UrlModel();
			$u->is_valid = $scheme && $host;
			$u->raw = $raw ?? "";
			$u->scheme = $scheme ?? "";
			$u->host = $host ?? "";
			$u->path = $path ?? "";
			$u->query = $query ?? "";
			$u->full = $full;
			$u->scheme_host = $scheme_host;
			$u->scheme_host_path = $scheme_host_path;
			$u->host_path_query = $host_path_query;
			$u->path_query = $path_query;
			$u->host_path = $host_path;
			$u->query_as_array = $query_as_array;
			return $u;
		}

		private static function get_current_url() {
			$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			return $url;
		}

	}

}