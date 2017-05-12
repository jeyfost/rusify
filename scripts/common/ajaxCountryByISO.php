<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 11.05.2017
 * Time: 15:52
 */

include("../connect.php");

$iso = $mysqli->real_escape_string($_POST['iso']);

$countryResult = $mysqli->query("SELECT country FROM isocodes WHERE code = '".$iso."'");
$country = $countryResult->fetch_array(MYSQLI_NUM);

echo $country[0];