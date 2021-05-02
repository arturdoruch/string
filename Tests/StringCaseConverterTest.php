<?php

namespace ArturDoruch\StringUtil\Tests;

use ArturDoruch\StringUtil\StringCaseConverter;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class StringCaseConverterTest extends TestCase
{
    public function getToSnakeData()
    {
        return [
            ['Lorem IPSUM', 'lorem_i_p_s_u_m'],
            ['Foo_BAr_Baz', 'foo_b_ar_baz'],
            ['regularACamelCase', 'regular_a_camel_case'],
            ['camel4Case', 'camel4_case'],
            ['2Name', '2_name'],
            ['2name', '2name'],
            ['świeża Śliwka', 'świeża_śliwka'],
            ['świeżaŚliwka', 'świeża_śliwka'],
            ['foo: bar, baz', 'foo_bar_baz'],
            ['name-with-dashes', 'name_with_dashes'],
        ];
    }

    /**
     * @dataProvider getToSnakeData
     */
    public function testToSnake($string, $expected)
    {
        self::assertEquals($expected, StringCaseConverter::toSnake($string));
    }

    public function getToCamelData()
    {
        return [
            ['Lorem IPSUM', 'loremIPSUM'],
            ['Foo_BAr_Baz', 'fooBArBaz'],
            ['camel2Camel', 'camel2Camel'],
            ['camelABCamel', 'camelABCamel'],
            ['2name', '2name'],
            ['4_name', '4Name'],
            ['foo_2_bar', 'foo2Bar'],
            ['świeża Śliwka', 'świeżaŚliwka'],
            ['foo: bar', 'fooBar'],
            ['name-with-dashes', 'nameWithDashes'],
        ];
    }

    /**
     * @dataProvider getToCamelData
     */
    public function testToCamel($string, $expected)
    {
        self::assertEquals($expected, StringCaseConverter::toCamel($string));
    }


    public function testToPascal()
    {
        self::assertEquals('ŚwieżaŚliwka', StringCaseConverter::toPascal('świeża Śliwka'));
    }


    public function getTitleData()
    {
        return [
            ['event log2', 'Event log2'],
            ['camelCase', 'CamelCase'],
            ['kebab-case-notation', 'Kebab case notation'],
            ['snake_case_notation', 'Snake case notation'],
            ['HTTP_Request', 'HTTP Request'],
            ['żelazo_i_żwir', 'Żelazo i żwir'],
            ['params: foo, bar', 'Params: foo, bar'],
            ['foo v. bar', 'Foo v. Bar'],
            ['filename.txt', 'Filename.txt'],
            ['The build-in feature', 'The build-in feature'],
            ['Foo bar_baz--faz', 'Foo Bar Baz  Faz', true],
        ];
    }

    /**
     * @dataProvider getTitleData
     */
    public function testToTitle($string, $expected, $uppercaseFirstLetters = false)
    {
        self::assertEquals($expected, StringCaseConverter::toTitle($string, $uppercaseFirstLetters));
    }


    public function getFilenameTestData()
    {
        return [
            ['/\*:?"<>|', '', 'windows'],
            ['ąćęńśół', 'ąćęńśó', 'windows', 6],
            ['ąćęńśół', 'ąćęńśó', 'windows', 6],
            [chr(7) . chr(31), '', 'windows'],
            [chr(33), '!', 'windows'],
            ['/dot.', 'dot', 'windows'],
            ['aux', '', 'windows'],
            ['aux1', 'aux1', 'windows'],
            ['com1', '', 'windows'],
            ['com10', 'com10', 'windows'],

            ['/' . chr(0), '', 'unix'],

            ['foo: bar', 'foo bar', 'mac'],
        ];
    }

    /**
     * @dataProvider getFilenameTestData
     */
    public function testToFilename($string, $expected, $os, $length = null)
    {
        self::assertEquals($expected, StringCaseConverter::toFilename($string, $os, $length));
    }
}
