<?php
$name='warblegarble.com';
$hostname[]='warblegarble.com'; // These are required in the default pool
$checkurl='/';
$checkhost='www.warblegarble.com';
$backend[]=array(ip => '192.152.22.236', port => 80, sport => 443, weight => 50, maxconn => 50);
$origin['global']='ny1';
$server_to='800';
$probe_to='10';
$ssd='0';
$ddos='1';
$limit_error='18';
$limit_post='28';
//$static_ttl='bignum';
$dynamic_ttl='10m';
$keep='1h';
?>