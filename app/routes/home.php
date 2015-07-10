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

    

    var_dump($app->request()->post('user'));
    var_dump($app->request()->post('pass'));
});