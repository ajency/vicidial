<?php

function config_path($path = '')
{
    return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
}