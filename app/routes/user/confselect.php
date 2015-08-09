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
    } elseif (ftw\Version::chkVersions() !== TRUE) {
        ftw\Version::pull();
        // if confpull method gets no conf file some $_SESSION['error']
        //$app->redirect('/user/menu');
    }

    if ($_SESSION['conftype'][$conf] === 'bas') {
        $tmp = ftw\BasConf::loadConf($conf);
    } elseif ($_SESSION['conftype'][$conf] === 'adv') {
        //some stuff;
    }

    $_SESSION['sql'] = $tmp;
    $_SESSION['info'][] = $_SESSION['conftype'][$conf];
    $app->redirect('/user/menu');
});