<?php
    class Usuarios{
        // Connection
        private $conn;
        // Table
        private $db_table = "usuarios";
        // Columns
        public $Id;
        public $Dni;
        public $Nombre;
        public $FechaNacimiento;
        public $Apellido;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getEmployees(){
            $sqlQuery = "SELECT Id, Dni , Nombre, Apellido, FechaNacimiento  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createEmployee(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        nombre = :nombre, 
                        fechaNacimiento = :fechaNacimiento, 
                        apellido = :apellido";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nombre=htmlspecialchars(strip_tags($this->nombre));
            $this->dni=htmlspecialchars(strip_tags($this->dni));
            $this->fechaNacimiento=htmlspecialchars(strip_tags($this->fechaNacimiento));
            $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        
            // bind data
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":dni", $this->dni);
            $stmt->bindParam(":fechaNacimiento", $this->fechaNacimiento);
            $stmt->bindParam(":apellido", $this->apellido);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // READ single
        public function getSingleEmployee(){
            try
            {
            $sqlQuery = "SELECT Id, Dni, Nombre, Apellido, FechaNacimiento, FROM". $this->db_table ." WHERE Id = ? LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->Id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['Id'];
            $this->nombre = $dataRow['Nombre'];
            $this->dni = $dataRow['Dni'];
            $this->fechaNacimiento = $dataRow['FechaNacimiento'];
            $this->apellido = $dataRow['Apellido'];
            }
            catch(Exception $e){
                die($e->getMessage());
            } 
        }        
        // UPDATE
        public function updateEmployee(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        nombre = :nombre, 
                        dni = :dni, 
                        fechaNacimiento = :fechaNacimiento, 
                        apellido = :apellido, 
                        created = :created
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nombre=htmlspecialchars(strip_tags($this->nombre));
            $this->dni=htmlspecialchars(strip_tags($this->dni));
            $this->fechaNacimiento=htmlspecialchars(strip_tags($this->fechaNacimiento));
            $this->apellido=htmlspecialchars(strip_tags($this->apellido));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":dni", $this->dni);
            $stmt->bindParam(":fechaNacimiento", $this->fechaNacimiento);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>