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
        // if confpull method doesn't get pool some $_SESSION['error']
        //$app->redirect('/user/menu');
    }

    if ($_SESSION['conftype'][$conf] === 'bas') {
        $file_array = ftw\BasConf::loadConf($conf);
        $_SESSION['confselected'] = $conf;
        $_SESSION[$conf] = $file_array;
        $app->redirect('/user/menu/conf/basconf');
    } elseif ($_SESSION['conftype'][$conf] === 'adv') {
        //some stuff;
    }
    
    //$app->redirect('/user/menu');
});