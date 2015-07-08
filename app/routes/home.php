<?php

use ponbiki\FTW;

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

$app->post('/', function() use ($app) {

	$app->render('home.html.twig', []);

})->name('home');