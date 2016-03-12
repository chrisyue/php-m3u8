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

use Chrisyue\PhpM3u8\Dumper;
use Prophecy\Argument;

class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testDump()
    {
        $m3u8 = DummyM3u8Factory::createM3u8();
        $uriProcessor = $this->prophesizeUriProcessor();

        $dumper = new Dumper($uriProcessor->reveal());
        $m3u8Content = $dumper->dump($m3u8);

        $this->assertEquals($m3u8Content, DummyM3u8Factory::createM3u8Content());
    }

    public function testDumpVersionLessThan3()
    {
        $m3u8 = DummyM3u8Factory::createM3u8(2);
        $uriProcessor = $this->prophesizeUriProcessor();

        $dumper = new Dumper($uriProcessor->reveal());
        $m3u8Content = $dumper->dump($m3u8);

        $this->assertEquals($m3u8Content, DummyM3u8Factory::createM3u8Content(2));
    }

    private function prophesizeUriProcessor()
    {
        $uriProcessor = $this->prophesize('Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor\UriProcessorInterface');

        $uriProcessor->process(Argument::type('Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegment'))
            ->shouldBeCalled()->will(function ($args) {
                return $args[0]->getUri();
            });

        return $uriProcessor;
    }
}
