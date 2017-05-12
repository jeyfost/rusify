<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 15:59
 */

session_start();

include("../scripts/connect.php");

if(isset($_SESSION['userID'])) {
	header("Location: ../school/");
}

