<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Line;

use Chrisyue\PhpM3u8\Stream\StreamInterface;

class Lines implements \Iterator
{

    private $stream;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    public function current()
    {
        static $text, $line;
        while ($this->valid()) {
            $current = $this->stream->current();
            if ($this->isvalidLine($current)) {
                if ($current !== $text) {
                    $text = $current;
                    $line = Line::fromString($text);
                }

                return $line;
            }
            $this->next();
        }

        return;
    }

    public function add(Line $line)
    {
        $this->stream->add((string)$line);
    }

    public function isvalidLine($lineString)
    {
        if (empty($lineString)) {
            return false;
        }
        if ('#' === $lineString[0] && '#EXT' !== substr($lineString, 0, 4)) {
            // https://github.com/chrisyue/php-m3u8/issues/54 https://tools.ietf.org/html/rfc8216#section-4.1
            return false;
        }

        return true;
    }

    public function next()
    {
        $this->stream->next();
        if (!$this->stream->valid()) {
            return;
        }

        $line = trim($this->stream->current());
        if (!$this->isvalidLine($line)) {
            $this->next();
        }
    }

    public function valid()
    {
        return $this->stream->valid();
    }

    public function rewind()
    {
        $this->stream->rewind();
    }

    public function key()
    {
        return $this->stream->key();
    }
}
