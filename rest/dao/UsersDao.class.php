<?php


class UsersDao {

    private $conn;

    public function __construct(){
        try {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $schema = "fantasyfootball";
            $this->conn = new PDO("mysql:host=$servername;dbname=$schema", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected";
        }   catch(PDOException $e){
            echo "Failed: " . $e->getMessage();
            }
        } 
         
        public function get_all(){
            $stmt = $this->conn->prepare("select * from users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_by_id($id){
            $stmt = $this->conn->prepare("select * from users where id=:id");
            $stmt->execute(['id'=> $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function delete($id) {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();
            return $result; // This will return true if the deletion was successful
        }
        

        public function add($username, $password, $email){
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email) VALUES :username, :password, :email"); 
            $result = $stmt->execute(['username'=>$username, 'password'=>$password, 'email'=>$email]);
        }

    

    }
?>