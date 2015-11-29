<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/conf/addom', function () use ($app) {
    
    $app->redirect('/user/conf/basconf');
    
});