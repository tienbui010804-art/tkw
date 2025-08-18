<?php
require_once '../config/connectdb.php';

class User {
    private $conn;

    function __construct() {
        $this->conn = ConnectDB::Connect();
    }

    public function getUser ($account, $password) {
        if (!$this->conn) {
            die("Không có kết nối đến cơ sở dữ liệu");
        }
        $sv = $this->conn->prepare("SELECT * FROM users WHERE account=? AND pass=?");
        $sv->bind_param('ss', $account, $password);
        $sv->execute();
        $result = $sv->get_result();
        $users = []; 
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function handleLogoutRequest() {
        if (isset($_POST['logout'])) {
            $this->logout();
        }
    }
    public function userCurrent($username){
        if (!$this->conn) {
            die("Không có kết nối đến cơ sở dữ liệu");
        }
        $sv = $this->conn->prepare("SELECT id FROM users WHERE username= ? ");
        $sv->bind_param('s', $username);
        $sv->execute();
        $result = $sv->get_result();
        $users = $result->fetch_assoc(); 
        return $users;
    }
    public function signIn($acc,$username,$pass){
        if(!$this->conn){
            die("Không  dữ liệu");
        }
        $sv= $this->conn->prepare("  INSERT INTO  users(account,username,pass) VALUES(?,?,?)");
        $sv->bind_param('sss',$acc,$username,$pass);
        $sv->execute();
        if($sv->affected_rows >0){
            echo "<script>alert('Đăng ký thành công!');</script>";
        }
        else{
            echo "<script>alert('Đăng ký không thành công!');</script>";
        }
    }
}
$user = new User();
$user->handleLogoutRequest(); 
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['account']) && isset($_POST['username']) && isset($_POST['password'])){
        $acc=$_POST['account'];
        $username=$_POST['username'];
        $pass=$_POST['password'];
        echo "<script>alert($acc,$username,$pass);</script>";
        $user->signIn($acc,$username,$pass);
    }
}
?>