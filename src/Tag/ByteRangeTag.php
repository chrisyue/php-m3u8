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

class ByteRangeTag extends AbstractSegmentTag
{
    private $length;
    private $offset;

    const TAG_IDENTIFIER = '#EXT-X-BYTERANGE';

    /**
     * @return self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return self
     */
    public function getLength()
    {
        return $this->length;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function dump()
    {
        if (empty($this->length)) {
            return;
        }

        $text = sprintf('%s:%d', self::TAG_IDENTIFIER, $this->length);

        if (!empty($this->offset)) {
            $text = sprintf('%s@%d', $text, $this->offset);
        }

        return $text;
    }

    protected function read($line)
    {
        preg_match('/^#EXT-X-BYTERANGE:(\d+)(@(\d+))?$/', $line, $matches);
        $this->length = (int) $matches[1];

        if (!empty($matches[3])) {
            $this->offset = (int) $matches[3];
        }
    }
}
