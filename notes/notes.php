<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    /*open file
    $file = fopen("data.txt", "w");  // or die("Unable to open file!");
    //write to file
    fwrite($file, "Hello World") ;  //or die("Unable to write to file!");
    //echo $file;
    //close file
    fclose($file);

    //open file
    $file = fopen("data.txt", "r"); // or die("Unable to open file!");
    //read file    
    $content = fgets($file); // or die("Unable to read file!");
    while(feof($file)){
        $content = fgets($file);
        echo $content . "<br>";
    }
    //echo $content;
    //close file
    fclose($file);*/

    ////////////////////////////////////

    // Open file for writing
    $file = fopen("data.txt", "w");
    fwrite($file, "Hello World\n");
    fclose($file);

    // Open file for reading
    $file = fopen("data.txt", "r");

    // Read file correctly
    while(!feof($file)){
        $content = fgets($file);
        echo $content . "<br>";
    }

    fclose($file);

    /* 
    a append , 
    w write , 
    r read, 
    r+ read and write(at the top), 
    a+ read(nothing because cursor is at the end) and append(at the end), 
    w+ read and write (truncate file).
    */
    
    fseek($file, 0); // Move cursor to the beginning of the file.
    rewind($file); // Move cursor to the beginning of the file.
    ftell($file); // Get the current position of the file pointer.

    file_put_contents("data.txt", "New Content\n", FILE_APPEND); // Append to file
    $content = file_get_contents("data.txt"); // Read entire file into a string
    echo nl2br($content); // Convert newlines to HTML line breaks

    $file_ss= file("data.txt"); // Read file into an array of lines
    foreach($file_ss as $line){
        echo $line . "<br>";
    }

    //read
    /*
    1. fread() - Read a specified number of bytes from the file
    2. file_get_contents() - Read the entire file into a string
    3. file() - Read the entire file into an array of lines
    4. readfile() - Read a file and output its contents directly
    
    */ 
    /*
    write
    1. fwrite() - Write data to the file
    2. file_put_contents() - Write a string to a file (can also append)
     */

    ////////////////////////////////////////////////////////////////////////
    //array
    range(2,60, 2);
    range('a','z',1);

    $array = [
        "id" => 1, 
        "name"=> "ali",
        "email" => "mmmmm@gmail.com",
    ];

    sort($array);
    

    //function====================================
    function add($x,$y){
        return $x+$y;
    }

    function add2($x,...$y){
        return $x+$y;
        //written code here isn't accesssable.
    }
    $array =[10,20,30];
    add(10,20); //10->x,20->y;
    add(10,20,30,40,50); //10-x & 20,30,40,50->y;

    //clouser function -> equivalent to anonymuos --> main diff (clouser can access var from the external scope and can be stored in var)
    $x = 10;
    $print_function=function() use($x){
        echo "===";
    };

    $print_function();

    function createCalc($q){
        return function($number) use($q){
            return $number + $q;
        };
    }

    //============================================
    //oop=========================================

    //class 
    /*
    PDO::$count -> static var calling;
    PDO::MSG -? const var calling 
    */
/*
function __set($key,$value){
    if($key=='fname'){
        if(strlen($value)>2){
            $this->$key=$value;
        }
    }
    else if($key=='email'){
        if(filter_var($value,FILTER_VALIDATE_EMAIL)){
            $this->$key = $value;
        }
    }
}

function __get($key){
    return $this->$key;
}
*/
//abstract class ======================================
abstract class car {
    public $name;
    public $model;
    
    abstract function run();
    abstract function speed();
    function normal(){
        //pass;
    }
}

class kia extends car{
    //should have the abstract class
    function run(){

    }
    function speed(){

    }

}
class toyota extends car{
    function run(){

    }
    function speed(){

    }
}
//=====================================================
//interface
interface car_inter{
    function calc_speed();
    function calc_petrol(); 
}

class marcedes implements car_inter{
    function calc_speed(){
        //pass
    }
    function calc_petrol()
    {
        throw new \Exception('Not implemented');
    }
}

//in php extend one class but can implemet multi interface.
//=====================================================
//to extend from multi class -> trait
trait t1{
    public $x;
    private $y;

    function add($x,$y){
        return $this->x+ $this ->y;
    }
}
trait t2{
    public $x;
    function print(){
        echo '$z';
    }
}
class kio extends car{
use t1,t2;
    function run(){

    }
    function speed(){

    }

}
//=====================================================

?>
