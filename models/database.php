<?php


class Database
{
    protected $connection = null;
    public function __construct()
    {
        try {
            $this->connection = new mysqli("localhost", "root", "", "programmerforce");
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }
    public function createDB(){
        try {
            $newconnection = new mysqli("localhost", "root", "",);
            $sql = "CREATE DATABASE programmerforce";
            $newconnection->query($sql);
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }
    }
    
    function createTable(){
      

        $sql = "CREATE TABLE IF NOT EXISTS inventory (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        quantity INT(6) NOT NULL,
        price VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL
   
        )"; 
        
       if ($this->connection->query($sql) === TRUE) {
            //echo "Table Users created successfully";
          } else {
            echo "Error creating table: " . $GLOBALS['conn']->error;
          }    
    }
 

    public function additem($name,$quantity,$price,$category){
       
        $stmt = $this->connection->prepare("INSERT INTO inventory (name, quantity, price, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $quantity,$price,$category);
        $res=$stmt->execute();
        if($res){
            echo json_encode(['msg' => 'Data insert Successfully!', 'status' => true]);
        }else{
            echo json_encode(['msg' => 'Data Failed to be Inserted!', 'status' => false]);
        }
        
    }
    
        public function updateitem($data){
        $data_str = '' ;
        $id=(int)$data["id"];
        foreach ($data as $column => $value) {
            //append comma each time after first item
            if($column=="id") continue;
            if (!empty($data_str)) $data_str .= ', ' ;
            $data_str .= "$column = '$value'" ;
        }
        
        $sql = "update inventory set $data_str  where id = $id";
        // $sql = "update inventory set name = '$name', quantity = '$quantity', price = '$price', category = '$category' where id = '$id'";
        if (mysqli_query($this->connection, $sql)) {
        echo json_encode(['msg' => 'Data Updated Successfully!', 'status' => true]);
        } else {
        echo json_encode(['msg' => 'Data Failed to be Updated!', 'status' => false]);
        }
        
    }

    public function finditems($id,$isfindall){
         $sql="";
        if($isfindall){
            $sql = "select * from inventory";
        }else{
            $sql = "select * from inventory where id = $id";
        }

        
       
       $result = mysqli_query($this->connection, $sql);
       if (mysqli_num_rows($result) > 0) {
    
       $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
       echo json_encode($data);
       } else {
       echo json_encode(['msg' => 'No Data!', 'status' => false]);
       }
        
    }

    
    public function delitem($id){
       
        $sql = "delete from  inventory where id = '$id'";
        if (mysqli_query($this->connection, $sql)) {
        echo json_encode(['msg' => 'Data Deleted Successfully!', 'status' => true]);
        } else {
        echo json_encode(['msg' => 'Data Failed to be Deleted!', 'status' => false]);
        }
        
    }
      
}

?>