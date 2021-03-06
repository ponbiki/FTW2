<?php

namespace ponbiki\FTW;

use ponbiki\FTW as ftw;

class BasConf implements iConf
{
    
    public $confselected;
    public $confvals;
    public $unsaved;
    
    public function __construct($conf)
    {
        $this->confselected = $conf;
        $this->unsaved = \FALSE;
        return $this->loadConf($conf);
    }

    public function loadConf($conf) 
    {
        if (!$file = \file_get_contents(iConf::tmp_path . $conf)) {
            throw new \Exception("There was an issue loading $conf");
        } else {
            $con = new ftw\Database();
            $con->confBackup($conf, $file);
            $file_array = explode(PHP_EOL, $file);
            foreach ($file_array as $value) {
                if (\preg_match('/^\$name\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $name);
                    $this->confvals['name'] = $name[1];
                } elseif (\preg_match('/^\$hostname\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $hostname);
                    $this->confvals['hostname'][] = $hostname[1];
                } elseif (\preg_match('/^\$sslhostname\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $sslhostname);
                    $this->confvals['sslhostname'][] = $sslhostname[1];
                } elseif (\preg_match('/^\$checkurl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkurl);
                    $this->confvals['checkurl'] = $checkurl[1];
                } elseif (\preg_match('/^\$checkhost\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkhost);
                    $this->confvals['checkhost'] = $checkhost[1];
                } elseif (\preg_match('/^\$backend\[\]\s*=/', $value)) {
                    \preg_match('/\(\s*[\'"]?ip[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $ip);
                    \preg_match('/,\s*[\'"]?port[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $port);
                    \preg_match('/,\s*[\'"]?sport[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $sport);
                    \preg_match('/,\s*[\'"]?weight[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $weight);
                    \preg_match('/,\s*[\'"]?maxconn[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*\)/', $value, $maxconn);
                    $this->confvals['backend'][] = ['ip' => $ip[1], 'port' => $port[1], 'sport' => $sport[1], 'weight' => $weight[1], 'maxconn' => $maxconn[1]];
                } elseif (\preg_match('/^\$origin\[[\'\"].*[\'\"]\]\s*=/', $value)) {
                    \preg_match('/\[[\'"](.*)[\'"]\]/', $value, $origin_id);
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server);
                    $this->confvals['origin'][$origin_id[1]] = $server[1];
                } elseif (\preg_match('/^\$server_to\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server_to);
                    $this->confvals['server_to'] = $server_to[1];
                } elseif (\preg_match('/^\$probe_to\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $probe_to);
                    $this->confvals['probe_to'] = $probe_to[1];
                } elseif (\preg_match('/^\$ssd\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ssd);
                    $this->confvals['ssd'] = $ssd[1];
                } elseif (\preg_match('/^\$ddos\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ddos);
                    $this->confvals['ddos'] = $ddos[1];
                } elseif (\preg_match('/^\$limit_error\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_error);
                    $this->confvals['limit_error'] = $limit_error[1];
                } elseif (\preg_match('/^\$limit_post\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_post);
                    $this->confvals['limit_post'] = $limit_post[1];
                } elseif (\preg_match('/^\$varnish_pool\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $varnish_pool);
                    $this->confvals['varnish_pool'] = $varnish_pool[1];
                } elseif (\preg_match('/^\$static_ttl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $static_ttl);
                    $this->confvals['static_ttl'] = $static_ttl[1];
                } elseif (\preg_match('/^\$dynamic_ttl\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $dynamic_ttl);
                    $this->confvals['dynamic_ttl'] = $dynamic_ttl[1];
                } elseif (\preg_match('/^\$keep\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $keep);
                    $this->confvals['keep'] = $keep[1];
                } elseif (\preg_match('/^\$use_device_global\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device_global);
                    $this->confvals['use_device_global'] = $use_device_global[1];
                } elseif (\preg_match('/^\$use_device\[\]\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device);
                    $this->confvals['use_device'][] = $use_device[1];
                } elseif (\preg_match('/^\$zone\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $zone);
                    $this->confvals['zone'] = $zone[1];
                } elseif (\preg_match('/^\$pool\s*=/', $value)) {
                    \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $pool);
                    $this->confvals['pool'] = $pool[1];
                } elseif (\preg_match('/^\/\/\$/', $value)) {
                    $value = str_replace("//", "", $value);
                    if (\preg_match('/^\$name\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $name);
                        $this->confvals['disabled']['name'] = $name[1];
                    } elseif (\preg_match('/^\$hostname\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $hostname);
                        $this->confvals['disabled']['hostname'][] = $hostname[1];
                    } elseif (\preg_match('/^\$sslhostname\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $sslhostname);
                        $this->confvals['disabled']['sslhostname'][] = $sslhostname[1];
                    } elseif (\preg_match('/^\$checkurl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkurl);
                        $this->confvals['disabled']['checkurl'] = $checkurl[1];
                    } elseif (\preg_match('/^\$checkhost\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $checkhost);
                        $this->confvals['disabled']['checkhost'] = $checkhost[1];
                    } elseif (\preg_match('/^\$backend\[\]\s*=/', $value)) {
                        \preg_match('/\(\s*[\'"]?ip[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $ip);
                        \preg_match('/,\s*[\'"]?port[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $port);
                        \preg_match('/,\s*[\'"]?sport[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $sport);
                        \preg_match('/,\s*[\'"]?weight[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*,/', $value, $weight);
                        \preg_match('/,\s*[\'"]?maxconn[\'"]?\s*=>\s*[\'"]?(.*?)[\'"]?\s*\)/', $value, $maxconn);
                        $this->confvals['disabled']['backend'][] = ['ip' => $ip[1], 'port' => $port[1], 'sport' => $sport[1], 'weight' => $weight[1], 'maxconn' => $maxconn[1]];
                    } elseif (\preg_match('/^\$origin\[[\'\"].*[\'\"]\]\s*=/', $value)) {
                        \preg_match('/\[[\'"](.*)[\'"]\]/', $value, $origin_id);
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server);
                        $this->confvals['disabled']['origin'][$origin_id[1]] = $server[1];
                    } elseif (\preg_match('/^\$server_to\s*=/', $value)) {
                        \preg_match('/\=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $server_to);
                        $this->confvals['disabled']['server_to'] = $server_to[1];
                    } elseif (\preg_match('/^\$probe_to\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $probe_to);
                        $this->confvals['disabled']['probe_to'] = $probe_to[1];
                    } elseif (\preg_match('/^\$ssd\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ssd);
                        $this->confvals['disabled']['ssd'] = $ssd[1];
                    } elseif (\preg_match('/^\$ddos\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $ddos);
                        $this->confvals['disabled']['ddos'] = $ddos[1];
                    } elseif (\preg_match('/^\$limit_error\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_error);
                        $this->confvals['disabled']['limit_error'] = $limit_error[1];
                    } elseif (\preg_match('/^\$limit_post\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $limit_post);
                        $this->confvals['disabled']['limit_post'] = $limit_post[1];
                    } elseif (\preg_match('/^\$varnish_pool\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $varnish_pool);
                        $this->confvals['disabled']['varnish_pool'] = $varnish_pool[1];
                    } elseif (\preg_match('/^\$static_ttl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $static_ttl);
                        $this->confvals['disabled']['static_ttl'] = $static_ttl[1];
                    } elseif (\preg_match('/^\$dynamic_ttl\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $dynamic_ttl);
                        $this->confvals['disabled']['dynamic_ttl'] = $dynamic_ttl[1];
                    } elseif (\preg_match('/^\$keep\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $keep);
                        $this->confvals['disabled']['keep'] = $keep[1];
                    } elseif (\preg_match('/^\$use_device_global\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device_global);
                        $this->confvals['disabled']['use_device_global'] = $use_device_global[1];
                    } elseif (\preg_match('/^\$use_device\[\]\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $use_device);
                        $this->confvals['disabled']['use_device'][] = $use_device[1];
                    } elseif (\preg_match('/^\$zone\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $zone);
                        $this->confvals['disabled']['zone'] = $zone[1];
                    } elseif (\preg_match('/^\$pool\s*=/', $value)) {
                        \preg_match('/=\s*[\'"]?(.*?)[\'"]?\s*;/', $value, $pool);
                        $this->confvals['disabled']['pool'] = $pool[1];
                    }
                }
            }
            return $this->confvals;
        }
    }
    
    public static function jsonConfLoader() 
    {
        return \json_encode($_SESSION[$_SESSION['confselected']]);
    }
    
    public static function splitHosts($hosts) {
        $splitter = '/\s+/';
        return \preg_split($splitter, $hosts);
    }
    
    public static function hostValidator($host)
    {
        $host_validate = '/([0-9a-z-]+\.)?[0-9a-z-]+\.[a-z]{2,7}/';
        if (!\preg_match($host_validate, $host)) {
            return \FALSE;
        } else {
            return \TRUE;
        }
    }
    
    public function addDomain($domain)
    {
        $this->confvals['hostname'][] = $domain;
        $this->unsaved = \TRUE;
    }
    
    public function delDomain($domain)
    {
        unset($_SESSION['conf']->confvals['hostname'][\array_search($domain, $_SESSION['conf']->confvals['hostname'])]);
        $this->unsaved = \TRUE;
    }
    
    public function writeConf($conf)
    {
        $conf_string = "<?php\n";
        if ($this->confvals['name']) {
            $conf_string .= "\$name='{$this->confvals['name']}';\n";
        }
        if ($this->confvals['hostname']) {
            foreach ($this->confvals['hostname'] as $host) {
                $conf_string .= "\$hostname[]='$host';\n";
            }
        }
        if ($this->confvals['checkurl']) {
            $conf_string .= "\$checkurl='{$this->confvals['checkurl']}';\n";
        }
        if ($this->confvals['checkhost']) {
            $conf_string .= "\$checkhost='{$this->confvals['checkhost']}';\n";
        }
        if ($this->confvals['backend']) {
            foreach ($this->confvals['backend'] as $back) {
                $conf_string .= "\$backend[]=array('ip' => '{$back['ip']}', 'port' => '{$back['port']}',"
                . " 'sport' => '{$back['sport']}', 'weight' => '{$back['weight']}',"
                . " 'maxconn' => '{$back['maxconn']}');\n";
            }
        }
        if ($this->confvals['origin']) {
            foreach ($this->confvals[origin] as $key => $value) {
                $conf_string .= "\$origin['$key']='$value';\n";
            }
        }
        if ($this->confvals['server_to']) {
            $conf_string .= "\$server_to='{$this->confvals['server_to']}';\n";
        }
        if ($this->confvals['probe_to']) {
            $conf_string .= "\$probe_to='{$this->confvals['probe_to']}';\n";
        }
        if ($this->confvals['ssd']) {
            $conf_string .= "\$ssd='{$this->confvals['ssd']}';\n";
        }
        if ($this->confvals['ddos']) {
            $conf_string .= "\$ddos='{$this->confvals['ddos']}';\n";
        }
        if ($this->confvals['limit_error']) {
            $conf_string .= "\$limit_error='{$this->confvals['limit_error']}';\n";
        }
        if ($this->confvals['limit_post']) {
            $conf_string .= "\$limit_post='{$this->confvals['limit_post']}';\n";
        }
        if ($this->confvals['varnish_pool']) {
            $conf_string .= "\$varnish_pool='{$this->confvals['varnish_pool']}';\n";
        }
        if ($this->confvals['static_ttl']) {
            $conf_string .= "\$static_ttl='{$this->confvals['static_ttl']}';\n";
        }
        if ($this->confvals['dynamic_ttl']) {
            $conf_string .= "\$dynamic_ttl='{$this->confvals['dynamic_ttl']}';\n";
        }
        if ($this->confvals['keep']) {
            $conf_string .= "\$keep='{$this->confvals['keep']}';\n";
        }
        if ($this->confvals['use_device_global']) {
            $conf_string .= "\$use_device_global='{$this->confvals['use_device_global']}';\n";
        }
        if ($this->confvals['use_device']) {
            foreach ($this->confvals['use_device'] as $used) {
                $conf_string .= "\$use_device[]='$used';\n";
            }
        }
        if ($this->confvals['zone']) {
            $conf_string .= "\$zone='{$this->confvals['zone']}';\n";
        }
        if ($this->confvals['pool']) {
            $conf_string .= "\$pool='{$this->confvals['pool']}';\n";
        }
        if ($this->confvals['disabled']) {
            foreach ($this->confvals['disabled'] as $keyed => $valued) {
                $conf_string .= "//\$$keyed='$valued';\n";
            }
        }
        $conf_string .= "?>";
        if (!\unlink(iConf::tmp_path . $conf)) {
            throw new \Exception("There was an issue removing the existing working copy of $conf");
        } else {
            if (!\file_put_contents(iConf::tmp_path . $conf, $conf_string, LOCK_EX)) {
                throw new \Exception("There was an issue writing a new copy of $conf");
            }
        }
    }
}