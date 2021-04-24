<?php

namespace ArturDoruch\String\Types;

use ArturDoruch\String\CharsetUtils;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class CharsetUtilsTest extends TestCase
{
    public function getIsUtf8Data()
    {
        return [
            ['UTF-8' , true],
            ['UTF-16', false],
            ['ISO-8859-1', false],
            ['windows-1250', false],
        ];
    }

    /**
     * @dataProvider getIsUtf8Data
     */
    public function testIsUtf8(string $filename, bool $expectedUtf8)
    {
        $text = file_get_contents(__DIR__ . '/Fixtures/charset_coding/'.$filename.'.txt');

        self::assertSame($expectedUtf8, CharsetUtils::isUtf8($text), sprintf('Checking text with encoding "%s"', $text));
    }


    public function getCleanupUtf8Data()
    {
        return [
            ['💳bank', 'bank'],
            ['漢字', '漢字'],
            [chr(16640), ''],
        ];
    }

    /**
     * @dataProvider getCleanupUtf8Data
     */
    public function testCleanupUtf8($string, $expected)
    {
        $this->assertEquals($expected, CharsetUtils::cleanupUtf8($string));
    }


    public function getDecodeHexCodePointsData()
    {
        return [
            ['\u00ed', 'í'],
            ['\u2605', '★'],
            ['\u20AC', '€'],
            ['\u100A0', '']
        ];
    }

    /**
     * @dataProvider getDecodeHexCodePointsData
     */
    public function testDecodeHexCodePoints($string, $expected)
    {
        $this->assertEquals($expected, CharsetUtils::decodeHexCodePoints($string));
    }


    public function testDecodeNonBreakingSpaces()
    {
        self::assertEquals('A  B  ', CharsetUtils::decodeNonBreakingSpaces("A\u{00A0}\u{00A0}B&nbsp;&nbsp;"));
    }


    public function testRemoveAccents()
    {
        self::assertEquals('Zdzblo', CharsetUtils::removeAccents('Źdźbło'));
        self::assertEquals('Strasse', CharsetUtils::removeAccents('Straße'));
    }
}
