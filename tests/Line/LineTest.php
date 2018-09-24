<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Test\Line;

use Chrisyue\PhpM3u8\Line\Line;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    /**
     * @dataProvider stringTransformationSamples
     */
    public function testFromString($string, $expected)
    {
        $line = Line::fromString($string);

        $this->assertEquals($expected, $line);
    }

    /**
     * @dataProvider stringTransformationSamples
     */
    public function testToString($string, Line $line = null)
    {
        if (null === $line) {
            return;
        }

        $this->assertEquals($string, (string) $line);
    }

    public function stringTransformationSamples()
    {
        return [
            ['#foo:bar', new Line('foo', 'bar')],
            ['#foo', new Line('foo', true)],
            ['bar', new Line(null, 'bar')],
            [' ', null],
            ['#', null],
        ];
    }

    /**
     * @dataProvider typeSamples
     */
    public function testIsType(Line $line, $type)
    {
        $this->assertTrue($line->isType($type));
    }

    public function typeSamples()
    {
        return [
            [new Line('foo', 'bar'), Line::TYPE_TAG],
            [new Line(null, 'foobar'), Line::TYPE_URI],
        ];
    }
}
