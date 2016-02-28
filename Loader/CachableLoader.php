<?php

namespace Chrisyue\PhpM3u8\Loader;

class CachableLoader extends AbstractCachableLoader
{
    protected function loadContent($uri)
    {
        $content = @file_get_contents($uri, null, stream_context_create([
            'http' => [
                'timeout' => 10,
            ],
        ]));

        if (false === $content) {
            throw new \Exception(sprintf('The m3u8 uri %s cannot be loaded', $uri));
        }

        return $content;
    }
}
