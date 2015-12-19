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
                if (\preg_match('/^\$name\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $name);
                    $confvals['name'] = $name[1];
                } elseif (\preg_match('/^\$hostname\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $hostname);
                    $confvals['hostname'][] = $hostname[1];
                } elseif (\preg_match('/^\$sslhostname\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $sslhostname);
                    $confvals['sslhostname'][] = $sslhostname[1];
                } elseif (\preg_match('/^\$checkurl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkurl);
                    $confvals['checkurl'] = $checkurl[1];
                } elseif (\preg_match('/^\$checkhost\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkhost);
                    $confvals['checkhost'] = $checkhost[1];
                } elseif (\preg_match('/^\$backend\[\]\s*=/', $value)) {
                    \preg_match('/\(\s*[\'"]?ip[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $ip);
                    \preg_match('/,\s*[\'"]?port[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $port);
                    \preg_match('/,\s*[\'"]?sport[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $sport);
                    \preg_match('/,\s*[\'"]?weight[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $weight);
                    \preg_match('/,\s*[\'"]?maxconn[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*\)/', $value, $maxconn);
                    $confvals['backend'][] = ['ip' => $ip[1], 'port' => $port[1], 'sport' => $sport[1], 'weight' => $weight[1], 'maxconn' => $maxconn[1]];
                } elseif (\preg_match('/^\$origin\[[\'\"].*[\'\"]\]\s*=/', $value)) {
                    \preg_match('/\[[\'"](.*)[\'"]\]/', $value, $origin_id);
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server);
                    $confvals['origin'][$origin_id[1]] = $server[1];
                } elseif (\preg_match('/^\$server_to\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server_to);
                    $confvals['server_to'] = $server_to[1];
                } elseif (\preg_match('/^\$probe_to\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $probe_to);
                    $confvals['probe_to'] = $probe_to[1];
                } elseif (\preg_match('/^\$ssd\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ssd);
                    $confvals['ssd'] = $ssd[1];
                } elseif (\preg_match('/^\$ddos\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ddos);
                    $confvals['ddos'] = $ddos[1];
                } elseif (\preg_match('/^\$limit_error\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_error);
                    $confvals['limit_error'] = $limit_error[1];
                } elseif (\preg_match('/^\$limit_post\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_post);
                    $confvals['limit_post'] = $limit_post[1];
                } elseif (\preg_match('/^\$varnish_pool\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $varnish_pool);
                    $confvals['varnish_pool'] = $varnish_pool[1];
                } elseif (\preg_match('/^\$static_ttl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $static_ttl);
                    $confvals['static_ttl'] = $static_ttl[1];
                } elseif (\preg_match('/^\$dynamic_ttl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $dynamic_ttl);
                    $confvals['dynamic_ttl'] = $dynamic_ttl[1];
                } elseif (\preg_match('/^\$keep\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $keep);
                    $confvals['keep'] = $keep[1];
                } elseif (\preg_match('/^\$use_device_global\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device_global);
                    $confvals['use_device_global'] = $use_device_global[1];
                } elseif (\preg_match('/^\$use_device\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device);
                    $confvals['use_device'][] = $use_device[1];
                } elseif (\preg_match('/^\$zone\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $zone);
                    $confvals['zone'] = $zone[1];
                } elseif (\preg_match('/^\$pool\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $pool);
                    $confvals['pool'] = $pool[1];
                } elseif (\preg_match('/^\/\/\$/', $value)) {
                    $value = str_replace("//", "", $value);
                    if (\preg_match('/^\$name\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $name);
                        $confvals['disabled']['name'] = $name[1];
                    } elseif (\preg_match('/^\$hostname\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $hostname);
                        $confvals['disabled']['hostname'][] = $hostname[1];
                    } elseif (\preg_match('/^\$sslhostname\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $sslhostname);
                        $confvals['disabled']['sslhostname'][] = $sslhostname[1];
                    } elseif (\preg_match('/^\$checkurl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkurl);
                        $confvals['disabled']['checkurl'] = $checkurl[1];
                    } elseif (\preg_match('/^\$checkhost\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkhost);
                        $confvals['disabled']['checkhost'] = $checkhost[1];
                    } elseif (\preg_match('/^\$backend\[\]\s*=/', $value)) {
                        \preg_match('/\(\s*[\'"]?ip[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $ip);
                        \preg_match('/,\s*[\'"]?port[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $port);
                        \preg_match('/,\s*[\'"]?sport[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $sport);
                        \preg_match('/,\s*[\'"]?weight[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $weight);
                        \preg_match('/,\s*[\'"]?maxconn[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*\)/', $value, $maxconn);
                        $confvals['disabled']['backend'][] = ['ip' => $ip[1], 'port' => $port[1], 'sport' => $sport[1], 'weight' => $weight[1], 'maxconn' => $maxconn[1]];
                    } elseif (\preg_match('/^\$origin\[[\'\"].*[\'\"]\]\s*=/', $value)) {
                        \preg_match('/\[[\'"](.*)[\'"]\]/', $value, $origin_id);
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server);
                        $confvals['disabled']['origin'][$origin_id[1]] = $server[1];
                    } elseif (\preg_match('/^\$server_to\s*=/', $value)) {
                        \preg_match('/\=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server_to);
                        $confvals['disabled']['server_to'] = $server_to[1];
                    } elseif (\preg_match('/^\$probe_to\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $probe_to);
                        $confvals['disabled']['probe_to'] = $probe_to[1];
                    } elseif (\preg_match('/^\$ssd\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ssd);
                        $confvals['disabled']['ssd'] = $ssd[1];
                    } elseif (\preg_match('/^\$ddos\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ddos);
                        $confvals['disabled']['ddos'] = $ddos[1];
                    } elseif (\preg_match('/^\$limit_error\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_error);
                        $confvals['disabled']['limit_error'] = $limit_error[1];
                    } elseif (\preg_match('/^\$limit_post\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_post);
                        $confvals['disabled']['limit_post'] = $limit_post[1];
                    } elseif (\preg_match('/^\$varnish_pool\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $varnish_pool);
                        $confvals['disabled']['varnish_pool'] = $varnish_pool[1];
                    } elseif (\preg_match('/^\$static_ttl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $static_ttl);
                        $confvals['disabled']['static_ttl'] = $static_ttl[1];
                    } elseif (\preg_match('/^\$dynamic_ttl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $dynamic_ttl);
                        $confvals['disabled']['dynamic_ttl'] = $dynamic_ttl[1];
                    } elseif (\preg_match('/^\$keep\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $keep);
                        $confvals['disabled']['keep'] = $keep[1];
                    } elseif (\preg_match('/^\$use_device_global\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device_global);
                        $confvals['disabled']['use_device_global'] = $use_device_global[1];
                    } elseif (\preg_match('/^\$use_device\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device);
                        $confvals['disabled']['use_device'][] = $use_device[1];
                    } elseif (\preg_match('/^\$zone\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $zone);
                        $confvals['disabled']['zone'] = $zone[1];
                    } elseif (\preg_match('/^\$pool\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $pool);
                        $confvals['disabled']['pool'] = $pool[1];
                    }
                }
            }
            return $confvals;
        }
    }
    
    public static function jsonConfLoader() {
        return \json_encode($_SESSION[$_SESSION['confselected']]);
    }
    
    public static function splitHosts($hosts) {
        $splitter = '/\s+/';
        return \preg_split($splitter, $hosts);
    }
    
    public static function hostValidator($host) {
        $host_validate = '/([0-9a-z-]+\.)?[0-9a-z-]+\.[a-z]{2,7}/';
        if (!\preg_match($host_validate, $host)) {
            return \FALSE;
        } else {
            return \TRUE;
        }
    }

    public static function writeConf($conf)
    {
        //todo;
    }

}
