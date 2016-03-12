<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Chrisyue\PhpM3u8\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $parser = new Parser();
        $m3u8 = $parser->parse(DummyM3u8Factory::createM3u8Content());

        $this->assertEquals($m3u8, DummyM3u8Factory::createM3u8());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testParseFromUriWithoutSetLoader()
    {
        $parser = new Parser();
        $parser->parseFromUri('http://example.com/');
    }

    public function testParserFromUri()
    {
        $uri = 'http://example.com/';

        $loader = $this->prophesize('Chrisyue\PhpM3u8\Loader\LoaderInterface');
        $loader->load($uri)->shouldBeCalledTimes(1)->willReturn(DummyM3u8Factory::createM3u8Content());

        $parser = new Parser();
        $parser->setLoader($loader->reveal());
        $m3u8 = $parser->parseFromUri($uri);

        $this->assertEquals($m3u8, DummyM3u8Factory::createM3u8());
    }
}
