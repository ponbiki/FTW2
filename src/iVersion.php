<?php

namespace ponbiki\FTW;

interface iVersion
{
    public function chkVersion();
    public function pull();
    public function commit();
    public function push();
}