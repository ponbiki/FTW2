<?php

use ponbiki\FTW as ftw;

$app->get('/user/menu', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    $con = new ftw\Database();
    $con->confAvail();
    $page = "Menu";
    $meta = "User Menu";
    $user = $con->userOption();

    $app->render('user/menu.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        'confs' => $_SESSION['confs'],
        'user' => $user
    ]);

    ftw\Session::clear();

})->name('user.menu');