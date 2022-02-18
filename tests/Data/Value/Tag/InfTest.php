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

namespace Chrisyue\PhpM3u8\Test\Data\Value\Tag;

use Chrisyue\PhpM3u8\Data\Value\Tag\Inf;
use PHPUnit\Framework\TestCase;

class InfTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromString($string, Inf $inf): void
    {
        $this->assertEquals($inf, Inf::fromString($string));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToString($string, Inf $inf): void
    {
        $this->assertEquals($string, (string) $inf);
    }

    public function dataProvider(): array
    {
        return [
            ['0.000,', new Inf(0)],
            ['10.001,', new Inf(10.001)],
            ['10.002,hello world', new Inf(10.002, 'hello world')],
        ];
    }
}
