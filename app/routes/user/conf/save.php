<?php

$app->get('/user/conf/save', function () use ($app) {
    
    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }
    
    $_SESSION['conf']->writeConf($_SESSION['conf']->confselected);
    $_SESSION['conf']->unsaved = \FALSE;
    $_SESSION['info'][] = "Configuration has been saved!";
    
    $app->redirect('/user/conf/basconf');
    
});