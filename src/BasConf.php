<?php

namespace ponbiki\FTW;

use ponbiki\FTW as ftw;

class BasConf implements iConf
{

    public static function loadConf($conf) 
    {
        if (!$file = file_get_contents("../tmp/pools/default/configs/$conf")) {
            throw new Exception("There was an issue loading $conf");
        } else {
            $con = new ftw\Database();
            $con->confBackup($conf, $file);
            $file_array = explode(PHP_EOL, $file);
            return $file_array;
        }
    }

    public static function writeConf($conf)
    {
        //;
    }

}
