<?php

namespace Chrisyue\PhpM3u8\Test\DataTransformer;

use PHPUnit\Framework\TestCase;
use Chrisyue\PhpM3u8\DataTransformer\Iso8601Transformer;

class Iso8601TransformerTest extends TestCase
{
    public function testFromString()
    {
        $string = '2018-01-01 01:02:03';

        $transformer = new Iso8601Transformer();

        $this->assertEquals(new \DateTime($string), $transformer->fromString($string));
    }
}
