<?php

namespace sethsharp\Support\Nodes;

use sethsharp\Support\Node;

class Image extends Node
{
    protected static string $tag = 'image';

    public static function buildHtmlTag(): string
    {
        return self::$prefix . '-' . self::$tag;
    }

    public static function getReplaceTag(): string
    {
        return 'img';
    }
}
