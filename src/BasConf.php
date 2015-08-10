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
            foreach ($file_array as $index => $value) {
                if (preg_match('/^\$name\s*=/', $value)) {
                    preg_match('/[\'|\"](.*)[\'|\"]/', $value, $name);
                    $confvals['name'] = $name[1];
                } elseif (preg_match('/^\$hostname\[\]\s*=/', $value)) {
                    preg_match('/[\'|\"](.*)[\'|\"]/', $value, $hostname);
                    $confvals['hostname'][] = $hostname[1];
                } elseif (preg_match('/^\$sslhostname\[\]\s*=/', $value)) {
                    preg_match('/[\'|\"](.*)[\'|\"]/', $value, $sslhostname);
                    $confvals['sslhostname'][] = $sslhostname[1];
                } elseif (preg_match('/^\$checkurl\s*=/', $value)) {
                    preg_match('/[\'|\"](.*)[\'|\"]/', $value, $checkurl);
                    $confvals['checkurl'] = $checkurl[1];
                } elseif (preg_match('/^\$checkhost\s*=/', $value)) {
                    preg_match('/[\'|\"](.*)[\'|\"]/', $value, $checkhost);
                    $confvals['checkhost'] = $checkhost[1];
                } elseif (preg_match('/^\$origin\[[\'|\"].*[\'|\"]\]\s*=/', $value)) {
                    preg_match('/\[[\'|\"](.*)[\'|\"]\]/', $value, $origin_id);
                    preg_match('/=\s*[\'|\"](.*)[\'|\"]/', $value, $server);
                    $confvals['origin'][$origin_id[1]] = $server[1];
                }
            }
            return $confvals;
        }
    }

    public static function writeConf($conf)
    {
        //;
    }

}
