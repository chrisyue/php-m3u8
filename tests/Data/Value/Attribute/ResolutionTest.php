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

namespace Chrisyue\PhpM3u8\Test\Data\Value\Attribute;

use Chrisyue\PhpM3u8\Data\Value\Attribute\Resolution;
use PHPUnit\Framework\TestCase;

class ResolutionTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFromString($string, Resolution $resolution): void
    {
        $this->assertEquals($resolution, Resolution::fromString($string));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToString($string, Resolution $resolution): void
    {
        $this->assertEquals($string, (string) $resolution);
    }

    public function dataProvider(): array
    {
        return [
            ['800x600', new Resolution(800, 600)],
        ];
    }
}
