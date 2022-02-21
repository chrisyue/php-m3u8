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

namespace Chrisyue\PhpM3u8\Test\Data\Value;

use Chrisyue\PhpM3u8\Data\Value\Byterange;
use PHPUnit\Framework\TestCase;

class ByterangeTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromString($string, Byterange $byterange): void
    {
        $this->assertEquals($byterange, Byterange::fromString($string));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToString($string, Byterange $byterange): void
    {
        $this->assertEquals($string, (string) $byterange);
    }

    public function dataProvider(): array
    {
        return [
            ['2000', new Byterange(2000)],
            ['2000@1000', new Byterange(2000, 1000)],
        ];
    }
}
