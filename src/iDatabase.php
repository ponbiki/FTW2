<?php

namespace ponbiki\FTW;

interface iDatabase
{
    public function auth($user, $pass);
    public function confAvail();
    public function userOption();
    public function confBackup($conf, $file);
}
