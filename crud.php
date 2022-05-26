<?php
include "config.php";
 
class CRUD extends Config{
    protected $tablename = "siswa";

    public function MainPage(){
        header("location: main.php"); 
    }

    public function LoadData(){
        $sql = $this->conn->prepare("select * from ".$this->tablename);
        $sql->execute();
    
        $data = array();  
        
        foreach($sql as $row)  
        {  
             $sub_array = array();  

             $sub_array[] = $row['nisn'];
             $sub_array[] = $row['nama'];
             $sub_array[] = $row['telp'];
             $sub_array[] = $row['tempat_lahir'];
             $sub_array[] = $row['tanggal_lahir'];
             $sub_array[] = $row['alamat']; 
             $sub_array[] = '<button onclick="Ubah('.$row['id'].');" class="btn btn-sm btn-warning"> Ubah </button> &nbsp; 
                             <button onclick="Hapus('.$row['id'].');" class="btn btn-sm btn-danger"> Delete </button>';
             $data[] = $sub_array;   
        }  
            echo json_encode(array("data"=>$data)); 

    } 
 
    public function SaveData(){  
        
        header('Content-Type: application/json');
        try{
            $data = [
                'id'=>isset($_POST['id']) ? $_REQUEST['id'] : '',
                'nisn'=>isset($_POST['nisn']) ? $_REQUEST['nisn'] : '',
                'nama'=>isset($_POST['nama']) ? $_REQUEST['nama'] : '',
                'tempat_lahir'=>isset($_POST['tempat_lahir']) ? $_REQUEST['tempat_lahir'] : '',
                'tanggal_lahir'=>isset($_POST['tanggal_lahir']) ? $_REQUEST['tanggal_lahir'] : '',
                'telp'=>isset($_POST['telp']) ? $_REQUEST['telp'] : '',
                'alamat'=>isset($_POST['alamat']) ? $_REQUEST['alamat'] : '' 
            ];

            if($data['id'] == '' ){
                $sql = "INSERT INTO siswa (nisn, nama, telp, alamat, tempat_lahir, tanggal_lahir) VALUES (:nisn, :nama, :telp, :alamat, :tempat_lahir, :tanggal_lahir)";
                // $this->conn->prepare($sql)->execute($data)->debugDumpParams(); 
                $binding = $this->conn->prepare($sql);
				$binding->bindParam(":nisn",$data['nisn']);
				$binding->bindParam(":nama", $data['nama']);
                $binding->bindParam(":telp",$data['telp']);
				$binding->bindParam(":alamat", $data['alamat']);
                $binding->bindParam(":tempat_lahir",$data['tempat_lahir']);
				$binding->bindParam(":tanggal_lahir", $data['tanggal_lahir']);
				$binding->execute();
                echo json_encode(array("message"=>"success","code"=>200));
            }else{
                $sql="UPDATE siswa SET nisn=:nisn, nama=:nama, telp=:telp, alamat=:alamat, tempat_lahir=:tempat_lahir, tanggal_lahir=:tanggal_lahir WHERE id=:id";
                $binding = $this->conn->prepare($sql);
                $binding->bindParam(":id",$data['id']);
                $binding->bindParam(":nisn",$data['nisn']);
                $binding->bindParam(":nama",$data['nama']);
                $binding->bindParam(":telp",$data['telp']);
                $binding->bindParam(":alamat",$data['alamat']);
                $binding->bindParam(":tempat_lahir",$data['tempat_lahir']);
                $binding->bindParam(":tanggal_lahir",$data['tanggal_lahir']);
                $binding->execute();
                echo json_encode(array("message"=>"success","code"=>200));
            }
          
        }catch(PDOException $e){
            echo json_encode(array("message"=>$e->getMessage(),"code"=>500));
        }
    }

    public function DestroyData(){
        $id = $_POST['id'];
       
        header('Content-Type: application/json');
        try{
            
            $sql = "DELETE FROM siswa WHERE id = :id";
    
            $this->conn->prepare($sql)->execute(array(':id'=>$id));
 
            echo json_encode(array("message"=>"success","code"=>200));
        }catch(PDOException $e){
            echo json_encode(array("message"=>$e->getMessage(),"code"=>500));
        }
    }
    
    public function GetData(){
        $id = $_GET['id'];
 
        $sql = $this->conn->prepare("SELECT * FROM siswa WHERE id=? LIMIT 1"); 
        $sql->execute([$id]); 
        $row = $sql->fetchObject(); 
        
        echo json_encode($row);
         
    }
} 
?>  