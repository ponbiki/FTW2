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

    ftw\Session::clear();

})->name('home');

$app->post('/', function () use ($app) {

    $cred['user'] = filter_var(($app->request()->post('user')), FILTER_SANITIZE_STRING);
    $cred['pass'] = filter_var(($app->request()->post('pass')), FILTER_SANITIZE_STRING);

    if ($cred['user'] == "" || $cred['pass'] == "") {
        $_SESSION['error'][] = "Not all fields were entered";
        $app->redirect('/');
    } else {
        $con = new ftw\UseDatabase();
        if (!$_SESSION['error'][] = $con->doAuth($cred)) {
            if ($_SESSION['admin'] === TRUE) {
                $app->redirect('/admin/menu');
            } elseif ($_SESSION['loggedin'] === TRUE) {
                ftw\Session::clear();
                $app->redirect('/user/menu');
            }
        } else {
            $app->redirect('/');
        }
    }
});