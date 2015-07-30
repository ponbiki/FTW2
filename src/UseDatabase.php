<?php

namespace ponbiki\FTW;

use ponbiki\FTW as ftw;

class UseDatabase
{
    public function __construct()
    {
        $this->db = new ftw\Database();
    }

    public function doAuth(ftw\iDatabase $user, $pass)
    {
        $this->db->auth($user, $pass);
    }

    public function doConfAvail()
    {
        $this->db->confAvail;
    }
}
