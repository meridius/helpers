<?php

/**
 * Test: Meridius\Helpers\StringHelper
 *
 * @testCase Meridius\Helpers\StringHelperTest
 * @package Meridius\Helpers
 */

namespace MeridiusTests\Helpers;

use Tester;
use Tester\Assert;
use Meridius\Helpers\StringHelper;

require_once __DIR__ . '/../bootstrap.php';


class StringHelperTest extends Tester\TestCase {

	/**
	 *
	 * @return string[] test string, snake_case, PascalCase, camelCase, CONST_CASE
	 */
	public function getCasingMethodsData() {
		return [
			['asset_eol_status', 'asset_eol_status', 'AssetEolStatus', 'assetEolStatus', 'ASSET_EOL_STATUS'],
			['asset-eol-status', 'asset_eol_status', 'AssetEolStatus', 'assetEolStatus', 'ASSET_EOL_STATUS'],
			['assetEolStatus', 'asset_eol_status', 'AssetEolStatus', 'assetEolStatus', 'ASSET_EOL_STATUS'],
			['AssetEolStatus', 'asset_eol_status', 'AssetEolStatus', 'assetEolStatus', 'ASSET_EOL_STATUS'],
			['HTML', 'html', 'Html', 'html', 'HTML'],
			['sim4pleXML', 'sim4ple_xml', 'Sim4PleXml', 'sim4PleXml', 'SIM4PLE_XML'],
			['simpleXML', 'simple_xml', 'SimpleXml', 'simpleXml', 'SIMPLE_XML'],
			['si-mpleXML', 'si_mple_xml', 'SiMpleXml', 'siMpleXml', 'SI_MPLE_XML'],
			['si_mpleXML', 'si_mple_xml', 'SiMpleXml', 'siMpleXml', 'SI_MPLE_XML'],
			['PDFLoad', 'pdf_load', 'PdfLoad', 'pdfLoad', 'PDF_LOAD'],
			['startMIDDLELast', 'start_middle_last', 'StartMiddleLast', 'startMiddleLast', 'START_MIDDLE_LAST'],
			['AString', 'a_string', 'AString', 'aString', 'A_STRING'],
			['Some4Numbers234', 'some4_numbers234', 'Some4Numbers234', 'some4Numbers234', 'SOME4_NUMBERS234'],
			['TEST123String', 'test123_string', 'Test123String', 'test123String', 'TEST123_STRING'],
		];
	}

	/**
	 *
	 * @dataProvider getCasingMethodsData
	 */
	public function testCasingMethods($in, $snakeExpected, $pascalExpected, $camelExpected, $constExpected) {
		Assert::same($snakeExpected, StringHelper::toSnakeCase($in));
		Assert::same($pascalExpected, StringHelper::toPascalCase($in));
		Assert::same($camelExpected, StringHelper::toCamelCase($in));
		Assert::same($constExpected, StringHelper::toConstCase($in));
	}

	/**
	 *
	 * @return mixed[] test data, expected result
	 */
	public function getSafeTrimData() {
		$date = new \DateTime;
		return [
			['as df', 'as df'],
			['as df ', 'as df'],
			['16851 ', '16851'],
			[16851, 16851],
			[$date, $date],
		];
	}

	/**
	 *
	 * @dataProvider getSafeTrimData
	 */
	public function testSafeTrim($in, $expected) {
		Assert::same($expected, StringHelper::safeTrim($in));
	}

	/**
	 *
	 */
	public function getUnserializeFormValuesData() {
		return [
			[
				[],
				[]
			], [
				['rates[values][USD]' => 0.54],
				['rates' => ['values' => ['USD' => 0.54]]]
			], [
				['USD' => 0.54],
				['USD' => 0.54]
			], [
				[
					'animal' => 'dog',
					'color' => ['blue', 'green'],
					'rates[values][USD]' => 0.54,
					'rates[values][EUR]' => 0.13,
					'rates[values][GBP]' => 1.87,
				], [
					'animal' => 'dog',
					'color' => ['blue', 'green'],
					'rates' => [
						'values' => [
							'USD' => 0.54,
							'EUR' => 0.13,
							'GBP' => 1.87,
						]
					]
				]
			]
		];
	}

	/**
	 * @dataProvider getUnserializeFormValuesData
	 * @param string $in
	 * @param array $expected
	 */
	public function testUnserializeFormValues($in, $expected) {
		Assert::same($expected, StringHelper::unserializeFormValues($in));
	}

}

$testCase = new StringHelperTest;
$testCase->run();
