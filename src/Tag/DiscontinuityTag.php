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

class DiscontinuityTag extends AbstractTag
{
    private $discontinuity = false;

    const TAG_IDENTIFIER = '#EXT-X-DISCONTINUITY';

    public function setDiscontinuity($discontinuity)
    {
        $this->discontinuity = $discontinuity;

        return $this;
    }

    public function isDiscontinuity()
    {
        return $this->discontinuity;
    }

    public function dump()
    {
        if ($this->discontinuity) {
            return self::TAG_IDENTIFIER;
        }
    }

    protected function read($line)
    {
        $this->discontinuity = true;
    }
}
