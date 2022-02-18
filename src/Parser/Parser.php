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

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Definition\TagDefinitions;
use Chrisyue\PhpM3u8\Line\Line;
use Chrisyue\PhpM3u8\Line\Lines;

class Parser
{
    private $tagDefinitions;

    private $valueParsers;

    private $dataBuilder;

    public function __construct(TagDefinitions $tagDefinitions, Config $valueParsers, DataBuilder $dataBuilder)
    {
        $this->tagDefinitions = $tagDefinitions;
        $this->valueParsers = $valueParsers;
        $this->dataBuilder = $dataBuilder;
    }

    public function parse(Lines $lines)
    {
        $this->dataBuilder->reset();
        foreach ($lines as $line) {
            if ($line->isType(Line::TYPE_URI)) {
                $this->dataBuilder->addUri($line->getValue());

                continue;
            }

            $tag = $line->getTag();

            $definition = $this->tagDefinitions->get($tag);
            if (null === $definition) {
                continue;
            }

            $valueType = $definition->getValueType();
            $value = $line->getValue();

            $parse = $this->valueParsers->get($valueType);
            if (\is_callable($parse)) {
                $value = 'attribute-list' === $valueType ? $parse($value, $definition->getAttributeTypes()) : $parse($value);
            }

            $this->dataBuilder->addTag($definition, $value);
        }

        return $this->dataBuilder->getResult();
    }
}
