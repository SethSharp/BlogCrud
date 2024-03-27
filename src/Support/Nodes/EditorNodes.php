<?php

namespace SethSharp\BlogCrud\Support\Editor\Nodes;

use SethSharp\BlogCrud\Support\Editor\Components;
use SethSharp\BlogCrud\Support\Editor\Nodes\Image;

class EditorNodes extends Components
{
    public static array $components = [
        Image::class,
    ];
}
