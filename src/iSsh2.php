<?php

namespace ponbiki\FTW;

interface iSsh2 
{
    public function exec($command);
    public function scpRec($remote_file, $local_file);
    public function scpSend($local_file, $remote_file);
}
