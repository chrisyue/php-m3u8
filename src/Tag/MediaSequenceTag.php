<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Tag;

class MediaSequenceTag extends AbstractHeadTag
{
    private $mediaSequence = 0;

    const TAG_IDENTIFIER = '#EXT-X-MEDIA-SEQUENCE';

    public function setMediaSequence($mediaSequence)
    {
        $this->mediaSequence = $mediaSequence;

        return $this;
    }

    public function getMediaSequence()
    {
        return $this->mediaSequence;
    }

    public function dump()
    {
        return sprintf('%s:%d', self::TAG_IDENTIFIER, $this->mediaSequence);
    }

    protected function read($line)
    {
        preg_match('/^#EXT-X-MEDIA-SEQUENCE:(\d+)/', $line, $matches);

        $this->mediaSequence = (int) $matches[1];
    }
}
