<?php

class DBconnection {

    private const HOST_DB = "fandomiadb";
    private const DATABASE = "testdb";
    private const USER = "testuser";
    private const PASSWORD = "testpassword";
    private $connection;
    private $isConnected = false;

    function setConnection() {
        $this -> connection = new mysqli(DBconnection::HOST_DB,
                                         DBconnection::USER ,
                                         DBconnection::PASSWORD , 
                                         DBconnection::DATABASE);
        if ( mysqli_connect_errno() == 0 ){
            $this -> isConnected = true;
            return true;
    }
        return false;
}

    function getConnection() : mysqli {
        return $this -> connection;
    }

    function isConnected() : bool {
        return $this-> isConnected;
    }

    function queryDB(string $query)  {
        $queryResult = mysqli_query($this -> connection, $query) or die("errore in DBacces" .mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) !=0 )  {
                $result = array();
                while( $row = mysqli_fetch_assoc($queryResult) ){
                    array_push($result,$row);
                }
                $queryResult ->free(); 
                DBconnection::destroyConnection();
                return $result;
            }   else {
                return null;
            }
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