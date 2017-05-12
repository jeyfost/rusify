<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 17:51
 */

include("../connect.php");

$email = $mysqli->real_escape_string($_POST['email']);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo "valid";
} else {
	echo "not valid";
}