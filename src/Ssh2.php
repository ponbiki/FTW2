<?php

namespace ponbiki\FTW;

class Ssh2 implements iSsh2
{
    private $server =  'blah';
    private $port   =  22;
    private $ssh_user = 'blah';
    private $ssh_pass = 'blah';
    protected $con;
    protected $file_perm = 0644;

    public function __construct()
    {
        $this->con = $this->connect();
    }

    protected function connect() 
    {
        if (!$this->con = ssh2_connect($this->server, $this->port)) {
            throw new \Exception('Failed to establish connection');
        } else {
            if (!ssh2_auth_password($this->con, $this->ssh_user, $this->ssh_pass)) {
               	throw new \Exception('Failed to authenticate');
            }
        }
    }

    public function exec($command)
    {
     	if (!$stream = ssh2_exec($this->con, $command)) {
            throw new \Exception('Unable to execute command');
        } else {
            stream_set_blocking($stream, true);
            $data = '';
            while ($buf = fread($stream, 4096)) {
                $data .= $buf;
            }
            fclose($stream);
            return $data;
        }
    }

    public function scpRecv($remote_file, $local_file)
    {
        if (!$inifile = ssh2_scp_recv($this->con, $remote_file, $local_file)) {
            throw new \Exception('Unable to retrieve file');
        }
    }

    public function scpSend($local_file, $remote_file)
    {
        if (!ssh2_scp_send($this->con, $local_file, $remote_file, $this->file_perm)) {
            throw new \Exception('Failed to send file');
        }
    }

    protected function disconnect()
    {
     	ssh2_exec($this->con, 'exit');
        unset($this->con);
    }

    public function __destruct()
    {
     	$this->disconnect();
    }
}
