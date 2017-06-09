<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 08.06.2017
 * Time: 19:15
 */

session_start();

// Unset all session values
$_SESSION = array();
// Destroy session
session_destroy();
header('Location: index.php');

?>