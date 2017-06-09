<?php

/**
 * Created by PhpStorm.
 * User: zhufy
 * Date: 20.04.2017
 * Time: 11:14
 */
class DBPropertyManager
{
    private $username = "root";
    private $password = "1111";
    private $host = "localhost";
    private $database;
    public $link;

    public function __construct($host=null, $username=null, $password=null)
    {
        if ($host != null){
            $this->host = $host;
        }
        if ($username != null){
            $this->username = $username;
        }
        if ($password != null) {
            $this->password = $password;
        }
    }

    public function link(){
        $this->link = mysqli_connect($this->host, $this->username, $this->password) or die("Failed to connect: ".mysqli_error());
    }

    public function  select_db($database_name){
        $this->database = $database_name;
        mysqli_select_db($this->link, $this->database) or die ("Failed to select database:".$this->database);
    }

    public function query($query){
        return mysqpli_query($query) or die("Failed to execute query:".mysqli_error());
    }

    public  function getLink(){
        return $this->link;
    }
}