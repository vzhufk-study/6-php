<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 18:23
 */
class DBEntity
{
    private $id;
    private $link;
    public function __construct($object)
    {
        $this->id = $object->id;
    }

    public function relate($db){
        $this->link = $db->getLink();
    }

    public function insert(){
       if ($this->isLinked()){
            # Checking if id already in table
            $check = $this->link->query("SELECT * FROM ".$this->getTable()." WHERE `id`=\"".$this->getId()."\"");
            if ($check->num_rows === 0){
                $q = "INSERT INTO ".$this->getTable()." ".$this->getProperty()." VALUES ".$this->getValue();
                $this->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($this->link));
            }else{
                die("ID already exist.");
            }
        }
    }

    public function delete(){
        if ($this->isLinked()){
            $q = "DELETE FROM ".$this->getTable()." WHERE `id`=\"".$this->getId()."\"";
            $this->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($this->link));
        }
    }

    private function isLinked(){
        if(!isset($this->link)){
            die("Data base link is not set...");
            return false;
        }
        return true;
    }

    public function update($property, $value=null){
        $camel_property = str_replace('_', '', ucwords($property, '_'));
        $changed = true;
        $get = "get".ucfirst($camel_property);
        if ($value == null){
            $value = $this->$get();
        }else{
            $changed =  !($value==$this->$get());
            if ($changed) {
                $set = "set" . ucfirst($camel_property);
                $this->$set($value);
            }
        }

        if ($this->isLinked() && $changed){
            $q = "UPDATE ".$this->getTable()." SET `".$property."`=\"".$value."\" WHERE `id`=\"".$this->getId()."\"";
            $this->link->query($q);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    protected function setId($id){
        $this->id = $id;
    }

    protected function getProperty(){
        return "(`property`)";
    }

    protected function getValue(){
        return "(value)";
    }

    public function getTable(){
        return "`".get_called_class()."`";
    }

    function __toString()
    {
        return $this->id;
    }


}