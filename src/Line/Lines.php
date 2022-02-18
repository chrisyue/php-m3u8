<?php

declare(strict_types=1);

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

    private $current;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->current;
    }

    public function add(Line $line): void
    {
        $this->stream->add((string) $line);
    }

    public function next(): void
    {
        $this->stream->next();
    }

    public function valid(): bool
    {
        $this->current = null;

        while (null === $this->current && $this->stream->valid()) {
            if ($this->stream->current()) {
                $line = Line::fromString($this->stream->current());

                if (null !== $line) {
                    $this->current = $line;

                    return true;
                }
            }

            $this->stream->next();
        }

        return false;
    }

    public function rewind(): void
    {
        $this->stream->rewind();
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->stream->key();
    }
}
