<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegmentInterface;

class OriginUriProcessor implements UriProcessorInterface
{
    public function process(MediaSegmentInterface $mediaSegment)
    {
        return $mediaSegment->getUri();
    }
}
