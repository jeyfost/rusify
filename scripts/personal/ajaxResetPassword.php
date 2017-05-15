<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.05.2017
 * Time: 11:21
 */

include("../connect.php");
include("../common/mail.php");

$email = $mysqli->real_escape_string($_POST['email']);

$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

if($emailCheck[0] == 1) {
	$hashResult = $mysqli->query("SELECT hash FROM users WHERE email = '".$email."'");
	$hash = $hashResult->fetch_array(MYSQLI_NUM);

	sendPasswordResetEmail($email, $hash[0]);

	echo "ok";
} else {
	echo "email";
}