<?php

/**
 * Test: Meridius\Helpers\FileHelper
 *
 * @testCase Meridius\Helpers\FileHelperTest
 * @package Meridius\Helpers
 */

namespace MeridiusTests\Helpers;

use Tester;
use Tester\Assert;
use Meridius\Helpers\FileHelper;

require_once __DIR__ . '/../bootstrap.php';


class FileHelperTest extends Tester\TestCase {

	const DIR_TO_DELETE = TEMP_DIR . '/dirToDelete';

	public function testDeleteDirEmpty() {
		\Tester\Helpers::purge(self::DIR_TO_DELETE);
		FileHelper::deleteDir(self::DIR_TO_DELETE);
		Assert::false(is_dir(self::DIR_TO_DELETE));
	}

	public function testDeleteDirNotDir() {
		$cb = function() {
			FileHelper::deleteDir(self::DIR_TO_DELETE);
		};
		Assert::exception($cb, '\Exception');
	}

	public function testDeleteDirNotEmpty() {
		\Tester\Helpers::purge(self::DIR_TO_DELETE);
		$anotherDir = self::DIR_TO_DELETE . '/anotherDir';
		\Tester\Helpers::purge($anotherDir);
		file_put_contents(self::DIR_TO_DELETE . '/testFile', 'asdf');
		file_put_contents($anotherDir . '/anotherTestFile', 'htrsd');
		FileHelper::deleteDir(self::DIR_TO_DELETE);
		Assert::false(is_dir(self::DIR_TO_DELETE));
	}

}

$testCase = new FileHelperTest;
$testCase->run();
