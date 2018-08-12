<?php

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

    private $currentUriAware;

    private $isMasterPlaylist;

    public function __construct(TagDefinitions $tagDefinitions, Config $valueDumpers)
    {
        $this->tagDefinitions = $tagDefinitions;
        $this->valueDumpers = $valueDumpers;
    }

    public function dumpToLines(\ArrayObject $data, Lines $lines)
    {
        $lines->add(new Line('EXTM3U', true));
        $this->iterateProperties(
            $this->tagDefinitions->getHeadProperties(),
            $data,
            $lines,
            function (TagDefinition $tagDefinition) {
                if ('master-playlist' === $tagDefinition->getCategory()) {
                    $this->isMasterPlaylist = true;
                }
            }
        );

        if (!isset($data['mediaSegments'])) {
            return;
        }

        foreach ($data['mediaSegments'] as $mediaSegment) {
            $this->iterateProperties($this->tagDefinitions->getMediaSegmentProperties(), $mediaSegment, $lines);

            $lines->add(new Line(null, $mediaSegment['uri']));
        }

        $this->iterateProperties($this->tagDefinitions->getFootProperties(), $data, $lines);
    }

    private function iterateProperties(
        array $properties,
        \ArrayObject $data,
        Lines $lines
    ) {
        foreach ($properties as $property) {
            if (!isset($data[$property])) {
                continue;
            }

            $definition = $this->tagDefinitions->get($property);
            $value = $data[$property];

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

        if (!is_callable($dump)) {
            return $value;
        }

        if ('attribute-list' === $valueType) {
            return $dump($value, $definition->getAttributeTypes());
        }

        return $dump($value);
    }

    private function dumpAndAddToLines(TagDefinition $definition, $value, Lines $lines)
    {
        $lines->add(new Line($definition->getTagName(), $this->dumpValue($definition, $value)));

        if ($definition->isUriAware()) {
            $lines->add(new Line(null, $value['uri']));
        }
    }
}
