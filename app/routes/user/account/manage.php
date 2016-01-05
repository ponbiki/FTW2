<?php

use ponbiki\FTW as ftw;

$app->post('/user/account/manage', function() use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    $con = new ftw\Database();
    $con->confAvail();
    $page = "Manage User";
    $meta = "User Management";
    $user = $con->userOption();
    if ($_SESSION['useradmin'] === TRUE) {
        $usradm = \TRUE;
    } else {
        unset($usradm);
    }
    
    $app->render('user/menu.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'loggedin' => $_SESSION['loggedin'],
        'error' => $_SESSION['error'],
        'info' => $_SESSION['info'],
        'usradm' => $usradm,
        'user' => $user
    ]);

    ftw\Session::clear();

})->name('user.account.manage');