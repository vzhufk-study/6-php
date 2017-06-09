<?php
/**
 * Created by PhpStorm.
 * User: zhufy
 * Date: 25.04.2017
 * Time: 21:54
 */

include "private/DBPropertyManager.php";
include_once "Entities/User.php";

$db = new DBPropertyManager();
$db->link();
$db->select_db("blog");
$link = $db->getLink();



$v = new User((object)['id'=>'1', 'login'=>'test', 'password'=>'test', 'email'=>'test@test.com', 'admin'=>true]);
$v->relate($db);
$v->insert();
