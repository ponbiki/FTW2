<?php

namespace ponbiki\FTW;

class Database implements iDatabase
{
    //this will move out to its own git excluded file and require in
    private $settings = [
        'db_host' => 'localhost',
        'db_port' => '3306',
        'db_name' => 'ftwportal',
        'db_user' => 'ftwportal',
        'db_pass' => 'password',
        'db_charset' => 'utf8'
    ];

    public $pdo;
    public $error;
    protected $res;
    protected $sth;

    public function __construct()
    {
        if (!$this->pdo = new \PDO(
            sprintf(
                'mysql:host=%s;dbname=%s;port=%s;charset=%s',
                $this->settings['db_host'],
                $this->settings['db_name'],
                $this->settings['db_port'],
                $this->settings['db_charset']),
            $this->settings['db_user'],
            $this->settings['db_pass'])
        ) {
            throw new \Exception('Database connection problem');
        }
    }

    public function auth($user, $pass)
    {
        $this->sth = $this->pdo->prepare("SELECT username,password,admin,company"
                . " FROM users WHERE username=?");
        $this->sth->execute(array($user));
        $this->res = $this->sth->fetch(\PDO::FETCH_ASSOC);

        if (!$this->res) {
            $this->error = "Username/Password invalid.";
            return $this->error;
        }

        if (password_verify($pass, $this->res['password']) === TRUE) {
            $_SESSION['user'] = $user;
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['company'] = $this->res['company'];
            if ($this->res['admin'] === 'y') {
                $_SESSION['admin'] = TRUE;
            } else {
                $_SESSION['admin'] = FALSE;
            }
        } else {
            $this->error = "Username/Password invalid.";
            unset($_SESSION['loggedin']);
            return $this->error;
        }
    }

    public function confAvail()
    {
        $this->sth = $this->pdo->prepare("SELECT conf,type FROM confs WHERE company=?");
        $this->sth->execute(array($_SESSION['company']));
        $this->res = $this->sth->fetchAll(\PDO::FETCH_ASSOC);
        if (!$this->res) {
            $this->error = "No configurations available for editing.";
            $_SESSION['error'][] = $this->error;
        } else {
            $confarray = $this->res;
            unset($_SESSION['confs']);
            unset($_SESSION['conftype']);
            for ($i = 0; $i < count($confarray); $i++) {
                $_SESSION['confs'][] = $confarray[$i]['conf'];
                $_SESSION['conftype'][$confarray[$i]['conf']] = $confarray[$i]['type'];
            }
        }
    }
}