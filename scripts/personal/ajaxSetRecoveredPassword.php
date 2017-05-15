<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.05.2017
 * Time: 16:57
 */

include("../connect.php");

$hash = $mysqli->real_escape_string($_POST['hash']);
$password = $mysqli->real_escape_string($_POST['password']);

if($mysqli->query("UPDATE users SET password = '".md5($password)."' WHERE hash = '".$hash."'")) {
	echo "ok";
} else {
	echo "failed";
}