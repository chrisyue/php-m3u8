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
use Chrisyue\PhpM3u8\Line\Lines;
use Chrisyue\PhpM3u8\Stream\TextStream;
use PHPUnit\Framework\TestCase;

class LinesTest extends TestCase
{

    /**
     * @dataProvider stringTransformationSamples
     */
    public function testCommentJudgement($string, $expected)
    {
        $stream = new TextStream($string);
        $line   = (new Lines($stream))->current();

        $this->assertEquals($expected, $line);
    }

    public function stringTransformationSamples()
    {
        return [
            ['###EXTINF:2,这是应该被当做一行注释忽略 this line should be ignored as a comment as RFC 8216', null],
            ['#', null],
            [' ', null],
            ['bar', new Line(null, 'bar')],
            ['#EXTINF:2,TEST', new Line('EXTINF', '2,TEST')],
        ];
    }
}
