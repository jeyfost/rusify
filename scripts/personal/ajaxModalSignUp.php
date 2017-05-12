<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 18:02
 */

session_start();

include("../connect.php");

$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($mysqli->real_escape_string($_POST['password']));

$hash = md5(rand(0, 1000000)."-".date('d-m-Y H:i:s'));

if($mysqli->query("INSERT INTO users (password, email, hash, registered) VALUES ('".$password."', '".$email."', '".$hash."', '".date('d-m-Y H:i:s')."')")) {
	$idResult = $mysqli->query("SELECT id FROM users WHERE hash = '".$hash."'");
	$id = $idResult->fetch_array(MYSQLI_NUM);

	$_SESSION['userID'] = $id[0];

	echo "ok";
} else {
	echo "failed";
}