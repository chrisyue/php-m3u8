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

class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testDump()
    {
        $m3u8 = DummyM3u8Factory::createM3u8();

        $dumper = new Dumper();
        $m3u8Content = $dumper->dump($m3u8);

        $this->assertEquals($m3u8Content, DummyM3u8Factory::createM3u8Content());
    }

    public function testDumpVersionLessThan3()
    {
        $m3u8 = DummyM3u8Factory::createM3u8(2);

        $dumper = new Dumper();
        $m3u8Content = $dumper->dump($m3u8);

        $this->assertEquals($m3u8Content, DummyM3u8Factory::createM3u8Content(2));
    }
}
