<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 19:26
 */

include_once "private/DBEntity.php";

class Group extends DBEntity
{
    private $number;
    private $specialty;
    private $department;
    private $amount;
    public function __construct($object)
    {
        parent::__construct($object);
        $this->number = $object->number;
        $this->specialty = $object->specialty;
        $this->department = $object->department;
        $this->amount = $object->amount;
    }

    protected function getProperty()
    {
        return "(`id`, `number`, `specialty`, `department`, `amount`)";
    }

    protected function getValue()
    {
        return "(\"".$this->getId()."\", \"".$this->number."\", \"".$this->specialty."\", \"".$this->department."\", \"".$this->amount."\")";

    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * @param mixed $specialty
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


}