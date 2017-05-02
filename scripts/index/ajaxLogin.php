<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 02.05.2017
 * Time: 11:43
 */

session_start();

include("../connect.php");

$login = $mysqli->real_escape_string($_POST['login']);
$password = md5($mysqli->real_escape_string($_POST['password']));

$userCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE password = '".$password."' AND (login = '".$login."' OR email = '".$login."')");
$userCheck = $userCheckResult->fetch_array(MYSQLI_NUM);

if($userCheck[0] > 0) {
	$userIDResult = $mysqli->query("SELECT id FROM users WHERE password = '".$password."' AND (login = '".$login."' OR email = '".$login."')");
	$userID = $userIDResult->fetch_array(MYSQLI_NUM);

	$_SESSION['userID'] = $userID[0];

	echo "ok";
} else {
	echo "failed";
}