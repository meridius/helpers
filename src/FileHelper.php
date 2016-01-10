<?php

namespace Meridius\Helpers;

use \Nette\Object;

class FileHelper extends Object {

	/**
	 * Delete dir recursively.
	 * @param string $dirPath
	 * @throws Exception
	 */
	public static function deleteDir($dirPath) {
		if (!is_dir($dirPath)) {
			throw new \Exception("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

}
