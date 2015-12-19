<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/conf/addom', function () use ($app) {
    
    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }
    
    $new_dom = \filter_var(($app->request()->post('newhost')), FILTER_SANITIZE_STRING);
    
    if (!in_array($new_dom, $_SESSION[$_SESSION['confselected']]['hostname'])) {
        $_SESSION['error'][] = "This domain is already added";
    }
    
    $app->redirect('/user/conf/basconf');
    
});