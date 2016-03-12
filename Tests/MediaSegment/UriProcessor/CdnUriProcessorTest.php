<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\MediaSegment\UriProcessor;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor\CdnUriProcessor;

class CdnUriProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $uri = 'stream.ts';
        $mediaSegment = $this->prophesizeMediaSegment($uri);

        $host = 'http://example.com';

        $processor = new CdnUriProcessor($host);
        $newUri = $processor->process($mediaSegment->reveal());

        $this->assertEquals($newUri, sprintf('%s/%s', $host, $uri));
    }

    public function testProcess2()
    {
        $uri = 'stream.ts';
        $mediaSegment = $this->prophesizeMediaSegment($uri);

        $host = 'http://example.com/';

        $processor = new CdnUriProcessor($host);
        $newUri = $processor->process($mediaSegment->reveal());

        $this->assertEquals($newUri, sprintf('%s%s', $host, $uri));
    }

    public function testProcess3()
    {
        $absolute = 'http://localhost/stream.ts';
        $mediaSegment = $this->prophesizeMediaSegment($absolute);

        $host = 'http://example.com';

        $processor = new CdnUriProcessor($host);
        $newUri = $processor->process($mediaSegment->reveal());

        $path = '/stream.ts';
        $this->assertEquals($newUri, sprintf('%s%s', $host, $path));
    }

    private function prophesizeMediaSegment($uri)
    {
        $mediaSegment = $this->prophesize('Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegment');
        $mediaSegment->getUri()->shouldBeCalledTimes(1)->willReturn($uri);

        return $mediaSegment;
    }
}
