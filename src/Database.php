<?php
namespace ponbiki\FTW;

class Database
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
    public $auth;
    public $error = array();
    public $array;
    
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

    public function auth($user, $token)
    {
        $sth = $this->pdo->prepare("SELECT username,password,admin,company"
                . " FROM users WHERE username=? AND password=?");
        $sth = $sth->execute(array($user, $token));
        $this->array = $sth->fetchObject();
        return $this->array;

    }
}