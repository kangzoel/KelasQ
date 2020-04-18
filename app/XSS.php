<?php

namespace App;

use \HTMLPurifier;
use \HTMLPurifier_Config;

class XSS {
    public static function clean(String $text)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify(nl2br($text));

        return "<span class='clean_html'>$clean_html</span>";
    }
}
