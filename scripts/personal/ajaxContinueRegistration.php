<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 11.05.2017
 * Time: 12:26
 */

session_start();

include("../connect.php");
include("../simpleImage.php");
include("../common/mail.php");

function randomName($tmp_name) {
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}

$req = false;
ob_start();

$login = $mysqli->real_escape_string($_POST['login']);
$firstName = $mysqli->real_escape_string($_POST['firstName']);
$lastName = $mysqli->real_escape_string($_POST['lastName']);
$firstName = $mysqli->real_escape_string($_POST['firstName']);
$day = $mysqli->real_escape_string($_POST['day']);
$month = $mysqli->real_escape_string($_POST['month']);
$year = $mysqli->real_escape_string($_POST['year']);
$skype = $mysqli->real_escape_string($_POST['skype']);
$iso = $mysqli->real_escape_string($_POST['country']);
$role = $mysqli->real_escape_string($_POST['role']);
$userID = $mysqli->real_escape_string($_POST['userID']);
$hash = $mysqli->real_escape_string($_POST['hash']);

$month = strlen($month) == 1 ? "0".$month : $month;
$date = $day."-".$month."-".$year;

if(strlen($login) >= 3) {
	$loginCheckResult = $mysqli->query("SELECT COUNT(id) FROM users WHERE login = '".$login."'");
	$loginCheck = $loginCheckResult->fetch_array(MYSQLI_NUM);

	if($loginCheck[0] == 0) {
		if(!empty($_FILES['photo']['tmp_name'])) {
			if($_FILES['photo']['error'] == 0 and substr($_FILES['photo']['type'], 0, 5) == "image") {
				$photoTmpName = $_FILES['photo']['tmp_name'];
				$photoName = randomName($photoTmpName);
				$photoDBName = $photoName.".".substr($_FILES['photo']['name'], count($_FILES['photo']['name']) - 4, 4);
				$photoUploadDir = "../../img/users/";
				$photoUpload = $photoUploadDir.$photoDBName;

				if($userID != '') {
					if($mysqli->query("UPDATE users SET login = '".$login."', skype = '".$skype."', photo = '".$photoDBName."', teacher = '".$role."', iso = '".$iso."', first_name = '".$firstName."', last_name = '".$lastName."', birth_date = '".$date."', active = '".ACCOUNT_ACTIVE."' WHERE id = '".$userID."'")) {
						$img = new SimpleImage($photoTmpName);
						$img->resizeToWidth(USER_PHOTO_WIDTH);
						$img->save($photoUpload);

						$_SESSION['registered'] = 1;

						$emailResult = $mysqli->query("SELECT email FROM users WHERE id = '".$userID."'");
						$email = $emailResult->fetch_array(MYSQLI_NUM);

						sendRegistrationEmail($email[0], $role);

						echo "ok";
					} else {
						echo "failed";
					}
				} else {
					if($mysqli->query("UPDATE users SET login = '".$login."', skype = '".$skype."', photo = '".$photoDBName."', teacher = '".$role."', iso = '".$iso."', first_name = '".$firstName."', last_name = '".$lastName."', birth_date = '".$date."', active = '".ACCOUNT_ACTIVE."' WHERE hash = '".$hash."'")) {
						$img = new SimpleImage($photoTmpName);
						$img->resizeToWidth(160);
						$img->save($photoUpload);

						$_SESSION['registered'] = 1;

						$emailResult = $mysqli->query("SELECT email FROM users WHERE hash = '".$hash."'");
						$email = $emailResult->fetch_array(MYSQLI_NUM);

						sendRegistrationEmail($email[0], $role);

						echo "ok";
					} else {
						echo "failed";
					}
				}
			} else {
				echo "photo";
			}
		} else {
			if($userID != '') {
				if($mysqli->query("UPDATE users SET login = '".$login."', skype = '".$skype."', teacher = '".$role."', iso = '".$iso."', first_name = '".$firstName."', last_name = '".$lastName."', birth_date = '".$date."', active = '".ACCOUNT_ACTIVE."' WHERE id = '".$userID."'")) {
					$_SESSION['registered'] = 1;

					$emailResult = $mysqli->query("SELECT email FROM users WHERE id = '".$userID."'");
					$email = $emailResult->fetch_array(MYSQLI_NUM);

					sendRegistrationEmail($email[0], $role);

					echo "ok";
				} else {
					echo "failed";
				}
			} else {
				if($mysqli->query("UPDATE users SET login = '".$login."', skype = '".$skype."', teacher = '".$role."', iso = '".$iso."', first_name = '".$firstName."', last_name = '".$lastName."', birth_date = '".$date."', active = '".ACCOUNT_ACTIVE."' WHERE hash = '".$hash."'")) {
					$_SESSION['registered'] = 1;

					$emailResult = $mysqli->query("SELECT email FROM users WHERE hash = '".$hash."'");
					$email = $emailResult->fetch_array(MYSQLI_NUM);

					sendRegistrationEmail($email[0], $role);

					echo "ok";
				} else {
					echo "failed";
				}
			}
		}
	} else {
		echo "login";
	}
} else {
	echo "login_length";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;