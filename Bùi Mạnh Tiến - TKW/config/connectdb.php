<?php
class ConnectDB{
    public static function Connect(){
        $server = "localhost";
        $user = "root";
        $password = "thanh48";
        $db = "doan";

        $conn = new mysqli($server,$user,$password,$db);
        if($conn->connect_error){
            echo("die");
            die("Loi ket noi: ".$conn->connect_error);
        }
        
        return $conn;
    }
}