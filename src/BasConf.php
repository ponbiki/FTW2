<?php

namespace ponbiki\FTW;

class BasConf implements iConf
{
    public static function loadConf($conf) 
    {
        if (!$tmp = file("../tmp/pools/default/configs/$conf")) {
            throw new Exception("There was an issue loading $conf");
        } else {
            return $tmp;
        }
    }

    public static function writeConf($conf)
    {
        //;
    }

}
