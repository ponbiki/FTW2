<?php
namespace ponbiki\FTW;

class Session {

    public $username;
    public $loggedin;
    public $admin;

    public function __construct()
    {
        ini_set('session.use_only_cookies', true);
        session_start();
        if (!isset($_SESSION['generated']) || $_SESSION['generated'] <  (time() - 30)) {
            session_regenerate_id();
            $_SESSION['generated'] = time();
        }

        if (isset($_SESSION['user'])) {
            $this->username = $_SESSION['user'];
            $this->loggedin = TRUE;
        } else {
            $this->loggedin = FALSE;
        }

        if (isset($_SESSION['admin'])) {
            $this->admin = TRUE;
        } else {
            $this->admin = FALSE;
        }
    }
}
