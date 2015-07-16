<?php

use ponbiki\FTW as ftw;

$app->get('/logout', function() use ($app) {

    ftw\Session::logout();

    $app->redirect('/');

});
