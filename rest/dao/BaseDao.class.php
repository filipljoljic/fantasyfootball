<?php

require_once __DIR__."/../Config.class.php";

class BaseDao {
    private $conn;

    private $table_name;


    /**
     * Class for connection to the database
     */
    public function __construct($table_name){
        try {
            $this->table_name = $table_name;
            $host = "fantasyfootball-do-user-14289897-0.e.db.ondigitalocean.com";
            $user = "doadmin";
            $pass = Config::DB_PASSWORD();
            $schema = "fantasyfootball";
            $port = 25060;

            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => '../../certs/ca-certificate.crt',
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,);
            $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$schema", $user, $pass, $options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected";
        }   catch(PDOException $e){
            echo "Failed: " . $e->getMessage();
            }
        }   

    protected function getTableName() {
        return $this->table_name;
    }

    public function get_all(){
        $stmt = $this->conn->prepare("select * from " . $this->table_name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
    
    public function get_by_id($id){
        $stmt = $this->conn->prepare("select * from ". $this->table_name . " where id=:id");
        $stmt->execute(['id'=> $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;
    }

    public function add($entity){
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach($entity as $column => $value){
            $query.= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query.= ") VALUES (";
        foreach($entity as $column => $value){
            $query.= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query.= ")";

        $stmt = $this->conn->prepare($query); 
        $stmt->execute($entity);
        $entity['id'] = $this->conn->lastInsertId();
        return $entity;
    }

    public function update($entity, $id, $id_column = "id"){    
        $query = "UPDATE " .$this->table_name . " SET ";
        foreach($entity as $column => $value){
            $query.= $column . "=:" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query.= " WHERE ${id_column} = :id";
        
        $stmt = $this->conn->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
        return $entity;
    } 

    protected function query($query, $params){
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = array_keys($data);
        $columns = implode(",", $keys);
        $placeholders = ":" . implode(", :", $keys);

        $query = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function get_user_by_email_test($email) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


?>