<?php

class Database {
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $dbuser = DB_USER;    
    private $dbpw = DB_PW;
    private $stmt;
    private $dbh;
    private $err;
        
    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
       
        $options = array(
            PDO::ATTR_PERSISTENT => true, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        );

        try {
            $this->dbh = new PDO($dsn, $this->dbuser, $this->dbpw, $options);
        } catch(PDOException $e) {
            $this->err = $e->getMessage();
        }
           
    }
    
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
 
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
          switch (true) {
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
          }
        }
        $this->stmt->bindValue($param, $value, $type);
    } 
    
    public function execute() {
        return $this->stmt->execute();
    }
    
    public function result_set() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);   
    }
   
    public function row_count() {
        return $this->stmt->rowCount();
    }
    
    public function last_insert_id() {
        return $this->dbh->lastInsertId();
    }
    
    public function begin_transaction() {
        return $this->dbh->beginTransaction();
    }
    
    public function end_transaction() {
        return $this->dbh->commit();
    }
    
    public function cancel_transaction(){
        return $this->dbh->rollBack();
    }
    
    public function debug_dump_params() {
        return $this->stmt->debugDumpParams();
    }
    
}

?>
