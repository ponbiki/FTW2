<?php

namespace ponbiki\FTW;

interface iConf
{
    public static function loadConf($conf);
    public static function writeConf($conf);
}
