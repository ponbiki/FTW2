<?php

$app->get('/user/conf/save', function () use ($app) {
    
    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }
    
    $_SESSION['conf']->unsaved = \FALSE;
    
    $app->redirect('/user/conf/basconf');
    
});