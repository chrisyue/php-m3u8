<?php

declare(strict_types=1);

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
    public function testFromString($string, $expected): void
    {
        $line = Line::fromString($string);

        $this->assertEquals($expected, $line);
    }

    /**
     * @dataProvider stringTransformationSamples
     */
    public function testToString($string, Line $line = null): void
    {
        if (null === $line) {
            $this->expectNotToPerformAssertions();

            return;
        }

        $this->assertEquals($string, (string) $line);
    }

    public function stringTransformationSamples(): array
    {
        return [
            ['#foo:bar', null],
            ['#EXT-FOO', new Line('EXT-FOO', true)],
            ['bar', new Line(null, 'bar')],
            [' ', null],
            ['#', null],
        ];
    }

    /**
     * @dataProvider typeSamples
     */
    public function testIsType(Line $line, $type): void
    {
        $this->assertTrue($line->isType($type));
    }

    public function typeSamples(): array
    {
        return [
            [new Line('foo', 'bar'), Line::TYPE_TAG],
            [new Line(null, 'foobar'), Line::TYPE_URI],
        ];
    }
}
