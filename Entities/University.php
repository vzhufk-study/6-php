<?php

/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 28.04.2017
 * Time: 20:52
 */
include_once "Department.php";
include_once "Subject.php";
include_once "Group.php";
include_once "Lector.php";
include_once "Load.php";


class University
{
    private $db;
    private $link;

    private $departments;
    private $subjects;
    private $groups;
    private $lectors;
    private $loads;

    function __construct($db)
    {
        $this->db = $db;
        $this->link = $db->getLink();

        $this->departments = $this->db_select('Department');
        $this->subjects = $this->db_select( 'Subject');
        $this->groups = $this->db_select('Group');
        $this->lectors = $this->db_select( 'Lector');
        $this->loads = $this->db_select( 'Load');


        $this->groups_foreign_keys();
        $this->lectors_foreign_keys();
        $this->loads_foreign_keys();

    }

    function db_select($class_name){
        $property = [];
        $q = "SELECT * FROM  `".$class_name."`";
        $result = $this->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($this->link));
        while ($current = $result->fetch_object()){
            $value = new $class_name($current);
            $value->relate($this->db);
            $property[$current->id] = $value;
        }
        return $property;
    }

    public function groups_foreign_keys(){
        foreach ($this->groups as $group){
            if (! $group->getDepartment() instanceof Department) {
                $group->setDepartment($this->departments[$group->getDepartment()]);
            }
        }
    }

    public function  lectors_foreign_keys(){
        foreach ($this->lectors as $lector){
            if (! $lector->getDepartment() instanceof Department) {
                $lector->setDepartment($this->departments[$lector->getDepartment()]);
            }
        }
    }

    public function loads_foreign_keys(){
        foreach ($this->loads as $load) {
            if (!$load->getLector() instanceof Lector) {
                $load->setLector($this->lectors[$load->getLector()]);
            }
            if (!$load->getSubject() instanceof Subject) {
                $load->setSubject($this->subjects[$load->getSubject()]);
            }
            if (!$load->getGroup() instanceof Group) {
                $load->setGroup($this->groups[$load->getGroup()]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * @param mixed $departments
     */
    public function setDepartments($departments)
    {
        $this->departments = $departments;
    }

    /**
     * @return mixed
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param mixed $subjects
     */
    public function setSubjects($subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return mixed
     */
    public function getLectors()
    {
        return $this->lectors;
    }

    /**
     * @param mixed $lectors
     */
    public function setLectors($lectors)
    {
        $this->lectors = $lectors;
    }

    /**
     * @return mixed
     */
    public function getLoads()
    {
        return $this->loads;
    }

    /**
     * @param mixed $loads
     */
    public function setLoads($loads)
    {
        $this->loads = $loads;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getDepartment($index)
    {
        return $this->departments[$index];
    }

    /**
     * @param $department
     * @param $index
     * @internal param mixed $departments
     */
    public function setDepartment($department, $index)
    {
        $this->departments[$index] = $department;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getSubject($index)
    {
        return $this->subjects[$index];
    }

    /**
     * @param $subject
     * @param $index
     * @internal param mixed $subjects
     */
    public function setSubject($subject, $index)
    {
        $this->subjects[$index] = $subject;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getGroup($index)
    {
        return $this->groups[$index];
    }

    /**
     * @param $group
     * @param $index
     * @internal param mixed $groups
     */
    public function setGroup($group, $index)
    {
        $this->groups[$index] = $group;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getLector($index)
    {
        return $this->lectors[$index];
    }

    /**
     * @param $lector
     * @param $index
     * @internal param mixed $lectors
     */
    public function setLector($lector, $index)
    {
        $this->lectors[$index] = $lector;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getLoad($index)
    {
        return $this->loads[$index];
    }

    /**
     * @param $load
     * @param $index
     * @internal param mixed $loads
     */
    public function setLoad($load, $index)
    {
        $this->loads[$index] = $load;
    }


    # TODO this
    public function sort($property, $field, $order=true){
        $camel_field = str_replace('_', '', ucwords($field, '_'));
        $get = "get".ucfirst($camel_field);
        usort($this->$property, function($a, $b){
            if (is_string($a) && is_string($b)){
                #return strcmp($a->$get(), $b->get())
            }
        });
    }
}