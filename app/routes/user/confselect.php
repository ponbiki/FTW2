<?php

use ponbiki\FTW as ftw;

new ftw\Session();

$app->post('/user/confselect', function () use ($app) {

    if ($_SESSION['loggedin'] !== TRUE) {
        $app->redirect('/');
    }


    $conf = filter_var(($app->request()->post('conf')), FILTER_SANITIZE_STRING);

    if (!in_array($conf, $_SESSION['confs'])) {
        $_SESSION['error'][] = "Please select a valid configuration file";
        $app->redirect('/user/menu');
    } else {
        if (ftw\Version::chkVersions() !== TRUE) {
            ftw\Version::pull();
            // if confpull method gets no conf file some error
            // else cp to a dated stored backup
            // (probably in sql order by date hold 5
            // then delete oldest and add new thereafter)
            // as well as a working copy for regex attack
        }
    }

    $_SESSION[info][] = "It worked";
    $app->redirect('/user/menu');

});