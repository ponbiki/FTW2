<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/conf/addom', function () use ($app) {
    
    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }
    
    $doms_in = \filter_var(($app->request()->post('newhost')), FILTER_SANITIZE_STRING);
    
    $doms = ftw\BasConf::splitHosts($doms_in);
    
    foreach ($doms as $dom) {
        if (empty($dom)) {
            $_SESSION['error'][] = "No domains were entered!";
        } elseif (in_array($dom, $_SESSION['conf']->confvals['hostname'])) {
            $_SESSION['error'][] = "$dom is already being accelerated by FTW!";
        } elseif (ftw\BasConf::hostValidator($dom) === FALSE) {
            $_SESSION['error'][] = "$dom is an invalid domain format!";
        } else {
            $_SESSION['info'][] = "$dom has been added to FTW!";
        }
    }
    
    $app->redirect('/user/conf/basconf');
    
});