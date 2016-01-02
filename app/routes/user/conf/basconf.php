<?php

use ponbiki\FTW as ftw;

$app->get('/user/conf/basconf', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    $page = "Configuration Edit";
    $meta = "Configuration Edit";
    $domains = $_SESSION['conf']->confvals['hostname'];
    $unsaved = $_SESSION['conf']->unsaved;
            
    $app->render('user/conf/basconf.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'domains' => $domains,
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        'unsaved' => $unsaved
    ]);

    ftw\Session::clear();

})->name('user.conf.basconf');