<?php

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
    private $currentUriAware;

    private $result;

    public function __construct()
    {
        $this->result = new \ArrayObject();
    }

    public function addUri($uri)
    {
        if (null === $this->currentUriAware) {
            throw new DataBuildingException('uri found, but doesn\'t know how to handle it');
        }

        $this->currentUriAware['uri'] = $uri;
        $this->currentUriAware = null;
    }

    public function addTag(TagDefinition $definition, $data)
    {
        $parent = $this->result;
        if (null === $this->currentUriAware) {
            if ('media-segment' === $definition->getCategory()) {
                $this->currentUriAware = new \ArrayObject();
                $this->result['mediaSegments'][] = $this->currentUriAware;
            } elseif ($definition->isUriAware()) {
                $this->currentUriAware = $data;
            }
        }

        if ('media-segment' === $definition->getCategory()) {
            $parent = $this->currentUriAware;
        }

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
}
