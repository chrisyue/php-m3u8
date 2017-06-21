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

class DiscontinuityTag extends AbstractSegmentTag
{
    private $isDiscontinuity = false;

    const TAG_IDENTIFIER = '#EXT-X-DISCONTINUITY';

    public function setDiscontinuity($isDiscontinuity)
    {
        $this->isDiscontinuity = $isDiscontinuity;

        return $this;
    }

    public function isDiscontinuity()
    {
        return $this->isDiscontinuity;
    }

    public function dump()
    {
        if ($this->isDiscontinuity) {
            return self::TAG_IDENTIFIER;
        }
    }

    protected function read($line)
    {
        $this->isDiscontinuity = true;
    }
}
