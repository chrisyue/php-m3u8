<?php

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

    private $tagPropertyMap;

    private $headProperties;

    private $mediaSegmentProperties;

    private $footProperties;

    public function __construct($definitions)
    {
        foreach ($definitions as $property => $definition) {
            if (!isset($definition['tag'])) {
                throw new DefinitionException('every tag definition must contain "tag"');
            }

            $this->tagPropertyMap[$definition['tag']] = $property;

            $position = $definition['position'];
            if ('media-segment' === $definition['category']) {
                $this->mediaSegmentProperties[$definition['position']] = $property;

                continue;
            }

            if (0 > $position) {
                $this->headProperties[$position] = $property;

                continue;
            }

            $this->footProperties[$position] = $property;
        }

        $this->definitions = $definitions;

        ksort($this->headProperties);
        ksort($this->mediaSegmentProperties);
        ksort($this->footProperties);
    }

    public function findOneByTag($tag)
    {
        if (!is_string($tag)) {
            throw new \InvalidArgumentException('$tag can only be string, got %s', var_export($tag));
        }

        if (isset($this->tagPropertyMap[$tag])) {
            $property = $this->tagPropertyMap[$tag];

            return new TagDefinition($property, new Config($this->definitions[$property]));
        }
    }

    public function get($property)
    {
        if (!is_string($property)) {
            throw new \InvalidArgumentException('$property can only be string, got %s', var_export($tag));
        }

        return new TagDefinition($property, new Config($this->definitions[$property]));
    }

    public function getHeadProperties()
    {
        return $this->headProperties;
    }

    public function getMediaSegmentProperties()
    {
        return $this->mediaSegmentProperties;
    }

    public function getFootProperties()
    {
        return $this->footProperties;
    }
}
