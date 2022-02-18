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

namespace Chrisyue\PhpM3u8\Test\Data\Transformer;

use Chrisyue\PhpM3u8\Data\Transformer\AttributeStringToArray;
use PHPUnit\Framework\TestCase;

class AttributeStringToArrayTest extends TestCase
{
    public function testInvoke(): void
    {
        $attr2Array = new AttributeStringToArray();

        $string = 'FOO=BAR,URI="http://example.com/?p=1"';
        $expected = [
            'FOO' => 'BAR',
            'URI' => '"http://example.com/?p=1"',
        ];

        $this->assertEquals($expected, $attr2Array($string));
    }
}
