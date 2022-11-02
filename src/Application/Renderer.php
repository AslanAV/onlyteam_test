<?php

namespace App\Application\Renderer;

function render($filepath, $params = [])
{
    $templatePath = __DIR__. '/../' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filepath . '.phtml';
    return \App\Template\render($templatePath, $params);
}
