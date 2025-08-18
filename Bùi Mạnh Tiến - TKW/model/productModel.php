<?php
require_once '../config/connectdb.php';
class Product{
    private $conn;
    function __construct(){
        $this->conn = ConnectDB :: Connect();
    }
    public function getProduct($type) {
        $products = [];
        if (!$this->conn) {
            die("Không có kết nối đến cơ sở dữ liệu");
        } else {
            if ($type == "all") {
                $sql = "SELECT * FROM sanpham";
            } else {
                $sql = "SELECT * FROM sanpham WHERE brand = ?";
            }
    
            $stmt = $this->conn->prepare($sql);
    
            if (!$stmt) {
                die("Error preparing statement: " . $this->conn->error);
            }
    
            if ($type !== "all") {
                $stmt->bind_param("s", $type);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
    
            $stmt->close();
        }
    
        return $products;
    }
    public function searchProducts($searchTerm) {
        $products = [];
        if (!$this->conn) {
            die("Không có kết nối đến cơ sở dữ liệu");
        } else {
            $sql = "SELECT * FROM sanpham WHERE name LIKE ?";
            $searchTerm = '%'.$searchTerm.'%'; 
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing statement: " . $this->conn->error);
            }
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            $stmt->close();
        }
        return $products;
    }
    public function payment($payment,$userId){
        $stmt = $this->conn->prepare("INSERT INTO hoadon (iduser, idsp) VALUES (?, ?)");
        $stmt->bind_param("ss", $userId, $idsp);
        foreach ($payment as $item) {
            $idsp = $item; 
            $stmt->execute();
        }
        $stmt->close();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment']) && isset($_POST['id'])) {
        $payment = $_POST['payment']; 
        $userId = $_POST['id']; 
        $prodcutObj=new Product();
        $prodcutObj->payment($payment,$userId);
        echo json_encode(['status' => 'success', 'message' => 'Dữ liệu đã được lưu thành công']);
    }
} 