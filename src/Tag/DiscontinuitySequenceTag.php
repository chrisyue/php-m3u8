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

class DiscontinuitySequenceTag extends AbstractTag
{
    use SingleValueTagTrait;

    private $discontinuitySequence;

    const TAG_IDENTIFIER = '#EXT-X-DISCONTINUITY-SEQUENCE';

    public function setDiscontinuitySequence($discontinuitySequence)
    {
        $this->discontinuitySequence = $discontinuitySequence;

        return $this;
    }

    public function getDiscontinuitySequence()
    {
        return $this->discontinuitySequence;
    }

    public function dump()
    {
        if (empty($this->discontinuitySequence) && $this->discontinuitySequence !== '0') {
            return;
        }
        return sprintf('%s:%d', self::TAG_IDENTIFIER, $this->discontinuitySequence);
    }

    protected function read($line)
    {
        $this->discontinuitySequence = self::extractValue($line);
    }
}
