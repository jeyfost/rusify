<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 12.05.2017
 * Time: 18:37
 */

include("../connect.php");

//TODO:сделать красивые HTML-рассылки

function sendRegistrationEmail($to, $role) {
	$headers = "Content-type: text/plain; charset=\"utf-8\"\n From: ".DOMAIN_EMAIL_NO_REPLY_FORMATED;

	$subject = "Congratulations!";
	$message = "Welcome to Rusify! \n\nYou have successfully created an account ";

	if($role == USER_STUDENT) {
		$message .= "and now can find a teacher to improve your skill in Russian.";
	} elseif($role == USER_TEACHER) {
		$message .= "and now can find your students.";
	}

	$message .= " \n\nWe wish you good luck and quick success!";

	mail($to, $subject, $message, $headers);
}

function sendPasswordResetEmail($to, $hash) {
	$headers = "Content-type: text/plain; charset=\"utf-8\"\n From: ".DOMAIN_EMAIL_NO_REPLY_FORMATED;

	$subject = "Password recovery";
	$message = "Hello!\n\nYou have requested your password recovery. To update your password, please follow <a href='".DOMAIN_ADDRESS."/personal/password-recovery.php?hash=".$hash."'>this link</a>.\n\nIf that wasn't you, just ignore this message.";

	mail($to, $subject, $message, $headers);
}