<?php

/*
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rrows and results
 */

 class Database {
    // properties
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    // db handler
    private $dbh;
    // db statement
    private $stmt;
    // db errors
    private $error;

    public function __construct()
    {
        // set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // create new pdo instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $error) {
            echo 'Connection failed ' . $error->getMessage();
        }
    }

    // Prepare statement w/ query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values 
    public function bind($param, $value, $type=PDO::PARAM_STR) {
        // check value to see what type it is
        if (is_null($type)) {
            switch($type) {
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

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared sttmt
    public function execute() {
        return $this->stmt->execute();
    }

    // get result set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // get single record as object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
 }