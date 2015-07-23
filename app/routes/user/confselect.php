<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/confselect', function () use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }


    $conf = filter_var(($app->request()->post('conf')), FILTER_SANITIZE_STRING);
        

    $_SESSION[info][] = "It worked";
    $app->redirect('/user/menu');

});