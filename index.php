<?php
	session_start();

	if(isset($_SESSION['userID'])) {
		header("Location: school/");
	}

	include("scripts/connect.php");

	if(isset($_SESSION['userID'])) {
		if(isset($_COOKIE['rusify_login']) and isset($_COOKIE['rusify_password'])) {
			setcookie("rusify_login", "", 0, '/');
			setcookie("rusify_password", "", 0, '/');
			setcookie("rusify_login", $_COOKIE['rusify_login'], time() + 60 * 60 * 24 * 30 * 12, '/');
			setcookie("rusify_password", $_COOKIE['rusify_password'], time() + 60 * 60 * 24 * 30 * 12, '/');
		}
		else {
			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
			$user = $userResult->fetch_assoc();
			setcookie("rusify_login", $user['login'], time() + 60 * 60 * 24 * 30 * 12, '/');
			setcookie("rusify_password", $user['password'], time() + 60 * 60 * 24 * 30 * 12, '/');
		}
	} else {
		if(isset($_COOKIE['rusify_login']) and isset($_COOKIE['rusify_password']) and !empty($_COOKIE['rusify_login']) and !empty($_COOKIE['rusify_password'])) {
			$userResult = $mysqli->query("SELECT * FROM users WHERE login = '".$_COOKIE['rusify_login']."'");
			$user = $userResult->fetch_assoc();

			if(!empty($user) and $user['password'] == $_COOKIE['rusify_password']) {
				$_SESSION['userID'] = $user['id'];
			} else {
				setcookie("rusify_login", "", 0, '/');
				setcookie("rusify_password", "", 0, '/');
			}
		}
	}

	if(isset($_SESSION['userID'])) {
		$visitsResult = $mysqli->query("SELECT visits FROM users WHERE id = '".$_SESSION['userID']."'");
		$visits = $visitsResult->fetch_array(MYSQLI_NUM);
		$count = $visits[0] + 1;

		$mysqli->query("UPDATE users SET last_visit = '".date('d-m-Y H:i:s')."', visits = '".$count."' WHERE id = '".$_SESSION['userID']."'");
	}
?>

<!DOCTYPE html>

<!--[if lt IE 7]><html lang="en" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="en" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="en" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->

<html lang="en">

<!--<![endif]-->

<head>

	<title>Rusify</title>

	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="/img/favicon/manifest.json">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="/libs/owl-carousel/owl.carousel.css" />
	<link rel="stylesheet" href="/libs/countdown/jquery.countdown.css" />
	<link rel="stylesheet" href="/libs/unicorn-ui/unicorn-ui.css" />

	<link rel="stylesheet" href="/css/fonts.css" />
	<link rel="stylesheet" href="/css/main.css" />
	<link rel="stylesheet" href="/css/media.css" />

	<!--[if lt IE 9]>
	<script src="/libs/html5shiv/es5-shim.min.js"></script>
	<script src="/libs/html5shiv/html5shiv.min.js"></script>
	<script src="/libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="/libs/respond/respond.min.js"></script>
	<![endif]-->

	<script src="/libs/jquery/jquery-1.11.1.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script src="/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="/libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="/libs/waypoints/waypoints-1.6.2.min.js"></script>
	<script src="/libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="/libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="/libs/countdown/jquery.plugin.js"></script>
	<script src="/libs/countdown/jquery.countdown.min.js"></script>
	<script src="/libs/countdown/jquery.countdown-ru.js"></script>
	<script src="/libs/landing-nav/navigation.js"></script>
	<script src="/libs/notify.js/notify.js"></script>
	<script src="/libs/preloader/preloader.js"></script>

	<script src="/js/common.js"></script>
	<script src="/js/index.js"></script>

	<!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->

</head>

<body>

	<div id="page-preloader"><span class="spinner"></span></div>

	<header class="navbar-fixed-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="logo">
						<a href="/">Rusify</a>
					</div>
					<div class="login-button-container">
						<a href="" class="sign-in-button" data-toggle="modal" data-target="#sign-in"><i class='fa fa-sign-in' aria-hidden='true'></i> Sign in</a><span class="login-text">&nbsp;&nbsp;or&nbsp;&nbsp;</span><a href= "personal/sign-up.php" class="sign-up-button"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign up</a>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="main-left">
						<h1>Learn Russian with live teachers.</h1>
						<h3>Rusify is an effective way to learn Russian. Find your own teacher and start your study!</h3>
					</div>
				</div>
				<div class="col-md-4">
					<div class="main-right">
						<center><h4>Sign up for free</h4></center>
						<form>
							<br />
							<input type="text" name="mainEmail" id="mainEmailInput" placeholder="Email..." class="form-control" required />
							<input type="password" name="mainPassword" id="mainPasswordInput" placeholder="Password..." class="form-control" required />
							<br />
							<button type="button" class="btn btn-success main-sign-up-button">Sign up</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="sign-in" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Sign in to Rusify</h4>
			    </div>
				<div class="modal-body">
					<form class="login-form">
						<br />
						<label for="loginInput"><b>Username or email address</b></label>
						<input type="text" name="login" id="loginInput" class="form-control" autofocus="autofocus" placeholder="Username or email address..." required />
						<br />
						<label for="passwordInput"><b>Password</b></label><a href="" class="modal-link" data-toggle="modal" data-target="#password-reset" data-dismiss="modal" onclick="clearResponseField()">Forgot password?</a>
						<input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password..." required />
					</form>
					<br />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success login-button">Sign in</button>
					<hr />
					<div style="width: 100%; text-align: center;">
						<label>New to Rusify? </label><a href="/personal/sign-up.php" class="modal-link">Create an account.</a>
					</div>
					<br />
					<div class="response-field"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="password-reset" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Reset your password</h4>
			    </div>
				<div class="modal-body">
					<form class="login-form">
						<br />
						<label for="loginInput"><b>Email address</b></label>
						<input type="text" name="email" id="emailInput" class="form-control" autofocus="autofocus" placeholder="Email address..." required />
					</form>
					<br />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success password-reset-button">Reset my password</button>
					<div class="response-field"></div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>