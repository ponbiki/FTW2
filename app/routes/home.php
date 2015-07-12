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
    $app->render('home.html.twig', [
        'page' => 'FTW Log In',
        'meta' => ''
    ]);
})->name('home');

$app->post('/', function () use ( $app ) {

    $user = filter_var(($app->request()->post('user')), FILTER_SANITIZE_STRING);
    $pass = filter_var(($app->request()->post('pass')), FILTER_SANITIZE_STRING);

    if ($user == "" || $pass == "") {
        $error[] = "Not all fields were entered";
    } else {
        $token = password_hash($pass, PASSWORD_DEFAULT);
        //default cost of 10 left in place although the jail ideally would use a cost of 9
        $con = new ftw\Database();
        print_r($con->auth($user,$token));

    }


});