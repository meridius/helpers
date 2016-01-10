<?php

namespace Meridius\Helpers;

class ExcelHelper extends \Nette\Object {

    /**
     * Converts numbers to Excel-like column names
     * A = 1
     * @param int $num
     * @return string
     */
    public static function getExcelColumnName($num) {
        $num--;
        for ($name = ""; $num >= 0; $num = intval($num / 26) - 1) {
            $name = chr($num % 26 + 0x41) . $name;
        }
        return $name;
    }

    /**
     * Converts Excel-like column names to numbers
     * @param string $letters
     * @return int
     */
    public static function getExcelColumnNumber($letters) {
        $num = 0;
        $arr = array_reverse(str_split($letters));

        for ($i = 0; $i < count($arr); $i++) {
            $num += (ord(strtolower($arr[$i])) - 96) * (pow(26, $i));
        }
        return $num;
    }

    /**
     *
     * @param string $link
     * @param string|null $text
     * @return string
     */
    public static function createHyperlinkFunctionText($link, $text = null) {
        return $text
            ? '=HYPERLINK("' . $link . '", "' . $text . '")'
            : '=HYPERLINK("' . $link . '")';
    }

}
