<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8;

abstract class AbstractContainer implements DumpableInterface
{
    public function readLines(array &$lines)
    {
        foreach ($this->getComponents() as $component) {
            if (empty($lines)) {
                break;
            }

            $component->readLines($lines);
        }
    }

    public function dump()
    {
        $lines = array_map(function (DumpableInterface $dumper) {
            return $dumper->dump();
        }, $this->getComponents());

        return implode("\n", array_filter($lines));
    }

    abstract protected function getComponents();
}
