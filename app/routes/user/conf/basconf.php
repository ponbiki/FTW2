<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->get('/user/conf/basconf', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    $page = "Configuration Edit";
    $meta = "Configuration Edit";

    $app->render('user/conf/basconf.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        
    ]);

    ftw\Session::clear();

})->name('user.conf.basconf');