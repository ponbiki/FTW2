<?php

namespace ponbiki\FTW;

interface iDatabase
{
    public function auth($cred);
    public function confAvail($company);
}
