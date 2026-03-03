<?php
//mysqli
$connection = new mysqli('localhost', 'root' , 'mrym1609' , 'Student_System', '');

if($connection->connect_errno){
    die("error connection");
};
/*
$connection->query('select * from Student');
$connection->insert_id;
$connection->select_db('ITI_System');

//for execption use php execiption class.
...
*/
//pdo
try{
$connection = new pdo('mysql:host=localhost;dbname=ITI_System', 'root','mrym1609');}
catch(PDOException $e){
    echo $e->getMessage();
}

//exception class
//created at pdo execption class.



?>