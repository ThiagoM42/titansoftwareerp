<?php

namespace BD;

use PDO;
use PDOException;

class Connect
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db_name = 'titan_os_db';
    private $port = '3306'; //porta mysql padrão usada no xampp é 3306, caso utilize outra porta, altere aqui
    private $connect = null;

    public function __construct()
    {
        $this->connect();
    }
    public function connect()
    {

        try {
            $this->connect = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->db_name", $this->username, $this->password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connect;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
