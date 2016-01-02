<?php

//use ponbiki\FTW as ftw;

$app->post('/user/conf/deldom', function () use ($app) {
    
    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }
    
    if (\count($app->request()->post('deldomain')) <= 0) {
        $_SESSION['error'][] = "No domains were selected for deletion!";
        $app->redirect('/user/conf/basconf');
    } else {
        $doms_out = \filter_var_array(($app->request()->post('deldomain')), FILTER_SANITIZE_STRING);
    }
    
    if (\count($doms_out) == \count($_SESSION['conf']->confvals['hostname'])) {
        $_SESSION['error'][] = "You cannot remove all domains from you configuration!";
        $app->redirect('/user/conf/basconf');
    } 

    foreach ($doms_out as $dom) {
        if (!in_array($dom, $_SESSION['conf']->confvals['hostname'])) {
            $_SESSION['error'][] = "$dom is not an accelerated domain, and cannot be deleted!";
        } else {
            $_SESSION['conf']->delDomain($dom);
            $_SESSION['info'][] = "Domain $dom has been removed!";
        }
    }
    
    $app->redirect('/user/conf/basconf');
    
});