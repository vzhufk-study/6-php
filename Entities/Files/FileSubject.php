<?php

/**
 * User: zhufy
 * Date: 07.03.2017
 * Time: 9:53
 */
class FileSubject implements \JsonSerializable
{
    private $name = "";
    private $semester = -1;
    private $hours = 0;
    private $control = 0;
    private $lector = "";

    public function __construct($name, $semester, $hours, $control, $lector)
    {
        $this->name = strval($name);
        $this->semester = abs(intval($semester));
        $this->hours = abs(intval($hours));
        $this->control = abs(intval($control));
        $this->lector = strval($lector);
    }

    /**
     * Construct subject from object
     * @param $object
     * @return FileSubject
     */
    public function object($object){
        $subject = new FileSubject("", 0, 0, 0, "");
        $subject->name = $object['name'];
        $subject->semester = $object['semester'];
        $subject->hours = $object['hours'];
        $subject->control = $object['control'];
        $subject->lector = $object['lector'];
        return $subject;
    }


    /**
     * Form JSONing of class
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
    public function get_name(){
        return $this->name;
    }
    public function get_semester(){
        return $this->semester;
    }
    public function get_hours(){
        return $this->hours;
    }
    public function get_control(){
        return $this->control;
    }
    public function get_lector(){
        return $this->lector;
    }


}

    
$filename = "data";

/**
 * Saves array of subjects to file in json format
 * @param $filename - name of file
 * @param $value - array of subjects
 */
function save($filename, $value){
    $file = fopen($filename, "w");
    fwrite($file, json_encode($value));
    fclose($file);
}

/**
 * Loads JSONEed array of subjects and wake it into subject class
 * @param $filename - name of file
 * @return array - array of subjects
 */
function load($filename){
    $file = fopen($filename, "r");
    $tmp = json_decode(fread($file, filesize($filename)), true);
    fclose($file);
    $result = [];
    foreach($tmp as $value){
        array_push($result, FileSubject::object($value));
    }
    return $result;
}


/**
 * Sorts array of subjects by some filed
 * @param $array - array of Subjects
 * @param $filed - sorting parameter
 * @return mixed - sorted array of Subjects
 */
function sort_by($array, $filed){
    if ($filed === "name"){
        usort($array, function ($a, $b) {
            return strcmp($a->get_name(), $b->get_name());
        });
    }elseif ($filed === "semester") {
        usort($array, function ($a, $b) {
            return $a->get_semester() > $b->get_semester();
        });
    }elseif ($filed === "hours"){
        usort($array, function ($a, $b) {
            return $a->get_hours() > $b->get_hours();
        });
    }elseif ($filed === "control"){
        usort($array, function ($a, $b) {
            return $a->get_control() > $b->get_control();
        });
    }elseif ($filed === "lector"){
        usort($array, function ($a, $b) {
            return strcmp($a->get_lector(), $b->get_lector());
        });
    }
    return $array;
}

/**
 * Gets unique elements from array of Subjects by some field
 * @param $array - array of Subjects
 * @param $field - unique param
 * @return array - unique params of array of Subjects
 */
function unique($array, $field){
    $result = [];
    foreach ($array as $value){
        if ($field === "name"){
            if (!in_array($value->get_name(), $result)){
                array_push($result, $value->get_name());
            }
        }elseif ($field === "semester"){
            if (!in_array($value->get_semester(), $result)){
                array_push($result, $value->get_semester());
            }
        }elseif ($field === "hours"){
            if (!in_array($value->get_hours(), $result)){
                array_push($result, $value->get_hours());
            }
        }elseif ($field === "control"){
            # LOL
            if (!in_array($value->get_control(), $result)) {
                array_push($result, $value->get_control());
            }
        }elseif ($field === "lector") {
            if (!in_array($value->get_lector(), $result)) {
                array_push($result, $value->get_lector());
            }
        }
        }
    return $result;
}

# String lab
function get_subjects_by_messed_string($array, $string){
    $result = [];
    $amount = count($array);
    for ($j = 0; $j < $amount; $j++){
        if (strstr(strtolower($array[$j]->get_name()), strtolower($string))!==false){
            array_push($result, $array[$j]);
            unset($array[$j]);
        }
    }
    return $result;
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}