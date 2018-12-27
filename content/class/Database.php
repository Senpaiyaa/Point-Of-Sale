<?php
    class Database {
        protected static $connection;

        public function __construct() {
            $this->connect();
        }

        public function __destruct() {
            $this->disconnect();
        }


        public function connect() {    
            if(!isset(self::$connection)) {
                $config = parse_ini_file(__DIR__ . '\config.ini');
                self::$connection = new mysqli($config['DB_SERVER'],$config['DB_USER'],"",$config['DB_NAME']);
            } else {
                if (!self::$connection) {
                    die("Database connection/selection failed: " . mysqli_error($connection));
                }
            }
            return self::$connection;
        }

        public function disconnect() {
            if (isset($this->connection)) {
                mysqli_close($this->$connection);
                unset($this->$connection);
            }
        }

        public function query($query) {
            $connection = $this->connect();
            $result = $connection->query($query);

            if ($result === false) {
                echo "There was an error on your sql statement...";
                return false;
            } 

            return $result;
        }
        
        public function select($query) {
            $result = $this->query($query);
            if($result === false) {
                echo "There was an error on your sql statement...";
                return false;
            }
            for ($set = array(); $row = $result->fetch_assoc(); $set[] = $row);
            return $set;
        }

        public function select_row($query, $row = 1){
            $result = $this->select($query);
            if(count($result)===0){
                return NULL;
            }
            return $result[$row-1];
        }

        public function error() {
            $connection = $this->connect();
            if(self::$connection === false) {
                die("Database connection failed. " . mysqli_error($this->$connection));
                return false;
            }
        }

        public function quote($value) {
            $connection = $this->connect();
            return "'" . $connection->real_escape_string($value) . "'";
        }
    }
?>
