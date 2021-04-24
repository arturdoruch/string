<?php

namespace ArturDoruch\String\Types;

use ArturDoruch\String\StringUtils;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class StringUtilsTest extends TestCase
{
    private $text = <<<TEXT
            There are many variations
            
of passages     
available. 

TEXT;

    public function testContains()
    {
        self::assertTrue(StringUtils::contains('passages', $this->text));
        self::assertFalse(StringUtils::contains('foo', $this->text));
    }


    public function testStartsWith()
    {
        self::assertTrue(StringUtils::startsWith('There', 'There are'));
        self::assertFalse(StringUtils::startsWith('There', ''));
        self::assertFalse(StringUtils::startsWith('foo', 'There are'));
    }


    public function testEndsWith()
    {
        self::assertTrue(StringUtils::endsWith('are', 'There are'));
        self::assertFalse(StringUtils::endsWith('are', ''));
        self::assertFalse(StringUtils::endsWith('foo', 'There are'));
    }


    public function testFind()
    {
        self::assertEquals('variations', StringUtils::find('/many ([a-z]+)/', $this->text));
        self::assertNull(StringUtils::find('/many [a-z]+/', $this->text));
        self::assertNull(StringUtils::find('/(foo)/', $this->text));
    }


    public function testFindAll()
    {
        self::assertEquals([
            'There', 'are'
        ], StringUtils::findAll('/(?=.*re.*)([a-z]+)/i', $this->text));
        self::assertEquals([], StringUtils::findAll('/(foo)/', $this->text));
        self::assertEquals([], StringUtils::findAll('/foo/', $this->text));
    }


    public function testRemoveEmptyLines()
    {
        self::assertEquals("There are many variations\nof passages\navailable.", StringUtils::removeEmptyLines($this->text));
    }
}
