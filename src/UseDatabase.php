<?php

namespace ponbiki\FTW;

use ponbiki\FTW as ftw;

class UseDatabase
{
    public function __construct()
    {
        $this->db = new ftw\Database();
    }

    public function doAuth(ftw\iDatabase $cred)
    {
        $this->db->auth($cred);
    }

    public function doConfAvail(ftw\iDatabase $company)
    {
        $this->db->confAvail($company);
    }
}
