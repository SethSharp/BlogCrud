<?php

namespace SethSharp\BlogCrud\Support\Editor;

abstract class Node
{
    public static string $prefix = 'tt';
    protected static string $tag;

    abstract public static function buildHtmlTag(): string;
    abstract public static function getReplacementTag(): string;
}
