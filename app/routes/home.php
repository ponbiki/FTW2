<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->get('/', function() use ($app) {
    
    if ($_SESSION['loggedin']) {
        if ($_SESSION['admin']) {
            $app->redirect('/admin/menu');
        } else {
            $app->redirect('/user/menu');
        }
    }

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
            if ($_SESSION['admin'] === TRUE) {
                $app->redirect('/admin/menu');
            } elseif ($_SESSION['loggedin'] === TRUE) {
                $app->redirect('/user/menu');
            }
        } else {
            $app->redirect('/');
        }
    }
});