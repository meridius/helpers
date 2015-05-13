<?php

namespace Meridius\Helpers;

use \Nette\Utils\Strings,
		\Nette\Object;

class StringHelper extends Object {

	/**
	 * Converts the given string to "snake_case".
	 * @param string $string
	 * @return string
	 * @link http://stackoverflow.com/a/1993772/836697 thanks to cletus
	 */
	public static function toSnakeCase($string) {
		$matches = array();
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
			Strings::capitalize(
				self::toSnakeCase($string)
			), "/[_-]/");
	}

	/**
	 * Converts the given string to "camelCase".
	 * @param string $string
	 * @return string
	 */
	public static function toCamelCase($string) {
		return Strings::firstLower(self::toPascalCase($string));
	}

}
