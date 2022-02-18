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

class TagDefinition
{
    private $tag;

    private $config;

    private $attributeTypes;

    public function __construct($tag, Config $config)
    {
        if (!\is_string($tag)) {
            throw new \InvalidArgumentException('$tag can only be string, got %s', \gettype($tag));
        }

        $this->tag = $tag;

        $this->config = $config;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function getValueType()
    {
        $type = $this->config->get('type');
        if (\is_array($type)) {
            $this->attributeTypes = $type;

            return 'attribute-list';
        }

        return $type;
    }

    public function isMultiple()
    {
        return $this->config->get('multiple', false);
    }

    public function getCategory()
    {
        return $this->config->get('category');
    }

    public function isUriAware()
    {
        return $this->config->get('uriAware', false);
    }

    public function getAttributeTypes()
    {
        return $this->attributeTypes;
    }
}
