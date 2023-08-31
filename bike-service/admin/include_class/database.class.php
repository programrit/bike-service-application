<?php

// database class 
class Database
{
    private $db = null;
    private function database_connection()
    {
        if ($this->db == null) {
            $server = "localhost";
            $username = "root";
            $password = "";
            $db_name = "bike_service";

            $conn = new mysqli($server, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("connnection failed: " . $conn->connect_error);
            }else{
                return $conn;
            }
        }else{
            return $this->db;
        }
    }
    public function access_database_connection(){
       return $this->database_connection();
    }
}