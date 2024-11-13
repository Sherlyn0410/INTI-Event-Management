<?php
class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "inti_event_management";
    private $id = "root";
    private $password = "";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->id, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }

    // authenticate user
    public function authenticate($user_id, $password){
        $query = "SELECT * FROM user WHERE id = :id AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            return true;
        } else {
            return false;
        }
    }

    // get user profile
    public function getUserProfile($user_id) {
        $query = "
            SELECT user.*, campus.name AS campus_name
            FROM user
            LEFT JOIN campus ON user.campus_id = campus.id
            WHERE user.id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        if($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    // update user profile image
    public function updateUserProfileImage($user_id, $image) {
        $query = "UPDATE user SET profilePic = :image WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}
?>