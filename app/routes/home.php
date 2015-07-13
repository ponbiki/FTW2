<?php

use ponbiki\FTW as ftw;

new ftw\Session();

if ($loggedin) {
    if ($admin) {
        $app->get('/adminmenu', function () use ($app) {
            $app->render('admin/adminmenu.html.twig', []);
        })->name('admin.adminmenu');
    } else {
        $app->get('/menu', function () use ($app) {
            $app->render('user/menu.html.twig', []);
        })->name('user.menu');
    }
}

$app->get('/', function() use ($app) {

    $page = "FTW Log In";
    $meta = "";

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
        $_SESSION['error'][] = $con->auth($user, $pass);
        $app->redirect('/');
    }
});