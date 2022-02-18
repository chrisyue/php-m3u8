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

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Definition\TagDefinition;

class DataBuilder
{
    private $currentMediaSegment;

    private $result;

    private $lastAddedTag;

    public function addUri($uri): void
    {
        if (null !== $this->currentMediaSegment) {
            $this->currentMediaSegment['uri'] = $uri;
            $this->currentMediaSegment = null;

            return;
        }

        if ($this->lastAddedTag['definition']->isUriAware()) {
            $this->lastAddedTag['value']['uri'] = $uri;

            return;
        }

        throw new DataBuildingException('uri found, but doesn\'t know how to handle it');
    }

    public function addTag(TagDefinition $definition, $data): void
    {
        $parent = $this->result;
        if ('media-segment' === $definition->getCategory()) {
            if (null === $this->currentMediaSegment) {
                $this->currentMediaSegment = new \ArrayObject();
                $this->result['mediaSegments'][] = $this->currentMediaSegment;
            }

            $parent = $this->currentMediaSegment;
        }

        $this->lastAddedTag = [
            'definition' => $definition,
            'value' => $data,
        ];

        if ($definition->isMultiple()) {
            $parent[$definition->getTag()][] = $data;

            return;
        }

        $parent[$definition->getTag()] = $data;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function reset(): void
    {
        $this->currentMediaSegment = null;
        $this->result = new \ArrayObject();
        $this->lastAddedTag = null;
    }
}
