<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 20:24
 */
include_once "private/DBEntity.php";

class Load extends DBEntity
{
    private $lector;
    private $subject;
    private $group;
    private $salary;
    private $semester;
    private $auditory;

    /**
     * Load constructor.
     * @param $object
     * @internal param $lector
     * @internal param $subject
     * @internal param $group
     * @internal param $salary
     * @internal param $semester
     * @internal param $auditory
     */
    public function __construct($object)
    {
        parent::__construct($object);
        $this->lector = $object->lector;
        $this->subject = $object->subject;
        $this->group = $object->group;
        $this->salary = $object->salary;
        $this->semester = $object->semester;
        $this->auditory = $object->auditory;
    }


    protected function getProperty()
    {
        return "(`id`, `lector`, `subject`, `group`, `salary`, `semester`, `auditory`)";
    }

    protected function getValue()
    {
        return "(\"".$this->getId()."\", \""
            .$this->lector."\", \""
            .$this->subject."\", \""
            .$this->group."\", \""
            .$this->salary."\", \""
            .$this->semester."\", \""
            .$this->auditory."\")";
    }

    /**
     * @return mixed
     */
    public function getLector()
    {
        return $this->lector;
    }

    /**
     * @param mixed $lector
     */
    public function setLector($lector)
    {
        $this->lector = $lector;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getAuditory()
    {
        return $this->auditory;
    }

    /**
     * @param mixed $auditory
     */
    public function setAuditory($auditory)
    {
        $this->auditory = $auditory;
    }





}