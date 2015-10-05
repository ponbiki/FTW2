<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->get('/user/conf/basconf', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    echo "<pre>";print_r($_SESSION);echo "</pre>";

    $con = new ftw\Database();
    $con->confAvail();
    $page = "Configuration Edit";
    $meta = "Configuration Edit";
    $user[] = $_SESSION['user'];

    $app->render('user/conf/basconf.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        'confs' => $_SESSION['confs'],
        'user' => $user
    ]);

    ftw\Session::clear();

})->name('user.conf.basconf');