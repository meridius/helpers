<?php

namespace Meridius\Helpers;

use Nette\Object;
use Nette\Utils\Strings;

class StringHelper extends Object {

	/**
	 * Trimmed variable will be returned only if is string, <br/>
	 * original variable is returned if not
	 * @param mixed $param
	 * @return mixed
	 */
	public static function safeTrim($param) {
		return (is_string($param) && strlen($param) > 0) ? trim($param) : $param;
	}

	/**
	 * Converts the given string to "snake_case".
	 * @param string $string
	 * @return string
	 * @link http://stackoverflow.com/a/1993772/836697 thanks to cletus
	 */
	public static function toSnakeCase($string) {
		$matches = [];
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = ($match == strtoupper($match)) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}

	/**
	 * Converts the given string to "CONST_CASE".
	 * @param string $string
	 * @return string
	 */
	public static function toConstCase($string) {
		return Strings::upper(self::toSnakeCase($string));
	}

	/**
	 * Converts the given string to "PascalCase".
	 * @param string $string
	 * @return string
	 */
	public static function toPascalCase($string) {
		return Strings::replace(
			Strings::capitalize(self::toSnakeCase($string)),
			'/[_-]/'
		);
	}

	/**
	 * Converts the given string to "camelCase".
	 * @param string $string
	 * @return string
	 */
	public static function toCamelCase($string) {
		static $canUse = null;
		if (is_null($canUse)) {
			$canUse = method_exists(Strings::class, 'firstLower'); // Nette/Utils >= 2.3 only
		}
		$pascal = self::toPascalCase($string);
		return $canUse
			? Strings::firstLower($pascal)
			: Strings::lower(Strings::substring($pascal, 0, 1)) . Strings::substring($pascal, 1);
	}

}
