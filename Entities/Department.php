<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 19:20
 */

include_once "private/DBEntity.php";

class Department extends DBEntity
{
    private $name = "";

    public function __construct($object)
    {
        parent::__construct($object);
        $this->name = $object->name;
    }

    protected function getValue()
    {
        return "(\"".$this->getId()."\", \"".$this->name."\")";
    }

    protected function getProperty()
    {
        return "(`id`, `name`)";
    }


    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

}