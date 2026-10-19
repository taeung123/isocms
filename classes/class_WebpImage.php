<?php

use WebPConvert\WebPConvert;

class WebpImage
{
    function __construct()
    {
        // Some code
    }
    //$source = ABSPATH.'/uploads/VietISO/anh-30.jpg';
    //$destination = $source . '.webp';
    //$options = [];
    //WebPConvert::convert($source, $destination, $options);

    function ConvertWebpImage($source)
    {
        $source_dir = $_SERVER['DOCUMENT_ROOT'] . $source;
        $source_webp = '/Webp' . $source . '.webp';
        $destination = $_SERVER['DOCUMENT_ROOT'] . '/Webp' . $source . '.webp';
        if (!empty(getimagesize($source_dir))) {
            $options = [];
            WebPConvert::convert($source_dir, $destination, $options);
            return $source_webp;
        }
        return $source;
    }
}
