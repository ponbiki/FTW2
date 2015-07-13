<?php

use ponbiki\FTW as ftw;

new ftw\Session();

if ($loggedin) {
    if ($admin) {
        $app->redirect('/admin/menu');
    } else {
        $app->redirect('/user/menu');
    }
}

$app->get('/', function() use ($app) {

    $page = "FTW Log In";
    $meta = "Login";

    $app->render('home.html.twig', [
        'page' => $page,
        'meta' => $meta,
        'error' => $_SESSION['error']
    ]);
    
    unset($_SESSION['error']);
    
})->name('home');

$app->post('/', function () use ( $app ) {

    $user = filter_var(($app->request()->post('user')), FILTER_SANITIZE_STRING);
    $pass = filter_var(($app->request()->post('pass')), FILTER_SANITIZE_STRING);

    if ($user == "" || $pass == "") {
        $_SESSION['error'][] = "Not all fields were entered";
        $app->redirect('/');
    } else {
        $con = new ftw\Database();
        if (!$_SESSION['error'][] = $con->auth($user, $pass)) {
            if ($_SESSION['admin'] === 'y') {
                $app->redirect('/admin/menu');
            } else {
                $app->redirect('/user/menu');
            }
        } else {
            $app->redirect('/');
        }
    }
});