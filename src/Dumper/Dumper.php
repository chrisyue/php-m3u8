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

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Definition\TagDefinition;
use Chrisyue\PhpM3u8\Definition\TagDefinitions;
use Chrisyue\PhpM3u8\Line\Line;
use Chrisyue\PhpM3u8\Line\Lines;

class Dumper
{
    private $tagDefinitions;

    private $valueDumpers;

    public function __construct(TagDefinitions $tagDefinitions, Config $valueDumpers)
    {
        $this->tagDefinitions = $tagDefinitions;
        $this->valueDumpers = $valueDumpers;
    }

    public function dumpToLines(\ArrayAccess $data, Lines $lines): void
    {
        $lines->add(new Line('EXTM3U', true));
        $this->iterateTags(
            $this->tagDefinitions->getHeadTags(),
            $data,
            $lines
        );

        if (!isset($data['mediaSegments'])) {
            return;
        }

        foreach ($data['mediaSegments'] as $mediaSegment) {
            $this->iterateTags($this->tagDefinitions->getMediaSegmentTags(), $mediaSegment, $lines);

            $lines->add(new Line(null, $mediaSegment['uri']));
        }

        $this->iterateTags($this->tagDefinitions->getFootTags(), $data, $lines);
    }

    private function iterateTags(
        array $tags,
        \ArrayAccess $data,
        Lines $lines
    ): void {
        foreach ($tags as $tag) {
            if (!isset($data[$tag])) {
                continue;
            }

            $definition = $this->tagDefinitions->get($tag);
            $value = $data[$tag];

            if (!$definition->isMultiple()) {
                $this->dumpAndAddToLines($definition, $value, $lines);

                continue;
            }

            foreach ($value as $element) {
                $this->dumpAndAddToLines($definition, $element, $lines);
            }
        }
    }

    private function dumpValue(TagDefinition $definition, $value)
    {
        $valueType = $definition->getValueType();
        $dump = $this->valueDumpers->get($valueType);

        if (!\is_callable($dump)) {
            return $value;
        }

        if ('attribute-list' === $valueType) {
            return $dump($value, $definition->getAttributeTypes());
        }

        return $dump($value);
    }

    private function dumpAndAddToLines(TagDefinition $definition, $value, Lines $lines): void
    {
        $lines->add(new Line($definition->getTag(), $this->dumpValue($definition, $value)));

        if ($definition->isUriAware()) {
            $lines->add(new Line(null, $value['uri']));
        }
    }
}
