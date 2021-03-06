<?php

namespace ponbiki\FTW;

interface iConf
{
    const tmp_path = "../tmp/pools/default/configs/";    
    
    public function loadConf($conf);
    public static function jsonConfLoader();
    public static function splitHosts($hosts);
    public static function hostValidator($host);
    public function addDomain($domain);
    public function delDomain($domain);
    public function writeConf($conf);
}
