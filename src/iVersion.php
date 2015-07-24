<?php

namespace ponbiki\FTW;

interface iVersion
{
    public static function chkVersions();
    public static function pull();
    public static function commit();
    public static function push();
}