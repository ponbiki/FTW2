<?php
namespace ponbiki\FTW;

class Session {
    public function __construct()
    {
        ini_set('session.use_only_cookies', true);
        session_start();
        if (!isset($_SESSION['generated']) || $_SESSION['generated'] <  (time() - 30)) {
            session_regenerate_id();
            $_SESSION['generated'] = time();
        }

        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
            $loggedin = TRUE;
        } else {
            $loggedin =FALSE;
        }

        if (isset($_SESSION['admin'])) {
            $admin = TRUE;
        } else {
            $admin = FALSE;
        }
    }
}
