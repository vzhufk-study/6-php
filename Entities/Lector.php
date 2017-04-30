<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 19:37
 */
include_once "private/DBEntity.php";

class Lector extends DBEntity
{
    private $first_name;
    private $middle_name;
    private $last_name;
    private $post;
    private $birth_date;
    private $department;
    private $hire_date;

    function __construct($object)
    {
        parent::__construct($object);
        $this->first_name = $object->first_name;
        $this->middle_name = $object->middle_name;
        $this->last_name = $object->last_name;
        $this->post = $object->post;
        $this->birth_date = $object->birth_date;
        $this->department = $object->department;
        $this->hire_date = $object->hire_date;
    }


    protected function getProperty()
    {
        return "(`id`, `first_name`, `last_name`, `middle_name`, `post`, `birth_date`, `department`, `hire_date`)";
    }

    protected function getValue()
    {
        return "(\"".$this->getId()."\", \""
            .$this->first_name."\", \""
            .$this->last_name."\", \""
            .$this->middle_name."\", \""
            .$this->post."\", \""
            .$this->birth_date."\", \""
            .$this->department."\", \""
            .$this->hire_date."\")";
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * @param mixed $middle_name
     */
    public function setMiddleName($middle_name)
    {
        $this->middle_name = $middle_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
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
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * @param mixed $hire_date
     */
    public function setHireDate($hire_date)
    {
        $this->hire_date = $hire_date;
    }


}