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
    }   else    {
        throw new Exception("Connection error ({$this->connection->connect_errno})");
    }
}   

    function prepare(string $query)  {
       if($this -> isConnected)   {
           return  $this->connection -> prepare($query);
       }    else  {
        throw new Exception("Connection error ({$this->connection->connect_errno})");
        return false;
       }
    }

    function getConnection() : mysqli {
        return $this -> connection;
    }

    function isConnected() : bool {
        return $this-> isConnected;
    }
    /* Da modificare con dei prepared statements, più sicuri rispetto alla SQL injection*/
    /* metodo per effettuare query di Selezione ,le quali restituiscono un oggetto mysqli_result*/
    function queryDB(string $query) : array  {
        $queryResult = mysqli_query($this -> connection, $query);
        if($queryResult === false){
            throw new Exception("Connection error ({$this->connection->connect_errno})");
        }
        $result = array();
                if (mysqli_num_rows($queryResult) > 0 )  {
                while( $row = mysqli_fetch_assoc($queryResult) )    {
                    array_push($result,$row);
                }
            }   
                $queryResult->free();
                $this->destroyConnection();
                return $result;
            }  
    /* metodo per effettuare query di operazioni CRUD; di default, mysqli restituisce un booleano*/
    function alterQueryDB(string $query) : bool {
        $queryResult = mysqli_query($this -> connection, $query);
        if($queryResult === false){
            throw new Exception("Connection error ({$this->connection->connect_errno})");
        }
        $this->destroyConnection();
        return $queryResult;
    }

    function destroyConnection() : bool {
        if ($this->connection->close()) {
            $this->isConnected = false;
            return true;
        }
        return false;
    }

}
