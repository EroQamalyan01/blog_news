<?php
class Database {
    private $host = "localhost";
    private $db_name = "news_db";
    private $username = "root"; 
    private $password = "";     
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}

class News {
    private $conn;
    private $table_name = "news";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addNews($title, $content, $author_id) {
        $query = "INSERT INTO " . $this->table_name . " (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author_id);
        return $stmt->execute();
    }

    public function getAllNews() {
        $query = "SELECT n.id, n.title, n.content, n.created_at, u.username FROM " . $this->table_name . " n
                  JOIN users u ON n.author_id = u.id
                  ORDER BY n.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>