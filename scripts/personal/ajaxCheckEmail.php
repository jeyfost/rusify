<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 17:55
 */

include("../connect.php");

$email = $mysqli->real_escape_string($_POST['email']);

$emailCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE email = '".$email."'");
$emailCheck = $emailCheckResult->fetch_array(MYSQLI_NUM);

if($emailCheck[0] == 0) {
	echo "free";
} else {
	echo "duplicate";
}