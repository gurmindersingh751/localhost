<?php
class access{
    var $host = null;
    var $user = null;
    var $pass = null;
    var $name = null;
    var $conn = null;
    var $results = null;
    function __construct($dbhost, $dbuser, $dbpass, $dbname){
        $this->host = $dbhost;
        $this->user = $dbuser;
        $this->pass = $dbpass;
        $this->name = $dbname;
    }
    public  function connect(){
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
        if(mysqli_connect_errno()){
            echo 'Could not connect to database';
        }
        $this->conn->set_charset("utf8");
    }
    public function disconnect(){
        if($this->conn != null){
        $this->conn->close();
        }
    }

    public function registerUser($username, $password, $salt, $email, $fullname){
        $sql = "INSERT INTO users SET username=?, password=?, salt=?, email=?, fullname=?";
        $statement = $this->conn->prepare($sql);
        if(!$statement){
            throw new Exception($statement->error);
        }
        $statement->bind_param("sssss", $username, $password, $salt, $email,$fullname);
        $returnValue = $statement->execute();
        return $returnValue;
    }
    public function selectUser($username){
        $sql = "SELECT * FROM users where username='".$username."'";
        $result = $this->conn->query($sql);
        if($result != null && (mysqli_num_rows($result) >= 1 )) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            if(!empty($row)){
                $returnArray = $row;
            }
            $returnArray;
        }
    }


    public function getUSER($username){
        $returnArray = array();
        $sql = "SELECT * FROM users WHERE username = '".$username."'";
        $result = $this->conn->query($sql);
        if ($result != null && (mysqli_num_rows($result) >=1)){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row)){
                $returnArray = $row;
            }
        }
        return $returnArray;
    }
    function updateAvaPath($path, $id){
        $sql = "UPDATE users SET ava=? WHERE id=?";
        $statement = $this->conn->prepare($sql);
        if(!$statement){
            throw new Exception($statement->error);
        }
        $statement->bind_param("si", $path, $id);
        $returnValue = $statement->execute();
        return $returnValue;
    }
    public function selectUserViaID($id){
        $returnArray = array();
        $sql = "SELECT * FROM users where id='".$id."'";
        $result = $this->conn->query($sql);
        if($result != null && (mysqli_num_rows($result) >= 1 )) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row)){
                $returnArray = $row;
            }
            
        }
       return $returnArray;
    }
    public function getUserViaID($id){
        $returnArray = array();
        $sql = "SELECT * FROM users WHERE id = '".$id."'";
        $result = $this->conn->query($sql);
        if ($result != null && (mysqli_num_rows($result) >=1)){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row)){
                $returnArray = $row;
            }
        }
        return $returnArray;
    }
    public function selectCars(){
        $returnArray = array();
        $sql = "SELECT * FROM cars";
        $statement = $this->conn->prepare($sql);
        if(!$statement)
        {
            throw new Exception($statement->error);
        }
        $statement->execute();
        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()){
            $returnArray[] = $row;
        }
        return $returnArray;
    }




    // Select user information with Email
    public function selectUserViaEmail($email) {

        $returArray = array();

        // sql command
        $sql = "SELECT * FROM users WHERE email='".$email."'";

        // assign result we got from $sql to $result var
        $result = $this->conn->query($sql);

        // if we have at least 1 result returned
        if ($result != null && (mysqli_num_rows($result) >= 1 )) {

            // assign results we got to $row as associative array
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if (!empty($row)) {
                $returArray = $row;
            }

        }

        return $returArray;

    }

    // Save email confiramtion message's token
    public function saveToken($table, $id, $carid, $token, $make, $model, $price) {

        // sql statement
    $sql = "INSERT INTO emailTokens SET id=?, carid=?, token=?, make=?, model=?, price=?";

        // prepare statement to be executed
        $statement = $this->conn->prepare($sql);

        // error occured
        if (!$statement) {
            throw new Exception($statement->error);
        }

        // bind paramateres to sql statement
        $statement->bind_param("isssss", $id, $carid, $token, $make, $model, $price);

        // launch / execute and store feedback in $returnValue
        $returnValue = $statement->execute();

        return $returnValue;

    }











   
    public function search($word, $make){
        $returnArray = array();
        $sql = "SELECT * FROM cars WHERE not make = '".$make."'";

        if(!empty($word)){
            $sql .= "AND ( make LIKE ? OR model LIKE ? )";
        }
        $statement = $this->conn->prepare($sql);

        if(!$statement){
            throw new Exception($statement->error);
        }
        if(!empty($word)){
            $word = '%' . $word . '%';
            $statement->bind_param("ss", $word, $word);
        }
    
    $statement->execute();
    $result = $statement->get_result();
    while($row = $result->fetch_assoc()){
        $returnArray[] = $row;
    }






    
 return $returnArray;
}
}
?>