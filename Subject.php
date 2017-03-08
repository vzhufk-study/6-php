<?php

/**
 * User: zhufy
 * Date: 07.03.2017
 * Time: 9:53
 */
class Subject implements \JsonSerializable
{
    private $name = "";
    private $semester = -1;
    private $hours = 0;
    private $control = 0;
    private $lector = "";

    public function __construct($name, $semester, $hours, $control, $lector)
    {
        $this->name = $name;
        $this->semester = $semester;
        $this->hours = $hours;
        $this->control = $control;
        $this->lector = $lector;
    }
    
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

# Saves array of subjects to file in json format
function save($filename, $value){
    $file = fopen($filename, "w");
    fwrite($file, json_encode($value));
    fclose($file);
}

# Loads jsoned array of subjects and wake it into subject class
function load($filename){
    $file = fopen($filename, "r");
    $text = fread($file, filesize($filename));
    $tmp = json_decode($text, true);
    fclose($file);
    $result = [];
    foreach($tmp as $value){
        array_push($result, new Subject($value['name'], intval($value['semester']), intval($value['hours']), intval($value['control']), $value['lector']));
    }
    return $result;
}

# Sorts array of subjects by semester
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

# Finds unique lectors
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
    $tmp = $array;
    $result = [];
    for ($i = 0; $i < count($string); ++$i){
        foreach ($tmp as $value){
            if (!strpos($value->get_name(), $string[i])==false){
                array_push($result, $value);
                array_pop($result, $value);
            }
        }        
    }
    return $result;
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}