<?php

namespace ponbiki\FTW;

class Version implements iVersion
{
    public static function chkVersions()
    {
        //returns TRUE if master and workspace are at the same ver
        //returns FALSE if master and workspace are not at the same ver
    }

    public static function pull()
    {
        //pulls latest master to local workspace
    }

    public static function commit()
    {
        //commits latest change in workspace
    }

    public static function push()
    {
        //pushes latest commit to master
    }
}