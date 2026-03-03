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
    

?>
