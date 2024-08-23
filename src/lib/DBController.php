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

    function prepare(string $query)  {
       if($this -> isConnected)   {
           return  $this->connection -> prepare($query);
       }    else  {
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
    function queryDB(string $query)   {
        $queryResult = mysqli_query($this -> connection, $query) or die("errore in DBacces" .mysqli_error($this->connection));
        $result = array();
            if(is_resource($queryResult))   {
                if (mysqli_num_rows($queryResult) > 0 )  {
                while( $row = mysqli_fetch_assoc($queryResult) )    {
                    array_push($result,$row);
                    $queryResult ->free(); 
                }
            }  
            }
            else if ($queryResult)  {
                return true;
                }   else {
                    return false;
                }
            DBconnection::destroyConnection();
            return $result;
    
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