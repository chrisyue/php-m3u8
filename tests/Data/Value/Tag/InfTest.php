<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Test\Data\Value\Tag;

use Chrisyue\PhpM3u8\Data\Value\Tag\Inf;
use PHPUnit\Framework\TestCase;

class InfTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromString($string, Inf $inf)
    {
        $this->assertEquals($inf, Inf::fromString($string));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToString($string, Inf $inf)
    {
        $this->assertEquals($string, (string) $inf);
    }

    public function dataProvider()
    {
        return [
            ['10.001,', new Inf(10.001)],
            ['10.002,hello world', new Inf(10.002, 'hello world')],
        ];
    }
}
