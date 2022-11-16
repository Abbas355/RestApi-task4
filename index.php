<?php 
  header("Content-Type:application/json");
  include './models/database.php';
   $req= $_SERVER['REQUEST_URI'];
   $db=new Database();
   
   //first time run code the uncommint below two line please.....
   //$db->createDB();
   //$db->createTable();

   $data = json_decode(file_get_contents("php://input"), true);
   
   if (strpos($req, "/task4_pf/inventory/items") !== false){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
         
            if(setValidater($data)){
                $db->additem($data["name"],$data["quantity"],$data["price"],$data["category"]);
            }
        }else if($_SERVER["REQUEST_METHOD"] == "GET"){  
            if (isset($_GET['id']) && $_GET['id']!=""){    
                $db->finditems($_GET['id'],false);
            }else{ 
                $db->finditems(0,true); 
            }   
        }else{
           echo  "choose correct method";
        }
        
   }else if($req=="/task4_pf/inventory/update" || $req=="/task4_pf/inventory/update/"){  
         
        if(setValidater($data,true)){
            $db->updateitem($data);
        }   
       
   }else if($req=="/task4_pf/inventory/del" || $req=="/task4_pf/inventory/del/"){ 
    if(setValidater($data,true)){
        $db->delitem($data["id"]);
    }  
        
   }else{
      echo "your api link is not correct...";
   }


   function setValidater($data,$isupdate=false):bool{
       if($isupdate){
        if(!(isset($data["id"])&&$data["id"]!="")){
            echo "validation error : id field is must and not null";
            return false;
         }
         return true;
       }
       if(!(isset($data["name"])&&$data["name"]!="")){
            echo "validation error : name field is must and not null";
            return false;
       }
       if(!(isset($data["quantity"])&&$data["quantity"]!="")){
        echo "validation error : quantity field is must and not null";
        return false;
       }
       if(!(isset($data["price"])&&$data["price"]!="")){
        echo "validation error : price field is must and not null";
        return false;
       }  
       if(!(isset($data["category"])&&$data["category"]!="")){
        echo "validation error : category field is must and not null";
        return false;
       }

       return true;
       
   }
?>





