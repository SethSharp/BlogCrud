<?php

namespace SethSharp\BlogCrud\Support\Editor\Nodes;

use SethSharp\BlogCrud\Support\Editor\Node;

class Image extends Node
{
    protected static string $tag = 'image';

    public static function buildHtmlTag(): string
    {
        return self::$prefix . '-' . self::$tag;
    }

    public static function getReplacementTag(): string
    {
        return 'img';
    }
}
