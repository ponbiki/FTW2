<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/menu/', function () use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }

    if (isset($_POST['conf'])) {
        if (!in_array($_POST['conf'], $_SESSION['confs'])) {
            $_SESSION['error'][] = "Please select a valid configuration file.";
        }
    }
});