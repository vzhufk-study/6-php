<?php
/**
 * Created by PhpStorm.
 * User: zhufy
 * Date: 25.04.2017
 * Time: 21:54
 */

include "private/DBPropertyManager.php";
include_once "University.php";

$db = new DBPropertyManager();
$db->link();
$db->select_db("University");
$link = $db->getLink();

$u = new University($db);

#$v = new Group((object)['id'=>'1', 'number'=>'302', 'department'=>'1', 'specialty'=>'Applied Math', 'amount'=>'19']);
#$v->relate($db);
#$v->insert();
