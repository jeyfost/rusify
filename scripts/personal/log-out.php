<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 16:58
 */

session_start();

unset($_SESSION['userID']);
setcookie("rusify_login", "", 0, '/');
setcookie("rusify_password", "", 0, '/');

header("Location: ../../");