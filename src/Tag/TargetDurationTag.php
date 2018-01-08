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

class TargetDurationTag extends AbstractTag
{
    use SingleValueTagTrait;

    private $targetDuration;

    const TAG_IDENTIFIER = '#EXT-X-TARGETDURATION';

    public function setTargetDuration($targetDuration)
    {
        $this->targetDuration = $targetDuration;

        return $this;
    }

    public function getTargetDuration()
    {
        return $this->targetDuration;
    }

    public function dump()
    {
        if (empty($this->targetDuration) && $this->targetDuration !== '0') {
            return;
        }
        return sprintf('%s:%d', self::TAG_IDENTIFIER, $this->targetDuration);
    }

    protected function read($line)
    {
        $this->targetDuration = self::extractValue($line);
    }
}
