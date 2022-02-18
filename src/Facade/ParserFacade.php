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

namespace Chrisyue\PhpM3u8\Facade;

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Definition\TagDefinitions;
use Chrisyue\PhpM3u8\Line\Lines;
use Chrisyue\PhpM3u8\Parser\DataBuilder;
use Chrisyue\PhpM3u8\Parser\Parser;
use Chrisyue\PhpM3u8\Stream\StreamInterface;

class ParserFacade
{
    private $parser;

    public function parse(StreamInterface $stream)
    {
        if (null === $this->parser) {
            $rootPath = realpath(__DIR__.'/../..');
            $tagDefinitions = new TagDefinitions(require $rootPath.'/resources/tags.php');

            $this->parser = new Parser(
                $tagDefinitions,
                new Config(require $rootPath.'/resources/tagValueParsers.php'),
                new DataBuilder()
            );
        }

        return $this->parser->parse(new Lines($stream));
    }
}
