<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 06.05.2017
 * Time: 11:00
 */

session_start();

include("../connect.php");

$email = $mysqli->real_escape_string($_POST['email']);
$password = md5($mysqli->real_escape_string($_POST['password']));

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
	$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

	if($emailCheck[0] == 0) {
		$hash = md5(rand(0, 1000000)."-".date('d-m-Y H:i:s'));

		if($mysqli->query("INSERT INTO users (password, email, hash, registered) VALUES ('".$password."', '".$email."', '".$hash."', '".date('d-m-Y H:i:s')."')")) {
			$idResult = $mysqli->query("SELECT id FROM users WHERE hash = '".$hash."'");
			$id = $idResult->fetch_array(MYSQLI_NUM);

			$_SESSION['userID'] = $id[0];

			echo "ok";
		} else {
			echo "failed";
		}
	} else {
		echo "email-duplicate";
	}
} else {
	echo "email-format";
}