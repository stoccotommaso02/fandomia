<?php

class DBconnection {

    private const HOST_DB = "fandomiadb";
    private const DATABASE = "testsdb";
    private const USER = "testuser";
    private const PASSWORD = "testpassword";
    private $connection;
    private $isConnected = false;

    function setConnection() {
        $this -> connection = new mysqli(DBconnection::HOST_DB,
                                         DBconnection::USER ,
                                         DBconnection::PASSWORD , 
                                         DBconnection::DATABASE);
        $this -> isConnected = true;
    }

    function getConnection() : mysqli {
        return $this -> connection;
    }

    function isConnected() : bool {
        return $this-> isConnected;
    }

    function queryDB(string $query) : bool {
        return false;
    }

    function destroyConnection() : bool {
        if ($this->connection->close()) {
            $this->isConnected = false;
            return true;
        }
        return false;
    }

}

?>