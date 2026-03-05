<?php
session_start(); 

class DB{
     //holds single instance of this class 
     private static ?DB $instance = null ;

     private PDO $connection ;
     private $host = '127.0.0.1';
     private $db   = 'Student_System';
     private $user = 'root';
     private $pass = 'mrym1609';
     private $port = 3306;
     private $charset = 'utf8mb4';

     private function __construct()
     {
          $dsn = "mysql:host={$this->host};dbname={$this->db};port={$this->port};charset={$this->charset}";
          $options = [
               PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw errors as exceptions
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch as associative arrays
               PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
               ];
          try{
               $this->connection = new PDO($dsn, $this->user, $this->pass, $options);

          }catch(PDOException $e){
               die('connection error' . $e->getMessage());
          }
     }
     public static function getInstance() :static
     {
          if (static::$instance === null){
               static::$instance = new static();
          }
          return static::$instance;
     }
     public function getConnection():PDO{
          return $this->connection;

     }
     //prevent clone (saftey)
     private function __clone(){}
     //prevent unserialization (safety)
     public function __wakeup(){
          throw new \Exception("Cannot unserialize a Singleton.");
     }
}

/*use:
$pdo = Database::getInstance()->getConnection();
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
*/
?>
