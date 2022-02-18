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

namespace Chrisyue\PhpM3u8\Definition;

use Chrisyue\PhpM3u8\Config;

class TagDefinitions
{
    private $definitions;

    private $headTags;

    private $mediaSegmentTags;

    private $footTags;

    public function __construct(array $definitions)
    {
        foreach ($definitions as $tag => $definition) {
            $position = $definition['position'];
            if ('media-segment' === $definition['category']) {
                $this->mediaSegmentTags[$definition['position']] = $tag;

                continue;
            }

            if (0 > $position) {
                $this->headTags[$position] = $tag;

                continue;
            }

            $this->footTags[$position] = $tag;
        }

        $this->definitions = $definitions;

        ksort($this->headTags);
        ksort($this->mediaSegmentTags);
        ksort($this->footTags);
    }

    public function get($tag)
    {
        if (!\is_string($tag)) {
            throw new \InvalidArgumentException('$tag can only be string, got %s', \gettype($tag));
        }

        if (!isset($this->definitions[$tag])) {
            return;
        }

        return new TagDefinition($tag, new Config($this->definitions[$tag]));
    }

    public function getHeadTags()
    {
        return $this->headTags;
    }

    public function getMediaSegmentTags()
    {
        return $this->mediaSegmentTags;
    }

    public function getFootTags()
    {
        return $this->footTags;
    }
}
