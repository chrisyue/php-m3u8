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

class TagDefinition
{
    private $property;

    private $config;

    private $attributeTypes;

    public function __construct($property, Config $config)
    {
        if (!is_string($property)) {
            throw new \InvalidArgumentException('$property can only be string, got %s', var_export($property));
        }

        $this->property = $property;

        $this->config = $config;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function getValueType()
    {
        $type = $this->config->get('type');
        if (is_array($type)) {
            $this->attributeTypes = $type;

            return 'attribute-list';
        }

        return $type;
    }

    public function getTagName()
    {
        return $this->config->get('tag');
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
