<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->get('/user/menu', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    $con = new ftw\Database();
    if (!$_SESSION['error'][] = $con->confAvail()) {
        unset($_SESSION['error']);
        $confs = $_SESSION['confs'];
    }
    $page = "Menu";
    $meta = "User Menu";
    $user[] = $_SESSION['user'];

    $app->render('user/menu.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        'confs' => $confs,
        'user' => $user
    ]);

    unset($_SESSION['error']);
    unset($_SESSION['info']);

})->name('user.menu');