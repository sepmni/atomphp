<?php

// pdo connection
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;

    private $db;
    private $st;
    private $err;

    public function __construct(){
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        try {
            $this->db = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->err = $e->getMessage();
            echo $this->err;
        }
    }

    // prepare statement
    public function query($sql){
        $this->st = $this->db->prepare($sql);
    }

    // bind values
    public function bind($param, $value, $type = null) {
        if(is_null($type)){
            switch ($value) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->st->bindValue($param, $value, $type);
    }

    // execute query
    public function execute(){
        return $this->st->execute();
    }

    // get results as array
    public function resultRows(){
        $this->execute();
        return $this->st->fetchAll(PDO::FETCH_OBJ);
    }

    // get single result
    public function singleRow(){
        $this->execute();
        return $this->st->fetch(PDO::FETCH_OBJ);
    }

    //get count
    public function rowCount(){
        return $this->st->rowCount();
    }
}
